<?php

try
{
    rex_transient::clear();
}
catch (rex_sql_exception $e)
{
}