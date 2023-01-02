<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SocialMediaComment;
use App\Repositories\Interfaces\SocialMediaCommentRepositoryInterface;

final class SocialMediaCommentRepository extends BaseRepository implements SocialMediaCommentRepositoryInterface
{
    public function __construct(SocialMediaComment $model)
    {
        parent::__construct($model);
    }
}
