<?php

namespace Tests;

use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Helpers\EnvironmentFactory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected EnvironmentFactory $env;

    protected Generator $faker;

    protected function setUp(): void
    {
        ini_set('memory_limit', '-1');
        parent::setUp();

        $this->env = EnvironmentFactory::create(true);
        $this->faker = $this->env->faker;

        Carbon::setTestNow();
    }

    protected function assertArrayHasKeys(array $properties, array $array): void
    {
        if (empty($properties) === true) {
            $this->fail('assertArrayHasKeys properties in empty.');
        }

        foreach ($properties as $property) {
            $this->assertArrayHasKey($property, $array);
        }
    }

    /**
     * Assert array is equal fuzzily.
     * Replaces dynamic properties in arrays with a known value
     * to be able to compare both actual and expected.
     *
     * @param mixed[] $expected
     * @param mixed[] $actual
     */
    protected function assertEqualsFuzzy(array $expected, array $actual, ?string $message = null): void
    {
        $test = $this->fuzzifyArray($actual, $expected, ':fuzzy:');
        $this->assertEquals($expected, $this->fuzzifyArray($actual, $expected, ':fuzzy:'), $message ?? '');
    }

    /**
     * Fuzzify actual array.
     *
     * @param mixed[] $expected
     * @param mixed[] $actual
     * @param mixed[]|null $keys
     *
     * @return mixed[] New actual array.
     */
    private function fuzzifyArray(array $actual, array $expected, string $fuzzyValue, ?array $keys = null): array
    {
        foreach ($actual as $key => &$value) {
            /** @var string[] Keys of the current iteration depth (including current key) */
            $iterationKeys = $keys ?? [];
            $iterationKeys[] = $key;

            if (\is_array($value) === true) {
                // Recursively call function to apply fuzziness to arrays on any depth

                $value = $this->fuzzifyArray($value, $expected, $fuzzyValue, $iterationKeys);
                continue;
            }

            // Determine the expected value (if present)
            $expectedValue = $expected;

            foreach ($iterationKeys as $keyValue) {
                $expectedValue = $expectedValue[$keyValue] ?? null;
            }

            /**
             * If expected value equals the fuzzy value, set the actual value to the fuzzy value so that
             * comparision result successfully otherwise continue.
             */
            if ($expectedValue !== $fuzzyValue) {
                continue;
            }

            $value = $fuzzyValue;
        }

        return $actual;
    }
}
