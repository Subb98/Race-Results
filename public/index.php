<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use Subb98\RaceResults\Utils\CsvFileHelper;
use Subb98\RaceResults\TournamentDataProvider;

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    $tournamentDataProvider = new TournamentDataProvider(INPUT_DATA_FILE_CARS, INPUT_DATA_FILE_ATTEMPTS);
    $tournamentData = $tournamentDataProvider->loadData();

    CsvFileHelper::writeTournamentDataToCsv($tournamentData, OUTPUT_CSV_FILE_RESULTS);
}

$csvData = CsvFileHelper::readTournamentDataFromCsv(OUTPUT_CSV_FILE_RESULTS);
$buttonName = empty($csvData) ? 'Посчитать результат' : 'Пересчитать результат';
require_once __DIR__ . '/../web/pages/index.html';
