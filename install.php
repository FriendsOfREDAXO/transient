<?php
$addon = rex_addon::get('transient');

rex_sql_table::get(rex::getTable('transient'))
    ->ensureColumn(new rex_sql_column('uid', 'varchar(255)'))
    ->ensureIndex(new rex_sql_index('uid', ['uid'], rex_sql_index::UNIQUE))
    ->ensureColumn(new rex_sql_column('namespace', 'varchar(75)'))
    ->ensureColumn(new rex_sql_column('key', 'varchar(255)'))
    ->ensureColumn(new rex_sql_column('expiration', 'datetime'))
    ->ensure();

$sql = rex_sql::factory();
$sql->setTable(rex::getTable('activity_log'));