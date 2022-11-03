<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface EloquentRepositoryInterface
 * @package App\Repositories
 */
interface EloquentRepositoryInterface
{
    
    public function create(array $attributes): Model;

    public function delete(Model $model): void;

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id): ?Model;
}
