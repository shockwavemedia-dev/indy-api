<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Printers;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;

final class CreatePrinterRequest extends BaseRequest
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
            'company_name' => 'required|string|unique:App\Models\Printer,company_name',
            'email' => 'required|string|unique:App\Models\User,email',
            'password' => 'min:6|required|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'contact_name' => 'nullable|string',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
            'logo' => 'nullable',
        ];
    }
}
