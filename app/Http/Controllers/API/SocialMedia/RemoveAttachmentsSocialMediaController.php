<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SocialMedia\RemoveAttachmentsSocialMediaRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Jobs\File\RemoveFileJob;
use App\Models\SocialMedia;
use App\Models\SocialMediaAttachment;
use App\Repositories\Interfaces\SocialMediaAttachmentRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use OwenIt\Auditing\Events\AuditCustom;

final class RemoveAttachmentsSocialMediaController extends AbstractAPIController
{
    private FileRemoverInterface $fileRemover;

    private SocialMediaAttachmentRepositoryInterface $socialMediaAttachmentRepository;

    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(
        SocialMediaAttachmentRepositoryInterface $socialMediaAttachmentRepository,
        SocialMediaRepositoryInterface $socialMediaRepository,
        FileRemoverInterface $fileRemover
    ) {
        $this->fileRemover = $fileRemover;
        $this->socialMediaAttachmentRepository = $socialMediaAttachmentRepository;
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function __invoke(RemoveAttachmentsSocialMediaRequest $request, int $id): JsonResource
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->find($id);

        if ($socialMedia === null) {
            return $this->respondNotFound([
                'message' => 'Social Media not found',
            ]);
        }
        if ($request->getAttachmentIds() === null) {
            return new SocialMediaResource($socialMedia);
        }

        $attachments = $this->socialMediaAttachmentRepository->findByIds($request->getAttachmentIds());

        /** @var SocialMediaAttachment $attachment */
        foreach ($attachments as $attachment) {
            $socialMedia->auditEvent = 'deleted';
            $socialMedia->isCustomEvent = true;
            $socialMedia->auditCustomOld = [
                'attachment' => $attachment->getFile()->getOriginalFilename(),
            ];
            $socialMedia->auditCustomNew = [
                'attachment' => '',
            ];

            Event::dispatch(AuditCustom::class, [$socialMedia]);

            RemoveFileJob::dispatch(
                $attachment->getFile()->getId(),
                $this->getUser()->getId()
            );

            $attachment->delete();
        }

        return new SocialMediaResource($socialMedia);
    }
}
