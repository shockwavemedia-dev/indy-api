<?php

namespace App\Services\SMS\Interfaces;

use App\Services\SMS\Resources\SmsContactListResponse;
use App\Services\SMS\Resources\SmsContactListsResponse;
use App\Services\SMS\Resources\SmsMessagesResponse;

interface SmsServiceInterface
{
    public function getContactList(): SmsContactListsResponse;

    public function getContactListWithDetails(int $listId): SmsContactListResponse;

    public function getMessages(): SmsMessagesResponse;
}
