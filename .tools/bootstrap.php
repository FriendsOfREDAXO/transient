<?php

unset($REX);
$REX['REDAXO'] = true;
$REX['HTDOCS_PATH'] = '../../../../../';
$REX['BACKEND_FOLDER'] = 'redaxo';
$REX['LOAD_PAGE'] = false;

var_dump(realpath('../../../../../') . PHP_EOL);
var_dump(realpath('../../../core/boot.php') . PHP_EOL);

require '../../../core/boot.php';
require '../../../core/packages.php';

// use original error handlers of the tools
rex_error_handler::unregister();
