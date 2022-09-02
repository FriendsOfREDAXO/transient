<?php

use PHPUnit\Framework\TestCase;

final class TransientTest extends TestCase
{
    protected static string $namespace = 'unittest';
    protected static string $key = 'unittest';
    protected static string $value = 'value';

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testExistingTransient(): void
    {
        rex_transient::set(self::$namespace, self::$key, self::$value, 60);
        $data = rex_transient::get(self::$namespace, self::$key);

        var_dump(self::$namespace, self::$key);
        var_dump(class_exists('rex_transient'));

        self::assertIsString($data);
    }

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testNonExistingTransient(): void
    {
        self::assertNull(rex_config::get('test-ns', 'mykey'), 'get() returns null when getting non-existing key');
    }
}
