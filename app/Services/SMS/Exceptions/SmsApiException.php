<?php

declare(strict_types=1);

namespace App\Services\SMS\Exceptions;

use App\Exceptions\BaseException;

/**
 * @codeCoverageIgnore
 */
final class SmsApiException extends BaseException
{
    /**
     * @var mixed[]
     */
    public $errors;

    /**
     * @var string
     */
    private $translatorKey;

    /**
     * @var mixed[]
     */
    private $translatorParams;

    /**
     * AbnApiException constructor.
     *
     * @param mixed[]|null $errors
     */
    public function __construct(
        string $message,
        string $translatorKey,
        ?array $translatorParams = null,
        ?array $errors = null
    ) {
        $this->translatorKey = $translatorKey;
        $this->translatorParams = $translatorParams;

        parent::__construct($message);

        $this->errors = $errors ?? [];
    }

    /**
     * Get errors.
     *
     * @return mixed[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getTranslatorKey(): string
    {
        return $this->translatorKey;
    }

    public function getTranslatorParams(): ?array
    {
        return $this->translatorParams;
    }
}
