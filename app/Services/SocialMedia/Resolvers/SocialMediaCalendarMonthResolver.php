<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resolvers;

use App\Http\Resources\API\SocialMedia\CommentsResource;
use App\Models\Client;
use App\Models\SocialMediaAttachment;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCalendarMonthResolverInterface;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

final class SocialMediaCalendarMonthResolver implements SocialMediaCalendarMonthResolverInterface
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository)
    {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function resolve(Client $client, int $month, int $year): array
    {
        $socialMedias = $this->socialMediaRepository->findByClientMonthAndYear(
            $client,
            $month,
            $year
        );

        $results = [];

        $currentMonthYear = (new Carbon())
            ->month($month)
            ->setYear($year);

        $period = CarbonPeriod::create(
            $currentMonthYear->firstOfMonth()->toDateString(),
            $currentMonthYear->lastOfMonth()->toDateString()
        );

        $attachments = [];

        foreach ($period as $date) {
            $results[$date->toDateString()] = [];

            foreach ($socialMedias as $socialMedia) {
                if ($socialMedia->post_date->toDateString() !== $date->toDateString()) {
                    continue;
                }

                $socialMediaDetails = [
                    'id' => $socialMedia->getId(),
                    'post' => $socialMedia->getPost(),
                    'copy' => $socialMedia->getCopy(),
                    'status' => $socialMedia->getStatus(),
                    'campaign_type' => $socialMedia->getCampaignType(),
                    'client_id' => $socialMedia->getClient()->getId(),
                    'channels' => $socialMedia->getChannels(),
                    'notes' => $socialMedia->getNotes(),
                    'comments' => new CommentsResource($socialMedia->getComments()),
                    'post_date' => $socialMedia->getPostDate()?->toIso8601ZuluString(),
                    'created_at' => $socialMedia->getCreatedAtAsString(),
                    'created_by' => $socialMedia->getCreatedBy()->getFullName(),
                    'updated_by' => $socialMedia->getUpdatedAtAsString(),
                ];

                /** @var SocialMediaAttachment $attachment */
                foreach ($socialMedia->getAttachments() as $attachment) {
                    $attachments[] = [
                        'name' =>  $attachment->getFile()?->getOriginalFilename(),
                        'file_type' =>  $attachment->getFile()?->getFileType(),
                        'social_media_attachment_id' => $attachment->getId(),
                        'url' => $attachment->getFile()?->getUrl(),
                        'thumbnail_url' => $attachment->getFile()?->getThumbnailUrl(),
                    ];
                }

                $socialMediaDetails['attachments'] = $attachments;

                $results[$date->toDateString()][] = $socialMediaDetails;
            }
        }

        return $results;
    }
}
