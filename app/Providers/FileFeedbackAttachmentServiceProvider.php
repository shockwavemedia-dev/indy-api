<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\FileFeedbacks\DeleteFeedbackAttachments;
use App\Services\FileFeedbacks\FeedbackAttachmentFactory;
use App\Services\FileFeedbacks\Interfaces\DeleteFeedbackAttachmentsInterface;
use App\Services\FileFeedbacks\Interfaces\ProcessFeedbackAttachmentUploadInterface;
use App\Services\FileFeedbacks\Interfaces\FeedbackAttachmentFactoryInterface;
use App\Services\FileFeedbacks\ProcessFeedbackAttachmentUpload;
use Illuminate\Support\ServiceProvider;

final class FileFeedbackAttachmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            DeleteFeedbackAttachmentsInterface::class => DeleteFeedbackAttachments::class,
            ProcessFeedbackAttachmentUploadInterface::class => ProcessFeedbackAttachmentUpload::class,
            FeedbackAttachmentFactoryInterface::class => FeedbackAttachmentFactory::class,

        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
