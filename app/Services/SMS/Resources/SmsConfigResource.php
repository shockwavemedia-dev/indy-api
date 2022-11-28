<?php

declare(strict_types=1);

namespace App\Services\SMS\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class SmsConfigResource extends DataTransferObject
{
    public string $password;

    public string $url;

    public string $username;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }
}
