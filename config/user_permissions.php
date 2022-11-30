<?php

declare(strict_types=1);

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;

return [
    AdminRoleEnum::PRINT_MANAGER => [
        'modules' => [
            'printer-jobs' => [
                'assign-price' => true,
            ],
            'backend-users' => [
                'ticket-notification-counts' => true,
            ],
            'users' => [
                'read' => false,
                'delete' => false,
                'edit' => false,
                'create' => false,
            ],
            'clients' => [
                'read' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => true,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'departments' => [
                'read' => true,
                'delete' => false,
                'edit' => false,
                'create' => false,
                'read-staffs' => true,
            ],
            'department-tickets' => [
                'read' => true,
            ],

        ],
    ],
    AdminRoleEnum::ADMIN => [
        'modules' => [
            'printer-jobs' => [
                'assign-price' => true,
            ],
            'users' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
            ],
            'clients' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
            ],
            'departments' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'add-members' => true,
                'read-members' => true,
                'read-staffs' => true,
                'remove-members' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => false,
                'assign' => true,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => false,
                'create' => false,
                'edit' => false,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'services' => [
                'read' => true,
                'update' => true,
            ],
            'my-tickets' => [
                'read' => true,
            ],
        ],
    ],
    AdminRoleEnum::ACCOUNT_MANAGER => [
        'modules' => [
            'printer-jobs' => [
                'assign-price' => true,
            ],
            'backend-users' => [
                'ticket-notification-counts' => true,
            ],
            'users' => [
                'read' => false,
                'delete' => false,
                'edit' => false,
                'create' => false,
            ],
            'clients' => [
                'read' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => true,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'departments' => [
                'read' => true,
                'delete' => false,
                'edit' => false,
                'create' => false,
                'read-staffs' => true,
            ],
            'department-tickets' => [
                'read' => true,
            ],

        ],
    ],
    AdminRoleEnum::MANAGER => [
        'modules' => [
            'printer-jobs' => [
                'assign-price' => true,
            ],
            'backend-users' => [
                'ticket-notification-counts' => true,
            ],
            'users' => [
                'read' => false,
                'delete' => false,
                'edit' => false,
                'create' => false,
            ],
            'clients' => [
                'read' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => true,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'departments' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'read-staffs' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'department-tickets' => [
                'read' => true,
            ],
        ],
    ],
    AdminRoleEnum::STAFF => [
        'modules' => [
            'printer-jobs' => [
                'assign-price' => true,
            ],
            'backend-users' => [
                'ticket-notification-counts' => true,
            ],
            'users' => [
                'read' => true,
                'edit' => true,
            ],
            'clients' => [
                'read' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => false,
                'edit' => false,
                'create' => false,
                'create-event' => false,
                'assign' => true,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => false,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
                'create' => false,
                'edit' => false,
            ],
            'services' => [
                'read' => true,
            ],
            'departments' => [
                'read' => true,
                'delete' => false,
                'edit' => false,
                'create' => false,
                'read-staffs' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => false,
                'edit' => false,
                'delete' => false,
            ],
            'my-tickets' => [
                'read' => true,
            ],
        ],
    ],
    ClientRoleEnum::MARKETING => [
        'modules' => [
            'marketing-planner' => [
                'create' => true,
                'edit' => true,
            ],
            'graphics' => [
                'request-create' => true,
            ],
            'users' => [
                'read' => true,
                'edit' => true,
                'create' => true,
                'delete' => true,
            ],
            'clients' => [
                'read' => true,
                'support-request' => true,
            ],
            'tickets-client' => [
                'create' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => false,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'departments' => [
                'read' => true,
                'read-staffs' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => false,
                'edit' => false,
                'delete' => false,
            ],
            'library-ticket' => [
                'create' => true,
            ],
        ],
    ],
    ClientRoleEnum::MARKETING_MANAGER => [
        'modules' => [
            'marketing-planner' => [
                'create' => true,
                'edit' => true,
            ],
            'graphics' => [
                'request-create' => true,
            ],
            'users' => [
                'create' => true,
                'read' => true,
                'edit' => true,
                'delete' => true,
            ],
            'clients' => [
                'read' => true,
                'support-request' => true,
            ],
            'tickets-client' => [
                'create' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => false,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'departments' => [
                'read' => true,
                'read-staffs' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'library-ticket' => [
                'create' => true,
            ],
        ],
    ],
    ClientRoleEnum::GROUP_MANAGER => [
        'modules' => [
            'marketing-planner' => [
                'create' => true,
                'edit' => true,
            ],
            'graphics' => [
                'request-create' => true,
            ],
            'users' => [
                'create' => true,
                'read' => true,
                'edit' => true,
                'delete' => true,
            ],
            'clients' => [
                'read' => true,
                'support-request' => true,
            ],
            'tickets-client' => [
                'create' => true,
            ],
            'tickets' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
                'create-event' => true,
                'assign' => false,
                'create-note' => true,
            ],
            'ticket-emails' => [
                'read' => true,
                'create' => true,
                'edit' => true,
            ],
            'ticket-files' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'approval' => true,
                'delete' => true,
            ],
            'file-feedbacks' => [
                'read' => true,
                'create' => true,
                'edit' => true,
                'delete' => true,
            ],
            'client-services' => [
                'read' => true,
            ],
            'services' => [
                'read' => true,
            ],
            'departments' => [
                'read' => true,
                'read-staffs' => true,
            ],
            'library-categories' => [
                'read' => true,
                'create' => false,
                'edit' => false,
                'delete' => false,
            ],
            'library-ticket' => [
                'create' => true,
            ],
        ],
    ],
];
