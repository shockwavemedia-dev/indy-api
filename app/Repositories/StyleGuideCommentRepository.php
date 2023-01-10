<?php

namespace App\Repositories;

use App\Models\StyleGuideComment;
use App\Repositories\Interfaces\StyleGuideCommentRepositoryInterface;

final class StyleGuideCommentRepository extends BaseRepository implements StyleGuideCommentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new StyleGuideComment());
    }
}
