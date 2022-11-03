<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Resources\ErrorResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Sentry\Severity;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;
use function app;

abstract class AbstractAPIController
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private ErrorLogInterface $logger;

    public function getUser(): ?User
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return $user;
    }

    /**
     * Return HTTP OK (200) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondOk(array $data = [], array $headers = []): JsonResource
    {
        return new JsonResource($data, Response::HTTP_OK, $headers);
    }

    /**
     * Return HTTP bad request (400) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondBadRequest(array $data = [], array $headers = []): JsonResource
    {
        $logger = app()->make(ErrorLogInterface::class);
        $logger->log($data['message'], new Severity('error'));

        return new ErrorResource($data['message'], ResponseAlias::HTTP_BAD_REQUEST);
    }

    /**
     * Return HTTP conflict (409) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondConflict(array $data = [], array $headers = []): JsonResource
    {
        return new ErrorResource($data['message'], ResponseAlias::HTTP_CONFLICT);
    }

    /**
     * Return HTTP created (201) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondCreated(array $data = [], array $headers = []): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_CREATED, $headers);
    }

    /**
     * Return HTTP bad request (400) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondInternalError(array $data = [], array $headers = []): JsonResource
    {
        $logger = app()->make(ErrorLogInterface::class);
        $logger->log($data['message'] ?? '', new Severity('error'));

        return new JsonResource($data, Response::HTTP_BAD_REQUEST, $headers);
    }

    /**
     * Return HTTP forbidden (403) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondForbidden(?array $data = null, array $headers = []): JsonResource
    {
        if ($data === null) {
            $data = [
                'message' => 'You do not have access to this.',
            ];
        }

        return new JsonResource($data, Response::HTTP_FORBIDDEN, $headers);
    }

    /**
     * Return HTTP no content (204) response
     *
     * @param mixed[] $headers
     */
    protected function respondNoContent(array $headers = []): JsonResource
    {
        return new JsonResource([], Response::HTTP_NO_CONTENT, $headers);
    }

    /**
     * Return HTTP not found (404) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondNotFound(array $data = [], array $headers = []): JsonResource
    {
        return new ErrorResource($data['message'], ResponseAlias::HTTP_NOT_FOUND);
    }

    /**
     * Return HTTP unauthorized (401) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondUnauthorised(array $data = [], array $headers = []): JsonResource
    {
        return $this->respondError($data['message'] ?? 'Invalid Credentials', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Return HTTP unprocessable (422) response
     *
     * @param mixed[] $data
     * @param mixed[] $headers
     */
    protected function respondUnprocessable(array $data = [], array $headers = []): JsonResource
    {
        $logger = app()->make(ErrorLogInterface::class);
        $logger->log($data['message'], new Severity('info'));

        return new JsonResource($data, Response::HTTP_UNPROCESSABLE_ENTITY, $headers);
    }

    protected function respondError(string $message, ?int $status = null): ErrorResource
    {
        $logger = app()->make(ErrorLogInterface::class);
        $logger->log($message, new Severity('error'));

        return new ErrorResource($message, $status);
    }

    protected function reportError(Throwable $throwable): void
    {
        $logger = app()->make(ErrorLogInterface::class);
        $logger->reportError($throwable);
    }
}
