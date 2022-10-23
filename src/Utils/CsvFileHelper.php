<?php

declare(strict_types=1);

namespace Subb98\RaceResults\Utils;

use RuntimeException;

/**
 * Class CsvFileHelper
 * Вспомогательный класс для работы с csv файлами
 * @package Subb98\RaceResults\Utils
 */
final class CsvFileHelper
{
    /**
     * Записывает данные соревнования в выходной csv файл
     * @param array $tournamentData
     * @param string $outputCsvFile
     * @return void
     * @throws RuntimeException Если не удалось создать выходной csv файл
     */
    public static function writeTournamentDataToCsv(array $tournamentData, string $outputCsvFile): void
    {
        $fp = fopen($outputCsvFile, 'w');
        if (false === $fp) {
            throw new RuntimeException("Failed to create csv file '{$outputCsvFile}'");
        }

        fputcsv($fp, ['Место', 'Имя', 'Город', 'Автомобиль', '1 заезд', '2 заезд', '3 заезд', '4 заезд', 'Всего очков']);
        foreach ($tournamentData as $k => $fields) {
            $csvData = [
                $k + 1,
                $fields['name'],
                $fields['city'],
                $fields['car'],
                $fields['result_1'],
                $fields['result_2'],
                $fields['result_3'],
                $fields['result_4'],
                $fields['result_sum'],
            ];
            fputcsv($fp, $csvData);
        }

        fclose($fp);
    }

    /**
     * Считывает данные соревнований из выходного csv файла
     * @param string $outputCsvFile
     * @return array
     * @throws RuntimeException Если не удалось открыть выходной csv файл
     */
    public static function readTournamentDataFromCsv(string $outputCsvFile): array
    {
        if (!is_file($outputCsvFile)) {
            return [];
        }

        $fp = fopen($outputCsvFile, 'r');
        if (false === $fp) {
            throw new RuntimeException("Failed to open csv file '{$outputCsvFile}'");
        }

        $csvData = [];
        while (($fields = fgetcsv($fp, 200)) !== false) {
            $csvData[] = [
                'position' => $fields[0],
                'name' => $fields[1],
                'city' => $fields[2],
                'car' => $fields[3],
                'result_1' => $fields[4],
                'result_2' => $fields[5],
                'result_3' => $fields[6],
                'result_4' => $fields[7],
                'result_sum' => $fields[8],
            ];
        }

        fclose($fp);
        return $csvData;
    }
}
