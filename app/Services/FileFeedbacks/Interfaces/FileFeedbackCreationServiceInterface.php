<?php

namespace App\Services\FileFeedbacks\Interfaces;

use App\Models\Tickets\FileFeedback;
use App\Services\FileFeedbacks\Resources\CreateFileFeedbackResource;

interface FileFeedbackCreationServiceInterface
{
    public function create(CreateFileFeedbackResource $resource): FileFeedback;

}
