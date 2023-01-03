<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Interfaces\RequestInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class BaseRequest extends FormRequest implements RequestInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return parent::get($key, $this->json($key, $default));
    }

    /**
     * Get a field from the request cast to a string
     */
    protected function getArray(string $key): array
    {
        return (array) $this->get($key) ?? [];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get a field from the request to a float
     */
    protected function getFloat(string $key): float
    {
        return (float) $this->get($key);
    }

    /**
     * Get a field from the request cast to an int
     */
    protected function getInt(string $key): int
    {
        return (int) $this->get($key);
    }

    /**
     * Get a field from the request cast to a string
     */
    protected function getString(string $key): ?string
    {
        $result = (string) $this->get($key);

        return empty($result) === true ? null : $result;
    }

    /**
     * Use the body JSON for request validation
     *
     * @return mixed[]
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function validationData(): array
    {
        if (empty($this->json()->all()) === false) {
            return $this->json()->all();
        }

        return $this->all();
    }
}
