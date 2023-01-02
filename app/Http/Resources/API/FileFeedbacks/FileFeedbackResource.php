<?php

declare(strict_types=1);

namespace App\Http\Resources\API\FileFeedbacks;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\FileFeedback;

final class FileFeedbackResource extends Resource
{
    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof FileFeedback) === false) {
            throw new InvalidResourceTypeException(
                FileFeedback::class
            );
        }

        /** @var FileFeedback $fileFeedback */
        $fileFeedback = $this->resource;

        $fileAttachment = [];
        foreach ($fileFeedback->getFeedbackAttachments() as $attachment) {
            $fileAttachment[] = [
                'file_id' => $attachment->getFile()->getId(),
                'file_name' => $attachment->getFile()->getOriginalFilename(),
                'file_type' => $attachment->getFile()->getFileType(),
                'file_directory' => $attachment->getFile()->getFilePath(),
                'url' => $attachment->getFile()->getUrl(),
                'url_expiration' => $attachment->getFile()->getUrlExpiration(),
            ];
        }

        $result = [
            'id' => $fileFeedback->getId(),
            'feedback' => $fileFeedback->getFeedback(),
            'client_file_id' => $fileFeedback->getClientTicketFile()->getId(),
            'feedback_by' => \sprintf(
                '%s %s %s',
                $fileFeedback->getFeedbackBy()->getFirstName(),
                $fileFeedback->getFeedbackBy()->getMiddleName(),
                $fileFeedback->getFeedbackBy()->getLastName(),
            ),
            'feedback_by_type' => $fileFeedback->getFeedbackByType(),
            'feedback_attachment' => $fileAttachment,
            'created_at' => $fileFeedback->getCreatedAtAsString(),
        ];

        return $result;
    }
}
