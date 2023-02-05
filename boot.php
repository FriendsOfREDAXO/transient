<?php
try
{
    rex_transient::clear();
}
catch (rex_sql_exception $e)
{
}

if (rex_addon::get('cronjob')->isAvailable() && !rex::isSafeMode()) {
    rex_cronjob_manager::registerType('rex_transient_cronjob');
}
