<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class BaseException extends Exception
{
    /**
     * @var mixed[]|null
     */
    public $errors;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        ?array $errors = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->errors = $errors;
    }

    /**
     * Get errors.
     *
     * @return mixed[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
