<?php

namespace App\Services\SocialMedia\Interfaces;

use App\Models\SocialMedia;
use App\Services\SocialMedia\Resources\CreateSocialMediaResource;

interface SocialMediaFactoryInterface
{
    public function make(CreateSocialMediaResource $resource): SocialMedia;
}
