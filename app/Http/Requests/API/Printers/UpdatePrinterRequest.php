<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Printers;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

final class UpdatePrinterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getCompanyName(): string
    {
        return $this->getString('company_name');
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getContactName(): ?string
    {
        return $this->getString('contact_name');
    }

    public function getPhone(): ?string
    {
        return $this->getString('phone');
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getPassword(): string
    {
        return $this->getString('password');
    }

    public function getLogo(): ?UploadedFile
    {
        return $this->file('logo');
    }

    public function rules(): array
    {
        return [
            'company_name' => [
                'required',
                'string',
                Rule::unique('printers', 'company_name')->ignore($this->id),
            ],
            'email' => [
                'required',
                'string',
            ],
            'contact_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable',
        ];
    }
}
