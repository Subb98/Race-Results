<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', getenv('ROOT_DIR'));
}

/**
 * Проверяет, существует ли входной файл с данными
 * @param string $inputFile
 * @return void
 */
function checkInputFile(string $inputFile): void
{
    if (!is_file($inputFile)) {
        throw new RuntimeException("Invalid input data file: '{$inputFile}'");
    }
}

$dataCarsFile = realpath(ROOT_DIR . '/data/input/data_cars.json');
checkInputFile($dataCarsFile);
if (!defined('INPUT_DATA_FILE_CARS')) {
    define('INPUT_DATA_FILE_CARS', $dataCarsFile);
}

$dataAttemptsFile = realpath(ROOT_DIR . '/data/input/data_attempts.json');
checkInputFile($dataAttemptsFile);
if (!defined('INPUT_DATA_FILE_ATTEMPTS')) {
    define('INPUT_DATA_FILE_ATTEMPTS', $dataAttemptsFile);
}

if (!defined('OUTPUT_CSV_FILE_RESULTS')) {
    define('OUTPUT_CSV_FILE_RESULTS', ROOT_DIR . '/data/output/results.csv');
}
