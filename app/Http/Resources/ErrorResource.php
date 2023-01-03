<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Symfony\Component\HttpFoundation\Response;

final class ErrorResource extends Resource
{
    private ?int $status = null;

    public static $wrap = null;

    public function __construct(string $message, ?int $status = null)
    {
        parent::__construct($message);

        $this->status = $status;
    }

    protected function getResponse(): array
    {
        return [
            'message' => $this->resource,
        ];
    }

    protected function getStatusCode(): int
    {
        return $this->status ?? Response::HTTP_BAD_REQUEST;
    }
}
