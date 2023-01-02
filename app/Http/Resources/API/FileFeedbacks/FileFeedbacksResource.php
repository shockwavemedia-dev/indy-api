<?php

declare(strict_types=1);

namespace App\Http\Resources\API\FileFeedbacks;

use App\Http\Resources\Resource;

final class FileFeedbacksResource extends Resource
{
    protected function getResponse(): array
    {
        $fileFeedbacks = [];

        foreach ($this->resource as $feedback) {
            $fileFeedbacks['data'][] = new FileFeedbackResource($feedback);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $fileFeedbacks['page'] = $this->paginationResource($this->resource);

        return $fileFeedbacks;
    }
}
