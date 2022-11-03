<?php

namespace App\Services\SocialMedia\Interfaces;

use App\Models\SocialMediaComment;
use App\Services\SocialMedia\Resources\CreateCommentResource;

interface SocialMediaCommentFactoryInterface
{
    public function make(CreateCommentResource $resource): SocialMediaComment;
}
