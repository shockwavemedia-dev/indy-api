<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Interfaces;

use App\Models\Client;
use App\Models\Tickets\FileFeedback;
use App\Models\User;

interface DeleteFeedbackAttachmentsInterface
{
    public function deleteByFeedback(FileFeedback $feedback, User $user, Client $client): void;
}
