<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Analytics;

use App\Http\Requests\API\PaginationRequest;

final class AnalyticQueryRequest extends PaginationRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getMenu(): string
    {
        return $this->getString('menu');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'menu' => 'string',
        ];
    }
}
