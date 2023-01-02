<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SocialMediaAttachmentRepositoryInterface
{
    public function findByIds(array $ids): Collection;
}
