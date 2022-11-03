<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Factories;

use App\Enum\TicketTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\Tickets\Factories\GenericTicketFactory;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Tests\Stubs\Repositories\TicketRepositoryStub;
use Tests\Stubs\Services\Departments\DepartmentTicketNotificationHandlerStub;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;
use Tests\Stubs\Services\Tickets\Factories\TicketServicesFactoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Tickets\Factories\GenericTicketFactory
 */
final class GenericTicketFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateSuccess(): void
    {
        $this->markTestSkipped('Needs to be revisit and refactor');
        $ticket = new Ticket();

        $client = new Client();
        $client->setAttribute('client_code', 'test');
        $client->setAttribute('id', 1);

        $adminUser = new AdminUser();

        $createdBy = new User();
        $createdBy->setRelation('userType',$adminUser);
        $createdBy->setAttribute('id', 1);

        $requestedBy = new User();
        $requestedBy->setAttribute('id', 2);

        $department = new Department();
        $department->setAttribute('id', 1);

        Carbon::setTestNow(new Carbon('2020-10-10 09:09:09'));

        $dueDate = new Carbon();

        $resource = new CreateTicketResource([
            'client' => $client,
            'createdBy' => $createdBy,
            'department' => $department,
            'requestedBy' => $requestedBy,
            'description' => 'test',
            'dueDate' => $dueDate,
            'subject' => 'test',
            'type' => new TicketTypeEnum(TicketTypeEnum::EVENT),
        ]);

        $repository = new TicketRepositoryStub([
            'countTicketByClient' => 1,
            'create' => $ticket,
        ]);

        $bucketFactory = new BucketFactoryStub([
            'make' => new Bucket(new Rest([]), 'test')
        ]);

        $ticketServiceFactory = new TicketServicesFactoryStub();

        $resolver = new GenericTicketFactory(
            $bucketFactory,
            new DepartmentTicketNotificationHandlerStub(),
            $repository,
            $ticketServiceFactory
        );

        $expectedCalls = [
            [
                'countTicketByClient' => [
                          $client
                ],
            ],
            [
                'create' => [
                    [
                        'client_id' => 1,
                        'created_by' => 1,
                        'created_by_user_type' => new UserTypeEnum(UserTypeEnum::ADMIN),
                        'requested_by' => 2,
                        'department_id' => 1,
                        'ticket_code' => 'test-2',
                        'status' => 'new',
                        'description' => 'test',
                        'subject' => 'test',
                        'type' => new TicketTypeEnum(TicketTypeEnum::EVENT),
                        'duedate' => $dueDate,
                    ],
                ],
            ],
        ];

        $resolver->create($resource);

        $this->assertEquals($expectedCalls, $repository->getCalls());
    }

    /**
     * @dataProvider getSupportTestCase
     */
    public function testSupports(bool $expected, TicketTypeEnum $ticketTypeEnum): void
    {
        $this->markTestSkipped('Needs to be revisit and refactor');

        $resolver = new GenericTicketFactory(
            new BucketFactoryStub(),
            new DepartmentTicketNotificationHandlerStub(),
            new TicketRepositoryStub(),
            new TicketServicesFactoryStub()
        );

        $this->assertEquals($expected, $resolver->supports($ticketTypeEnum));
    }

    /**
     * Data provider.
     */
    public function getSupportTestCase(): iterable
    {
        yield 'Supports true' => [
            'expected' => false,
            'userType' => new TicketTypeEnum(TicketTypeEnum::EVENT)
        ];

        yield 'Supports false' => [
            'expected' => true,
            'userType' => new TicketTypeEnum(TicketTypeEnum::GRAPHIC)
        ];
    }
}
