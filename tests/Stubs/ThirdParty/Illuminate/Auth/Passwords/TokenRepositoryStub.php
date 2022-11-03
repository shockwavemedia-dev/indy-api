<?php

declare(strict_types=1);

namespace Tests\Stubs\ThirdParty\Illuminate\Auth\Passwords;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TokenRepositoryStub extends AbstractStub implements TokenRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(CanResetPasswordContract $user): string
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function exists(CanResetPasswordContract $user, $token): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function recentlyCreatedToken(CanResetPasswordContract $user): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function delete(CanResetPasswordContract $user): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteExpired(): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
