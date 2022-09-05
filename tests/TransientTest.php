<?php

use PHPUnit\Framework\TestCase;

final class TransientTest extends TestCase
{
    protected static string $namespace;
    protected static string $key;
    protected static string $value = 'value';

    /**
     * @return void
     */
    public function setUp(): void
    {
        $uid = uniqid('unittest', false);
        self::$namespace = $uid;
        self::$key = $uid;
    }

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testExistingTransient(): void
    {
        rex_transient::set(self::$namespace, self::$key, self::$value, 60);
        $data = rex_transient::get(self::$namespace, self::$key);

        self::assertIsString($data);
    }

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testNonExistingTransient(): void
    {
        self::assertNull(rex_transient::get('test-ns', 'mykey'), 'get() returns null when getting non-existing key');
    }

    /**
     * @return void
     * @throws rex_sql_exception
     */
    public function testRemoveTransient(): void
    {
        $key = self::$key . '_rm';
        
        rex_transient::set(self::$namespace, $key, self::$value, 60);
        $data = rex_transient::get(self::$namespace, $key, self::$value, 60);
        self::assertIsString($data);

        rex_transient::remove(self::$namespace, $key);
        $data = rex_transient::get(self::$namespace, $key, self::$value, 60);
        self::assertNull($data);
    }

    /**
     * remove test transient
     *
     * @return void
     * @throws rex_sql_exception
     */
    public function tearDown(): void
    {
        rex_transient::remove(self::$namespace, self::$key);
    }
}
