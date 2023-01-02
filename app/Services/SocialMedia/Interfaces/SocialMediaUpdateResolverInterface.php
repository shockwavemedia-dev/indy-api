<?php

namespace App\Services\SocialMedia\Interfaces;

use App\Models\SocialMedia;

interface SocialMediaUpdateResolverInterface
{
    public function update(SocialMedia $socialMedia, array $changes): SocialMedia;
}
