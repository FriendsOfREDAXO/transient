<?php

class rex_transient_cronjob extends \rex_cronjob
{
    /**
     * execute the cronjob
     * @return bool
     * @throws \rex_sql_exception
     */
    public function execute(): bool
    {
        rex_transient::clear();
        return true;
    }

    /**
     * get the job name
     * @return string
     */
    public function getTypeName(): string
    {
        return \rex_i18n::msg('transient_cronjob_title');
    }
}
