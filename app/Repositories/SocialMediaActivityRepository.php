<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SocialMediaActivity;
use App\Repositories\Interfaces\SocialMediaActivityRepositoryInterface;

final class SocialMediaActivityRepository extends BaseRepository implements SocialMediaActivityRepositoryInterface
{
    public function __construct(SocialMediaActivity $model)
    {
        parent::__construct($model);
    }
}
