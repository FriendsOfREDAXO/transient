<?php

class rex_transient
{
    public const MINUTE_IN_SECONDS = 60;
    public const HOUR_IN_SECONDS = 3600;
    public const DAY_IN_SECONDS = 86400;

    /**
     * add or update a transient
     *
     * @param string $namespace
     * @param string $key
     * @param mixed $value
     * @param int $expirationTime in seconds
     * @return void
     * @throws rex_sql_exception
     * @throws Exception
     */
    public static function set(string $namespace, string $key, $value = null, int $expirationTime = self::MINUTE_IN_SECONDS): void
    {
        /**
         * set the actual config
         */
        rex_config::set($namespace, $key, $value);

        $date = new DateTime();
        $date->modify("+ $expirationTime seconds");

        $sql = rex_sql::factory();
        $sql->setTable(rex::getTable('transient'));
        $sql->setValue('uid', $namespace . '_' . $key);
        $sql->setValue('namespace', $namespace);
        $sql->setValue('key', $key);
        $sql->setValue('expiration', $date->format('Y-m-d H:i:s'));

        try {
            $sql->insertOrUpdate();
        }
        catch (rex_sql_exception $e) {
            throw new rex_exception('error msg...');
        }
    }

    /**
     * get transient by namespace and key
     * return false if the transient does not exist or has expired
     *
     * @param string $namespace
     * @param string $key
     * @return null|mixed
     * @throws rex_sql_exception
     */
    public static function get(string $namespace, string $key)
    {
        /**
         * clear older entries first
         */
        self::clear();

        $sql = rex_sql::factory();
        $sql->setTable(rex::getTable('transient'));
        $sql->setWhere(['namespace' => $namespace, 'key' => $key]);

        if ($sql->getRows() === 0) {
            return null;
        }

        return rex_config::get($namespace, $key);
    }

    /**
     * remove single transient
     *
     * @param string $namespace
     * @param string $key
     * @return void
     * @throws rex_sql_exception
     */
    public static function remove(string $namespace, string $key): void
    {
        rex_config::remove($namespace, $key);

        $sql = rex_sql::factory();
        $sql->setTable(rex::getTable('transient'));
        $sql->setWhere(['uid' => $namespace . '_' . $key]);
        $sql->delete();
    }

    /**
     * delete older entries
     *
     * @return void
     * @throws rex_sql_exception
     */
    public static function clear(): void
    {
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');

        $sql = rex_sql::factory();
        $sql->setTable(rex::getTable('transient'));
        $sql->setWhere("expiration <= '$dateTime'");
        $sql->select();
        $rows = $sql->getRows();

        if ($rows > 0) {
            /**
             * remove config entries
             */
            for ($i = 0; $i < $rows; ++$i) {
                rex_config::remove($sql->getValue('namespace'), $sql->getValue('key'));
                $sql->next();
            }

            /**
             * delete transient entries
             */
            $sql = rex_sql::factory();
            $sql->setTable(rex::getTable('transient'));
            $sql->setWhere("expiration <= '$dateTime'");
            $sql->delete();
        }
    }
}
