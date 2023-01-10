<?php

namespace App\Services\StyleGuideComments\Interfaces;

use App\Models\StyleGuideComment;
use App\Services\StyleGuideComments\Resources\CreateStyleGuideCommentResource;

interface StyleGuideCommentFactoryInterface
{
    public function make(CreateStyleGuideCommentResource $resource): StyleGuideComment;
}
