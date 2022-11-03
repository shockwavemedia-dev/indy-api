<?php

namespace App\Http\Requests\API\Clients;

use App\Enum\ClientStatusEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

final class UpdateClientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): ?string
    {
        if ($this->getString('name') === null) {
            return null;
        }

        return $this->getString('name');
    }

    public function getClientCode(): ?string
    {
        if ($this->getString('client_code') === null) {
            return null;
        }

        return $this->getString('client_code');
    }

    public function getLogo(): ?UploadedFile
    {
        if ($this->file('logo') === null) {
            return null;
        }

        return $this->file('logo');
    }

    public function getAddress(): ?string
    {
        if ($this->getString('address') === null) {
            return null;
        }

        return $this->getString('address');
    }

    public function getPhone(): ?string
    {
        if ($this->getString('phone') === null) {
            return null;
        }

        return $this->getString('phone');
    }

    public function getTimezone(): ?string
    {
        if ($this->getString('timezone') === null) {
            return null;
        }

        return $this->getString('timezone');
    }

    public function getClientSince(): ?DateTimeInterface
    {
        if ($this->getString('client_since') === null) {
            return null;
        }

        $clientSince = $this->getString('client_since');

        return new Carbon($clientSince);
    }

    public function getMainClientId(): ?int
    {
        if ($this->getInt('main_client_id') === null) {
            return null;
        }

        return $this->getInt('main_client_id');
    }

    public function getOverview(): ?string
    {
        if ($this->getString('overview') === null) {
            return null;
        }

        return $this->getString('overview');
    }

    public function getRating(): ?int
    {
        if ($this->getInt('rating') === null) {
            return null;
        }

        return $this->getInt('rating');
    }

    public function getStatus(): ? ClientStatusEnum
    {
        if ($this->getString('status') === null) {
            return null;
        }

        $status = $this->getString('status');

        return new ClientStatusEnum($status);
    }

    public function getDesignatedDesignerId(): ?int
    {
        if ($this->getInt('designated_designer_id') === 0) {
            return null;
        }

        return $this->getInt('designated_designer_id');
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getStyleGuide(): ?string
    {
        return $this->getString('style_guide');
    }

    public function getNote(): ?string
    {
        return $this->getString('note');
    }

    public function getPrinterId(): ?int
    {
        if ($this->getInt('printer_id') === 0) {
            return null;
        }

        return $this->getInt('printer_id');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'printer_id' => 'int|nullable',
            'name' => \sprintf('%s,%s','string|unique:App\Models\Client,name',$this->getId()),
            'client_code' => \sprintf('%s,%s','string|unique:App\Models\Client,client_code',$this->getId()),
            'address' => 'string',
            'phone' => 'string',
            'timezone' => 'string',
            'client_since' => 'date',
            'main_client_id' => 'exists:clients,id',
            'overview' => 'string',
            'rating' => 'integer',
            'status' => [
                'string',
                Rule::in(ClientStatusEnum::toArray())
            ],
            'logo' => 'nullable',
            'style_guide' => 'string|nullable',
            'note' => 'string|nullable',
            'designated_designer_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
        ];
    }
}
