<?php

declare(strict_types=1);

namespace App\Http\Resources\API\SocialMedia;

use App\Http\Resources\Resource;
use App\Models\SocialMedia;
use App\Models\SocialMediaAttachment;
use OwenIt\Auditing\Models\Audit;

final class SocialMediaResource extends Resource
{
    protected function getResponse(): array
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->resource;

        $channels = [];

        $boosted = null;

        $isBoosted = false;

        foreach ($socialMedia->getChannels() ?? [] as $channel) {
            $channels[] = $channel['name'] ?? $channel;

            $quantity = $channel['quantity'] ?? 0;

            if ($quantity > 0) {
                $isBoosted = true;
                $boosted[] = $channel;
            }
        }

        if ($isBoosted === false) {
            $boosted = null;
        }

        $result = [
            'id' => $socialMedia->getId(),
            'post' => $socialMedia->getPost(),
            'copy' => $socialMedia->getCopy(),
            'status' => $socialMedia->getStatus(),
            'campaign_type' => $socialMedia->getCampaignType(),
            'client_id' => $socialMedia->getClient()->getId(),
            'channels' => $channels,
            'boosted_channels' => $boosted,
            'notes' => $socialMedia->getNotes(),
            'comments' => new CommentsResource($socialMedia->getComments()),
            'post_date' => $socialMedia->getPostDate()?->toIso8601ZuluString(),
            'created_at' => $socialMedia->getCreatedAtAsString(),
            'created_by' => $socialMedia->getCreatedBy()->getFullName(),
            'updated_by' => $socialMedia->getUpdatedAtAsString(),
        ];

        $attachments = [];

        $attachmentIds = [];

        /** @var SocialMediaAttachment $attachment */
        foreach ($socialMedia->getAttachments() as $attachment) {
            $attachments[] = [
                'name' => $attachment->getFile()?->getOriginalFilename(),
                'file_type' => $attachment->getFile()?->getFileType(),
                'social_media_attachment_id' => $attachment->getId(),
                'url' => $attachment->getFile()?->getUrl(),
                'thumbnail_url' => $attachment->getFile()?->getThumbnailUrl(),
            ];

            $attachmentIds[] = $attachment->getId();
        }

        $audits = Audit::where('auditable_type', 'App\Models\SocialMedia')
            ->where('auditable_id', $socialMedia->getId())
            ->orWhere(function ($query) use ($attachmentIds) {
                if (count($attachmentIds) > 0) {
                    $query->where('auditable_type', 'App\Models\SocialMediaAttachment')
                        ->whereIn('auditable_id', $attachmentIds);
                }
            })
            ->get();

        // @TODO Refactor this or move the logic somewhere else
        /** @var Audit $audit */
        foreach ($audits as $audit) {
            // Skip created social media
            if ($audit->event === 'created' && $audit->auditable_type === 'App\Models\SocialMedia') {
                continue;
            }

            $auditMeta = $audit->getMetadata();

            $user = sprintf(
                '%s %s %s',
                $auditMeta['user_first_name'] ?? '',
                $auditMeta['user_middle_name'] ?? '',
                $auditMeta['user_last_name'] ?? '',
            );

            if ($audit->event === 'updated' && $audit->auditable_type === 'App\Models\SocialMedia') {
                $result['activities'][] = [
                    'action' => 'Modified',
                    'fields' => $audit->getModified(),
                    'user' => $user,
                    'created_at' => $audit->getAttribute('created_at'),
                ];
            }

            if ($audit->event === 'deleted' && $audit->auditable_type === 'App\Models\SocialMedia') {
                $result['activities'][] = [
                    'action' => 'Removed an attachment',
                    'fields' => $audit->getModified(),
                    'user' => $user,
                    'created_at' => $audit->getAttribute('created_at'),
                ];
            }

            if ($audit->auditable_type === 'App\Models\SocialMediaAttachment') {
                $result['activities'][] = [
                    'action' => 'Uploaded an attachment.',
                    'user' => $user,
                    'created_at' => $audit->getAttribute('created_at'),
                ];
            }
        }

        $result['attachments'] = $attachments;

        self::$wrap = null;

        return $result;
    }
}
