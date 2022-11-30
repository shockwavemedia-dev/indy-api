<?php

declare(strict_types=1);

namespace Tests\helpers;

use App\Enum\AdminRoleEnum;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Department;
use App\Models\Emails\EmailLog;
use App\Models\File;
use App\Models\Library;
use App\Models\LibraryCategory;
use App\Models\Service;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Models\Tickets\FileFeedbackAttachment;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketActivity;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use App\Models\Tickets\TicketEmail;
use App\Models\Tickets\TicketEventAttachment;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Models\Users\ClientUser;
use Faker\Factory;
use Faker\Generator;

/**
 * @property \App\Models\Users\AdminUser $adminUser
 * @property \App\Models\Client $client
 * @property \App\Models\ClientService $clientService
 * @property \App\Models\Users\ClientUser $clientUser
 * @property \App\Models\Department $department
 * @property \App\Models\Emails\EmailLogs $emailLogs
 * @property \App\Models\File $file
 * @property \App\Models\LibraryCategory $libraryCategory
 * @property \App\Models\Library $library
 * @property \App\Models\Service $service
 * @property \App\Models\Tickets\Ticket $ticket
 * @property \App\Models\Tickets\TicketActivity $ticketActivity
 * @property \App\Models\Tickets\TicketAssignee $ticketAssignee
 * @property \App\Models\Tickets\TicketAssigneeLink $ticketAssigneeLink
 * @property \App\Models\Tickets\ClientTicketFile $clientTicketFile
 * @property \App\Models\Tickets\FileFeedback $fileFeedback
 * @property \App\Models\Tickets\FileFeedbackAttachment $fileFeedbackAttachment
 * @property \App\Models\Tickets\TicketEmail $ticketEmail
 * @property \App\Models\Tickets\TicketEventAttachment $ticketEventAttachment
 * @property \App\Models\Tickets\TicketNote $ticketNote
 * @property \App\Models\User $user
 */
final class EnvironmentFactory
{
    public static ?EnvironmentFactory $instance = null;

    public Generator $faker;

    /**
     * @var mixed[]
     */
    public array $variables = [];

    public function __construct()
    {
        $this->faker = Factory::create('en_AU');
    }

    public function __get($name)
    {
        if (isset($this->variables[$name]) === true) {
            return $this->variables[$name];
        }
        if (\method_exists($this, $name) === true) {
            $this->{$name}();
        }

        return $this->variables[$name] ?? null;
    }

    public function adminUser(array $params = []): self
    {
        if (isset($params['admin_role']) === false) {
            $params['admin_role'] = AdminRoleEnum::ADMIN;
        }

        $this->variables['adminUser'] = AdminUser::factory()->create($params);

        return $this;
    }

    public function client(array $params = []): self
    {
        $this->variables['client'] = Client::factory()->create($params);

        return $this;
    }

    public function clientService(array $params = []): self
    {
        if (isset($params['client_id']) === false) {
            $client = $this->client()->client;
            $params['client_id'] = $client->getId();
        }

        if (isset($params['created_by']) === false) {
            $user = $this->user()->user;
            $params['created_by'] = $user->getId();
        }

        if (isset($params['service_id']) === false) {
            // Default to  1, no need for service factory we run the service seeder for the test.
            $params['service_id'] = 1;
        }

        $this->variables['clientService'] = ClientService::factory()->create($params);

        return $this;
    }

    public function clientTicketFile(array $params = []): self
    {
        if (isset($params['admin_user_id']) === false) {
            $params['admin_user_id'] = $this->user()
                    ->user
                    ->getUserType()
                    ->getId();
        }

        if (isset($params['client_id']) === false) {
            $client = $this->client()->client;

            $params = array_merge([
                'client_id' => $client->getId(),
            ], $params);
        }

        if (isset($params['file_id']) === false) {
            $file = $this->file()->file;

            $params = array_merge([
                'file_id' => $file->getId(),
            ], $params);
        }

        if (isset($params['ticket_id']) === false) {
            $ticket = $this->ticket()->ticket;

            $params = array_merge([
                'ticket_id' => $ticket->getId(),
            ], $params);
        }

        $this->variables['clientTicketFile'] = ClientTicketFile::factory()->create($params);

        return $this;
    }

    public function clientUser(array $params = []): self
    {
        if ($this->has('client') === false || isset($params['client_id']) === false) {
            $this->client();

            $params = array_merge([
                'client_id' => $this->variables['client']->id,
            ], $params);
        }

        $this->variables['clientUser'] = ClientUser::factory()->create($params);

        return $this;
    }

    /**
     * @deprecated Please use $this->env instead
     */
    public static function create($force = false): self
    {
        if (static::$instance === null || $force === true) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    public function department(array $params = []): self
    {
        $this->variables['department'] = Department::factory()->create($params);

        return $this;
    }

    public function emailLog(array $params = []): self
    {
        if (isset($params['morphable_type']) === false) {
            $ticketAssignee = $this->ticketAssignee()->ticketAssignee;

            $params['morphable_id'] = $ticketAssignee->getId();
            $params['morphable_type'] = \get_class($ticketAssignee);
        }

        $this->variables['emailLog'] = EmailLog::factory()->create($params);

        return $this;
    }

    public function fileFeedbackAttachment(array $params = []): self
    {
        //file
        if (isset($params['file_id']) === false) {
            $file = $this->file()->file;

            $params = array_merge([
                'file_id' => $file->getId(),
            ], $params);
        }

        //clientTicketFile
        if (isset($params['client_file_id']) === false) {
            $clientTicketFile = $this->clientTicketFile()->clientTicketFile;

            $params = array_merge([
                'client_file_id' => $clientTicketFile->getId(),
            ], $params);
        }

        //feedback
        if (isset($params['feedback_id']) === false) {
            $fileFeedback = $this->fileFeedback()->fileFeedback;

            $params = array_merge([
                'feedback_id' => $fileFeedback->getId(),
            ], $params);
        }

        $this->variables['fileFeedbackAttachment'] = FileFeedbackAttachment::factory()->create($params);

        return $this;
    }

    public function file(array $params = []): self
    {
        if (isset($params['uploaded_by']) === false) {
            $user = $this->user()->user;

            $params = array_merge([
                'uploaded_by' => $user->getId(),
            ], $params);
        }

        $this->variables['file'] = File::factory()->create($params);

        return $this;
    }

    public function fileFeedback(array $params = []): self
    {
        //clientTicketFile
        if (isset($params['client_file_id']) === false) {
            $clientTicketFile = $this->clientTicketFile()->clientTicketFile;

            $params = array_merge([
                'client_file_id' => $clientTicketFile->getId(),
            ], $params);
        }

        //user
        if (isset($params['feedback_by']) === false && isset($params['feedback_by_type']) === false) {
            $user = $this->user()->user;

            $params = array_merge([
                'feedback_by' => $user->getId(),
                'feedback_by_type' => $user->getUserType()->getType()->getValue(),
            ], $params);
        }

        $this->variables['fileFeedback'] = FileFeedback::factory()->create($params);

        return $this;
    }

    public function library(array $params = []): self
    {
        if (isset($params['created_by']) === false) {
            $user = $this->user()->user;

            $params['created_by'] = $user->getId();
        }

        if (isset($params['library_category_id']) === false) {
            $libraryCategory = $this->libraryCategory()->libraryCategory;

            $params['library_category_id'] = $libraryCategory->getId();
        }

        $this->variables['library'] = Library::factory()->create($params);

        return $this;
    }

    public function libraryCategory(array $params = []): self
    {
        if (isset($params['created_by']) === false) {
            $user = $this->user()->user;

            $params['created_by'] = $user->getId();
        }

        $this->variables['libraryCategory'] = LibraryCategory::factory()->create($params);

        return $this;
    }

    public function service(array $params = []): self
    {
        $this->variables['service'] = Service::factory()->create($params);

        return $this;
    }

    public function ticket(array $params = []): self
    {
        //client
        if (isset($params['client_id']) === false) {
            $client = $this->client()->client;

            $params = array_merge([
                'client_id' => $client->getId(),
            ], $params);
        }

        //department
        if (isset($params['department_id']) === false) {
            $department = $this->department()->department;

            $params = array_merge([
                'department_id' => $department->getId(),
            ], $params);
        }

        //user
        if (isset($params['created_by']) === false && isset($params['requested_by']) === false && isset($params['created_by_user_type']) === false) {
            $user = $this->user()->user;

            $params = array_merge([
                'created_by' => $user->getId(),
                'requested_by' => $user->getId(),
                'created_by_user_type' => $user->getUserType()->getType()->getValue(),
            ], $params);
        }

        $this->variables['ticket'] = Ticket::factory()->create($params);

        return $this;
    }

    public function ticketActivity(array $params = []): self
    {
        if (isset($params['ticket_id']) === false) {
            $params['ticket_id'] = $this->ticket->getId();
        }

        if (isset($params['user_id']) === false) {
            $params['user_id'] = $this->adminUser->getId();
        }

        $this->variables['ticketActivity'] = TicketActivity::factory()->create($params);

        return $this;
    }

    public function ticketAssignee(array $params = []): self
    {
        if (isset($params['ticket_id']) === false) {
            $params['ticket_id'] = $this->ticket->getId();
        }

        if (isset($params['created_by']) === false) {
            $params['created_by'] = $this->user()->user->getUserType()->getId();
        }

        if (isset($params['admin_user_id']) === false) {
            $params['admin_user_id'] = $this->user()->user->getUserType()->getId();
        }

        if (isset($params['department_id']) === false) {
            $params['department_id'] = $this->department->getId();
        }

        $this->variables['ticketAssignee'] = TicketAssignee::factory()->create($params);

        return $this;
    }

    public function ticketAssigneeLink(array $params = []): self
    {
        if (isset($params['main_assignee_id']) === false) {
            $params['main_assignee_id'] = $this->ticketAssignee()->ticketAssignee->getId();
        }

        if (isset($params['link_assignee_id']) === false) {
            $params['link_assignee_id'] = $this->ticketAssignee()->ticketAssignee->getId();
        }

        $this->variables['ticketAssigneeLink'] = TicketAssigneeLink::factory()->create($params);

        return $this;
    }

    public function ticketEmail(array $params = []): self
    {
        if (isset($params['client_id']) === false) {
            $client = $this->client()->client;

            $params = array_merge([
                'client_id' => $client->getId(),
            ], $params);
        }

        if (isset($params['ticket_id']) === false) {
            $ticket = $this->ticket()->ticket;

            $params = array_merge([
                'ticket_id' => $ticket->getId(),
            ], $params);
        }

        if (isset($params['sender_by']) === false && isset($params['sender_type']) === false) {
            $user = $this->user()->user;

            $params = array_merge([
                'sender_by' => $user->getId(),
                'sender_type' => $user->getUserType()->getType()->getValue(),
            ], $params);
        }

        $this->variables['ticketEmail'] = TicketEmail::factory()->create($params);

        return $this;
    }

    public function ticketEventAttachment(array $params = []): self
    {
        $this->variables['ticketEventAttachment'] = TicketEventAttachment::factory()->create($params);

        return $this;
    }

    public function ticketNote(array $params = []): self
    {
        if (isset($params['ticket_id']) === false) {
            $params['ticket_id'] = $this->ticket->getId();
        }

        if (isset($params['created_by']) === false) {
            $params['created_by'] = $this->adminUser->getId();
        }

        $this->variables['ticketNote'] = TicketNote::factory()->create($params);

        return $this;
    }

    public function user(array $params = [], &$user = null): self
    {
        if (isset($params['morphable_type']) === false) {
            $userType = $this->adminUser()->adminUser;

            $department = $this->department()->department;

            $userType->setDepartments([$department->getId()]);
            $userType->save();

            $params['morphable_id'] = $userType->getId();
            $params['morphable_type'] = \get_class($userType);
        }

        $this->variables['user'] = User::factory()->create($params);

        return $this;
    }

    public function userType(array $params = []): self
    {
        if (\count($params) === 0 || isset($params['adminUser']) === true) {
            $this->adminUser();
        }

        if (isset($params['clientUser']) === true) {
            return $this->clientUser();
        }

        return $this;
    }

    public function has(string $name): bool
    {
        return isset($this->variables[$name]);
    }
}
