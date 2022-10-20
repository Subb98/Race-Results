<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$rootDir = getenv('ROOT_DIR');

$dataAttemptsJson = realpath("{$rootDir}/data/input/data_attempts.json");
$dataCarsJson = realpath("{$rootDir}/data/input/data_cars.json");

print_r(compact(
    'rootDir',
    'dataAttemptsJson',
    'dataCarsJson'
));
