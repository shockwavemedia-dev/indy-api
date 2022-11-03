<?php

namespace App\Services\Graphics\Interfaces\Factories;

use App\Models\Tickets\Ticket;
use App\Services\Graphics\Resources\CreateGraphicRequestResource;

interface GraphicRequestFactoryInterface
{
    public function make(CreateGraphicRequestResource $resource): Ticket;
}
