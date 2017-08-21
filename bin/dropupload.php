<?php

require __DIR__ . '/../vendor/autoload.php';

use Alorel\Dropbox\Operation\AbstractOperation;
use Alorel\Dropbox\Operation\Files\Upload;

AbstractOperation::setDefaultAsync(false);
AbstractOperation::setDefaultToken('MTn5Od3DgSMAAAAAAAAaD2ucStBCuS6I3iuy1dNwqvIoe3HcXnu8nJGXBIuDmmi5');

$op = new Upload();
$name = '/foo1.php';

$op->raw($name, \GuzzleHttp\Psr7\stream_for(fopen(__DIR__ . '/../.gitignore', 'r')));
