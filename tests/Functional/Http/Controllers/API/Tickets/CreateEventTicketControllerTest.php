<?php

declare(strict_types=1);

namespace Tests\Functional\Http\Controllers\API\Tickets;

use Tests\Functional\Http\Controllers\API\AbstractAPITestCase;

/**
 * @covers \App\Http\Controllers\API\Tickets\CreateEventTicketController
 */
final class CreateEventTicketControllerTest extends AbstractAPITestCase
{
    public function testCreateTicketEventSuccess(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
            'email' => 'test@testmail.com'
        ])->user;

        $this->env->clientService([
            'client_id' => $clientUser->getClientId(),
            'service_id' => 1,
        ])->clientService;

        $this->setHeadersToken($user);

        $data =  <<<JSON
        {
            "subject": "Apple Company 23445454",
            "description": "APP214434",
            "duedate": "2034-10-10",
            "requested_by": 1,
            "client_id": 1,
            "services": [{
                    "service_id": 1,
                    "marketing_quota": 0,
                    "extra_quota": 0,
                    "total_used": 0,
                    "is_enable": false,
                    "extras": [
                        "DL",
                        "A4"
                    ]
                }
            ]
        }
        JSON;

        $response = $this->post('/api/v1/tickets/event', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        $this->assertArrayHasKeys(
            [
                'id',
                'status',
                'ticket_code',
                'subject',
                'description',
                'duedate',
                'type',
                'created_at',
            ],
            $arrayResponse
        );
    }

    public function testCreateTicketEventThrowException(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
            'email' => 'test@testmail.com'
        ])->user;

        $this->env->clientService([
            'client_id' => $clientUser->getClientId(),
            'service_id' => 1,
        ])->clientService;

        $this->setHeadersToken($user);

        $data =  <<<JSON
        {
            "subject": "Apple Company 23445454",
            "description": "APP214434",
            "duedate": "2023-10-10",
            "requested_by": 1,
            "client_id": 1,
            "services": [{
                    "service_id": 1,
                    "marketing_quota": 0,
                    "extra_quota": 0,
                    "total_used": 0,
                    "is_enable": false,
                    "extras": [
                        "Facebook",
                        "Twitter"
                    ]
                },
                {
                    "service_id": 2,
                    "marketing_quota": 0,
                    "extra_quota": 0,
                    "total_used": 0,
                    "is_enable": false,
                    "extras": [
                        "DL",
                        "A4"
                    ]
                }
            ]
        }
        JSON;

        $expected = [
            'status' => 400,
            'title' => 'Bad Request',
            'message' => 'Twitter not found.'
        ];

        $response = $this->post('/api/v1/tickets/event', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        self::assertEquals($expected, $arrayResponse);
    }

    public function testCreateTicketEventThrowInvalidDueDate(): void
    {
        $clientUser = $this->env->clientUser()->clientUser;

        $user = $this->env->user([
            'morphable_id' => $clientUser->getId(),
            'morphable_type' => \get_class($clientUser),
            'email' => 'test@testmail.com'
        ])->user;

        $this->env->clientService([
            'client_id' => $clientUser->getClientId(),
            'service_id' => 1,
        ])->clientService;

        $this->setHeadersToken($user);

        $data =  <<<JSON
        {
            "subject": "Apple Company 23445454",
            "description": "APP214434",
            "duedate": "2020-10-10",
            "requested_by": 1,
            "client_id": 1,
            "services": [{
                    "service_id": 1,
                    "marketing_quota": 0,
                    "extra_quota": 0,
                    "total_used": 0,
                    "is_enable": false,
                    "extras": [
                        "DL",
                        "A4"
                    ]
                }
            ]
        }
        JSON;

        $expected = [
            'status' => 400,
            'title' => 'Bad Request',
            'message' => 'Due date should be more than or equal 7 days'
        ];

        $response = $this->post('/api/v1/tickets/event', json_decode($data, true));

        $arrayResponse = $this->toArrayResponse($response);

        self::assertEquals($expected, $arrayResponse);
    }
}
