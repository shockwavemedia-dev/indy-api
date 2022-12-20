<?php

declare(strict_types=1);

namespace App\Http\Requests\API;

use App\Http\Requests\BaseRequest;
use Carbon\Carbon;

class PaginationRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getSize(): ?int
    {
        $size = $this->getInt('size');

        if ($size === 0) {
            return null;
        }

        return $size;
    }

    public function getPageNumber(): ?int
    {
        $pageNumber = $this->getInt('page_number');

        if ($pageNumber === 0) {
            return null;
        }

        return $pageNumber;
    }

    public function getLibraryCategoryId(): ?int
    {
        if ($this->getInt('library_category_id') === 0) {
            return null;
        }

        return $this->getInt('library_category_id');
    }

    public function getStatuses(): ?array
    {
        if ($this->get('statuses') === null) {
            return null;
        }

        return $this->getArray('statuses');
    }

    public function getTypes(): ?array
    {
        if ($this->get('types') === null) {
            return null;
        }

        return $this->getArray('types');
    }

    public function getSubject(): ?string
    {
        if ($this->get('subject') === null) {
            return null;
        }

        return $this->getString('subject');
    }

    public function getCode(): ?string
    {
        if ($this->get('code') === null) {
            return null;
        }

        return $this->getString('code');
    }

    public function getDeadline(): ?Carbon
    {
        if ($this->get('duedate') === null) {
            return null;
        }

        return new Carbon($this->getString('duedate'));
    }

    public function getClientId(): ?int
    {
        $clientId = $this->getInt('client_id');

        if ($clientId === 0) {
            return null;
        }

        return $clientId;
    }

    public function getPriorities(): ?array
    {
        if ($this->get('priorities') === null) {
            return null;
        }

        return $this->getArray('priorities');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'size' => 'int|nullable',
            'page_number' => 'int|nullable',
            'types' => 'array|nullable',
            'statuses' => 'array|nullable',
            'subject' => 'string|nullable',
            'code' => 'string|nullable',
            'duedate' => 'string|nullable',
            'library_category_id' => 'int|nullable',
            'client_id' => 'int|nullable|exists:App\Models\Client,id',
            'priorities' => 'array|nullable',
        ];
    }
}
