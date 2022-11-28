<?php

namespace App\Http\Requests\API\Clients;

use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Http\UploadedFile;

final class CreateClientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getClientCode(): string
    {
        return $this->getString('client_code');
    }

    public function getLogo(): ?UploadedFile
    {
        if ($this->file('logo') === null) {
            return null;
        }

        return $this->file('logo');
    }

    public function getAddress(): string
    {
        return $this->getString('address');
    }

    public function getPhone(): string
    {
        return $this->getString('phone');
    }

    public function getTimezone(): string
    {
        return $this->getString('timezone');
    }

    public function getClientSince(): DateTimeInterface
    {
        $clientSince = $this->getString('client_since');

        return new Carbon($clientSince);
    }

    public function getMainClientId(): ?int
    {
        return $this->getInt('main_client_id');
    }

    public function getOverview(): string
    {
        return $this->getString('overview');
    }

    public function getRating(): ?int
    {
        return $this->getString('rating');
    }

    public function getDesignatedAnimatorId(): ?int
    {
        if ($this->getInt('designated_animator_id') === 0) {
            return null;
        }

        return $this->getInt('designated_animator_id');
    }

    public function getDesignatedWebEditorId(): ?int
    {
        if ($this->getInt('designated_web_editor_id') === 0) {
            return null;
        }

        return $this->getInt('designated_web_editor_id');
    }

    public function getDesignatedSocialMediaManagerId(): ?int
    {
        if ($this->getInt('designated_social_media_manager_id') === 0) {
            return null;
        }

        return $this->getInt('designated_social_media_manager_id');
    }

    public function getDesignatedPrinterManagerId(): ?int
    {
        if ($this->getInt('designated_printer_manager_id') === 0) {
            return null;
        }

        return $this->getInt('designated_printer_manager_id');
    }

    public function getDesignatedDesignerId(): ?int
    {
        if ($this->getInt('designated_designer_id') === 0) {
            return null;
        }

        return $this->getInt('designated_designer_id');
    }

    public function getStyleGuide(): ?string
    {
        return $this->getString('style_guide');
    }

    public function getNote(): ?string
    {
        return $this->getString('note');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\Client,name',
            'client_code' => 'nullable|string|unique:App\Models\Client,client_code',
            'address' => 'required|string',
            'phone' => 'required|string',
            'timezone' => 'required|string',
            'client_since' => 'required|date',
            'main_client_id' => 'exists:clients,id',
            'overview' => 'required|string',
            'rating' => 'required|integer',
            'logo' => 'nullable',
            'style_guide' => 'string|nullable',
            'note' => 'string|nullable',
            'designated_designer_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
            'designated_social_media_manager_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
            'designated_web_editor_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
            'designated_printer_manager_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
            'designated_animator_id' => 'nullable|int|exists:App\Models\Users\AdminUser,id',
        ];
    }
}
