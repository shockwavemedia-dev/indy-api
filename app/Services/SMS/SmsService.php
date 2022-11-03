<?php

declare(strict_types=1);

namespace App\Services\SMS;

use App\Services\SMS\Interfaces\SmsClientInterface;
use App\Services\SMS\Interfaces\SmsServiceInterface;
use App\Services\SMS\Resources\SmsContactListResponse;
use App\Services\SMS\Resources\SmsContactListsResponse;
use App\Services\SMS\Resources\SmsMessagesResponse;
use Illuminate\Support\Arr;

final class SmsService implements SmsServiceInterface
{
    private SmsClientInterface $smsClient;

    public function __construct(SmsClientInterface $smsClient) {
        $this->smsClient = $smsClient;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getContactList(): SmsContactListsResponse
    {
        $response = $this->smsClient->makeRequest('GET', 'get-lists.json');

        return new SmsContactListsResponse($response);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getContactListWithDetails(int $listId): SmsContactListResponse
    {
        $options = [
            'header' => [
                'Content-type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'list_id' => $listId,
            ],
        ];

        $response = $this->smsClient->makeRequest('POST', 'get-list.json', $options);

        return new SmsContactListResponse($response);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function getMessages(?array $options = []): SmsMessagesResponse
    {
        $options = [
            'query' =>  [
                'start' => '2021-01-01',
                'page' => Arr::get($options, 'page'),
                'max' => Arr::get($options, 'max'),
            ]
        ];

        $response = $this->smsClient->makeRequest('POST', 'get-user-sms-sent.json', $options);

        return new SmsMessagesResponse($response);
    }
}
