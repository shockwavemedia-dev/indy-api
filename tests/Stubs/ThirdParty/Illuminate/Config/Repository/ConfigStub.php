<?php

declare(strict_types=1);

namespace Tests\Stubs\ThirdParty\Illuminate\Config\Repository;

use Illuminate\Contracts\Config\Repository;
use Tests\Stubs\AbstractStub;
use Throwable;

/**
 * Class ConfigStub
 *
 * @coversNothing
 */
final class ConfigStub extends AbstractStub implements Repository
{
    /**
     * Get all the configuration items for the application.
     *
     * @return mixed[]
     *
     * @throws Throwable
     */
    public function all(): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * Get the specified configuration value.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     *
     * @throws Throwable
     */
    public function get($key, $default = null): mixed
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__) ?? $default;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     *
     * @throws Throwable
     */
    public function has($key): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * Prepend a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function prepend($key, $value): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());
    }

    /**
     * Push a value onto an array configuration value.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function push($key, $value): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());
    }

    /**
     * Set a given configuration value.
     *
     * @param  mixed[]|string  $key
     * @param  mixed  $value
     */
    public function set($key, $value = null): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());
    }
}
