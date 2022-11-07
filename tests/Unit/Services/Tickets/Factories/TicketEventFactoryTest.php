<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Factories;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Enum\TicketTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Department;
use App\Models\File;
use App\Models\Tickets\TicketEvent;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\Tickets\Factories\TicketEventFactory;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;
use Google\Cloud\Storage\Bucket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\Stubs\Services\Departments\DepartmentTicketNotificationHandlerStub;
use Tests\Stubs\Services\Tickets\Factories\TicketEventAttachmentFactoryStub;
use Tests\TestCase;
use Tests\Stubs\Repositories\TicketEventRepositoryStub;
use Tests\Stubs\Repositories\TicketRepositoryStub;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;
use Tests\Stubs\Services\FileManager\FileUploaderStub;
use Tests\Stubs\Services\Files\FileFactoryStub;
use Tests\Stubs\Services\Tickets\Factories\TicketServicesFactoryStub;

// @TODO Refactor and complete the test
/**
 * @covers \App\Services\Tickets\Factories\TicketEventFactory
 */
final class TicketEventFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function testCreateSuccessWithAttachment(): void
    {
        $this->markTestSkipped('Needs to be revisit and refactor');
        $ticket = $this->env->ticket;

        $ticketEvent = new TicketEvent();
        $ticketEvent->setAttribute('id', 1000000);
        $ticketEvent->ticket()->associate($ticket);
        $ticketEvent->save();

        $client = new Client();
        $clientServiceCollection = new Collection();

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);
        $file->setFileName('avatar.jpg');
        $file->setFilePath('/');
        $file->setBucket('bucket');
        $file->setOriginalFilename('test');
        $file->setFileSize(12);
        $file->setFileType('test');
        $file->setDisk('test');
        $file->setAttribute('uploaded_by', $this->env->user->getId());
        $file->save();

        $clientService = new ClientService();
        $clientService->setAttribute('service_id', 1);

        $clientServiceCollection->add($clientService);

        $client->setRelation('clientServices', $clientServiceCollection);
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

        $services = [
            [
                'service_id' => 1,
                'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
            ],
        ];

        $resource = new CreateTicketResource([
            'attachments' => [$uploadedFile],
            'client' => $client,
            'createdBy' => $createdBy,
            'department' => $department,
            'requestedBy' => $requestedBy,
            'description' => 'test',
            'dueDate' => $dueDate,
            'subject' => 'test',
            'type' => new TicketTypeEnum(TicketTypeEnum::PROJECT),
            'services' => $services
        ]);

        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('name')
            ->andReturn('bucket')
            ->getMock();

        $bucketFactory = new BucketFactoryStub([
            'make' => $bucket,
        ]);

        $fileFactory = new FileFactoryStub([
            'make' => $file,
        ]);

        $ticketEventAttachmentFactory = new TicketEventAttachmentFactoryStub([
            'make' => $this->env->ticketEventAttachment([
                'ticket_event_id' => $ticketEvent->getId(),
                'file_id' => $file->getId(),
            ])->ticketEventAttachment,
        ]);

        $fileUploader = new FileUploaderStub([
            'upload'
        ]);

        $repository = new TicketRepositoryStub([
            'countTicketByClient' => 1,
            'create' => $ticket,
        ]);

        $eventRepository = new TicketEventRepositoryStub([
            'create' => $ticketEvent
        ]);

        $ticketServicesFactory = new TicketServicesFactoryStub();

        $resolver = new TicketEventFactory(
            $bucketFactory,
            new DepartmentTicketNotificationHandlerStub(),
            $fileFactory,
            $fileUploader,
            $eventRepository,
            $ticketEventAttachmentFactory,
            $repository,
            $ticketServicesFactory,
        );

        $expectedCalls = [
            'bucketFactory' => [
                [
                    'make' => [
                        'test',
                    ],
                ],
            ],
            'ticketRepository' => [
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
                            'type' => new TicketTypeEnum(TicketTypeEnum::PROJECT),
                            'duedate' => $dueDate,
                        ],
                    ],
                ],
            ],
            'eventRepository' => [
                [
                    'create' => [
                        [
                            'ticket_id' => $ticket->getId(),
                            'duedate' => $dueDate,
                        ],
                    ],
                ],
            ],
            'ticketServicesFactory' => [
                [
                    'make' => [
                        $clientServiceCollection,
                        $ticket,
                        $createdBy,
                        $resource->getServices(),
                    ],
                ],
            ],
        ];

        $resolver->create($resource);

        $actualCalls = [
            'bucketFactory' => $bucketFactory->getCalls(),
            'ticketRepository' => $repository->getCalls(),
            'eventRepository' => $eventRepository->getCalls(),
            'ticketServicesFactory' => $ticketServicesFactory->getCalls(),
        ];

        $this->assertEquals($expectedCalls, $actualCalls);
    }

    /**
     * @dataProvider getSupportTestCase
     */
    public function testSupports(bool $expected, TicketTypeEnum $ticketTypeEnum): void
    {
        $this->markTestSkipped('Needs to be revisit and refactor');

        $bucketFactory = new BucketFactoryStub();

        $fileFactory = new FileFactoryStub();

        $fileUploader = new FileUploaderStub();

        $repository = new TicketRepositoryStub();

        $eventRepository = new TicketEventRepositoryStub();

        $ticketEventAttachmentFactory = new TicketEventAttachmentFactoryStub();

        $ticketServicesFactory = new TicketServicesFactoryStub();

        $resolver = new TicketEventFactory(
            $bucketFactory,
            new DepartmentTicketNotificationHandlerStub(),
            $fileFactory,
            $fileUploader,
            $eventRepository,
            $ticketEventAttachmentFactory,
            $repository,
            $ticketServicesFactory,
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
            'userType' => new TicketTypeEnum(TicketTypeEnum::GRAPHIC)
        ];

        yield 'Supports false' => [
            'expected' => true,
            'userType' => new TicketTypeEnum(TicketTypeEnum::PROJECT)
        ];
    }
}
