<?php

namespace App\Http\Requests\API\ClientServices;

use App\Http\Requests\BaseRequest;

final class UpdateClientServiceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getClientServices(): array
    {
        return $this->getArray('client_services');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'client_services' => 'array|required',
        ];
    }
}
