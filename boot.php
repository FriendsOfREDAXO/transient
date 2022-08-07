<?php
dump(rex_config::get('asd', 'asd'));
try
{
    rex_transient::clear();
}
catch (rex_sql_exception $e)
{
}
