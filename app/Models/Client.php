<?php

declare(strict_types=1);

namespace App\Models;
use App\Enum\ClientStatusEnum;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\Users\AdminUser;
use App\Models\Users\ClientUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Client extends AbstractModel
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'client_since' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'client_code',
        'address',
        'phone' ,
        'timezone',
        'client_since',
        'main_client_id',
        'overview',
        'rating',
        'status',
        'logo_file_id',
        'designated_designer_id',
        'owner_id',
        'style_guide',
        'note',
    ];

    protected $table = 'clients';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getClientUsers(): ?Collection
    {
        return $this->clientUsers;
    }

    public function getPrinterId(): ?int
    {
        return $this->getAttribute('printer_id');
    }

    public function getPrinter(): ?Printer
    {
        return $this->printer;
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getClientCode(): string
    {
        return $this->getAttribute('client_code');
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function getClientTicketFiles(): Collection
    {
        return $this->clientTicketFiles;
    }

    public function getClientScreens(): Collection
    {
        return $this->clientScreens;
    }

    public function getAddress(): string
    {
        return $this->getAttribute('address');
    }

    public function getPhone(): string
    {
        return $this->getAttribute('phone');
    }

    public function getTimezone(): string
    {
        return $this->getAttribute('timezone');
    }

    public function getClientSince(): DateTimeInterface
    {
        return $this->getAttribute('client_since');
    }

    public function getStyleGuide(): ?string
    {
        return $this->getAttribute('style_guide');
    }

    public function getNote(): ?string
    {
        return $this->getAttribute('note');
    }

    public function getMainClientId(): ?int
    {
        $mainClientId = $this->getAttribute('main_client_id');

        if ($mainClientId === '') {
            return null;
        }

        return $mainClientId;
    }

    public function getOverview(): string
    {
        return $this->getAttribute('overview');
    }

    public function getRating(): ?int
    {
        $rating = $this->getAttribute('rating');

        if ($rating === '') {
            return null;
        }

        return $rating;
    }

    public function getOwnerId(): ?int
    {
        $ownerId = $this->getAttribute('owner_id');

        if ($ownerId === '') {
            return null;
        }

        return $ownerId;
    }

    public function getStatus(): ClientStatusEnum
    {
        $status = $this->getAttribute('status');

        return new ClientStatusEnum($status);
    }

    public function getClientServices(): Collection
    {
        return $this->clientServices;
    }

    public function getClientServiceByService(Service $service): ?ClientService
    {
        /** @var ClientService $clientService|null */
        $clientService = $this->clientServices()
            ->where('service_id', $service->getId())
            ->first();

        return $clientService;
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function getLogo(): ?File
    {
        return $this->logo;
    }

    public function getDesignatedDesigner(): ?AdminUser
    {
        return $this->designatedDesigner;
    }

    public function getLogoFileId(): ?int
    {
        return $this->getAttribute('logo_file_id');
    }

    public function getDesignatedDesignerId(): ?int
    {
        return $this->getAttribute('designated_designer_id');
    }

    public function setName(string $name): self
    {
        $this->setAttribute('name', $name);

        return $this;
    }

    public function setClientCode(string $clientCode): self
    {
        $this->setAttribute('client_code', $clientCode);

        return $this;
    }

    public function setLogoFileId(?int $logoFileId = null): self
    {
        $this->setAttribute('logo_file_id', $logoFileId);

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->setAttribute('address', $address);

        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->setAttribute('phone', $phone);

        return $this;
    }

    public function setTimezone(string $timezone): self
    {
        $this->setAttribute('timezone', $timezone);

        return $this;
    }

    public function setClientSince(DateTimeInterface $clientSince): self
    {
        $this->setAttribute('client_since', $clientSince);

        return $this;
    }

    public function setMainClientId(?int $mainClientId = null): self
    {
        $this->setAttribute('main_client_id', $mainClientId);

        return $this;
    }

    public function setOverview(string $overview): self
    {
        $this->setAttribute('overview', $overview);

        return $this;
    }

    public function setRating(int $rating): self
    {
        $this->setAttribute('rating', $rating);

        return $this;
    }

    public function setStatus(ClientStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function setDesignatedDesignerId(?int $designatedDesignerId = null): self
    {
        $this->setAttribute('designated_designer_id', $designatedDesignerId);

        return $this;
    }

    public function setOwnerId(int $ownerId): self
    {
        $this->setAttribute('owner_id', $ownerId);

        return $this;
    }

    public function setNote(?string $note = null): self
    {
        $this->setAttribute('note', $note);

        return $this;
    }

    public function setPrinterId(int $printerId): self
    {
        $this->setAttribute('printer_id', $printerId);

        return $this;
    }

    public function setStyleGuide(?string $styleGuide = null): self
    {
        $this->setAttribute('style_guide', $styleGuide);

        return $this;
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'client_id');
    }

    public function clientTicketFiles(): HasMany
    {
        return $this->hasMany(ClientTicketFile::class, 'client_id');
    }

    public function clientUsers(): HasMany
    {
        return $this->hasMany(ClientUser::class, 'client_id');
    }

    public function clientServices(): HasMany
    {
        return $this->hasMany(ClientService::class, 'client_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'client_id');
    }

    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'logo_file_id');
    }

    public function designatedDesigner(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'designated_designer_id');
    }

    public function printer(): BelongsTo
    {
        return $this->belongsTo(Printer::class, 'printer_id');
    }

    public function clientScreens(): HasMany
    {
        return $this->hasMany(ClientScreen::class);
    }
}
