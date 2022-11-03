<?php

namespace App\Services\SocialMedia\Interfaces;

use App\Services\SocialMedia\Resources\CreateAttachmentResource;

interface SocialMediaAttachmentFactoryInterface
{
    public function make(CreateAttachmentResource $resource): void;
}
