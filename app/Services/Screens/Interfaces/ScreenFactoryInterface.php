<?php

namespace App\Services\Screens\Interfaces;

use App\Models\Screen;
use App\Services\Screens\Resources\CreateScreenResource;

interface ScreenFactoryInterface
{
    public function make(CreateScreenResource $screenResource): Screen;
}
