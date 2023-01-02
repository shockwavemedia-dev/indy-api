<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SocialMediaAttachment;
use App\Repositories\Interfaces\SocialMediaAttachmentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class SocialMediaAttachmentRepository extends BaseRepository implements SocialMediaAttachmentRepositoryInterface
{
    public function __construct(SocialMediaAttachment $model)
    {
        parent::__construct($model);
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}
