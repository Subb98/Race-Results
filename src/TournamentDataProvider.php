<?php

declare(strict_types=1);

namespace Subb98\RaceResults;

/**
 * Class TournamentDataProvider
 * Класс для работы с данными соревнований
 * @package Subb98\RaceResults
 */
final class TournamentDataProvider
{
    private string $inputDataFileCars;
    private string $inputDataFileAttempts;

    public function __construct(string $inputDataFileCars, string $inputDataFileAttempts)
    {
        $this->inputDataFileCars = $inputDataFileCars;
        $this->inputDataFileAttempts = $inputDataFileAttempts;
    }

    /**
     * Загружает данные соревнований из входных файлов
     * @return array
     */
    public function loadData(): array
    {
        $dataCars = json_decode(file_get_contents($this->inputDataFileCars), true);
        $dataAttempts = json_decode(file_get_contents($this->inputDataFileAttempts), true);

        $tournamentData = [];
        foreach ($dataCars['data'] as $carNum => &$driverData) {
            $driverId = $driverData['id'];
            $driverData['car_num'] = $carNum;
            $tournamentData[$driverId] = $driverData;
        }
        unset($dataCars);

        $lapsData = [];
        foreach ($dataAttempts['data'] as $lapData) {
            $id = $lapData['id'];
            $lapsData[$id][] = $lapData['result'];
        }
        unset($dataAttempts);

        foreach ($tournamentData as $id => &$data) {
            $driverResults = $lapsData[$id];
            $data['result_1'] = $driverResults[0];
            $data['result_2'] = $driverResults[1];
            $data['result_3'] = $driverResults[2];
            $data['result_4'] = $driverResults[3];
            $data['result_sum'] = $driverResults[0] + $driverResults[1] + $driverResults[2] + $driverResults[3];
            $data['result_sum_str'] = "{$driverResults[3]}{$driverResults[2]}{$driverResults[1]}{$driverResults[0]}";
        }
        unset($lapsData);

        $this->sortData($tournamentData);
        return $tournamentData;
    }

    /**
     * Сортирует данные соревнований согласно описанной бизнес-логике
     * На первой строчке будет участник, который набрал суммарно за 4 попытки наибольшее количество очков, дальше участники по убыванию.
     * В случае совпадения суммы очков по 4 попыткам у 2 или более участников, выше по турнирной таблице должен располагаться тот участник,
     * который набрал большее количество очков в четвертой попытке. В случае совпадения - в третьей, далее - второй и далее - в первой.
     * Если суммы очков совпадают во всех попытках, то участников нужно отсортировать по фамилии в алфавитном порядке.
     * @param array $tournamentData
     * @return void
     */
    private function sortData(array &$tournamentData): void
    {
        usort(
            $tournamentData,
            function ($a, $b) {
                if ($a['result_sum'] > $b['result_sum']) {
                    return -1;
                } elseif ($a['result_sum'] < $b['result_sum']) {
                    return 1;
                } else {
                    if ($a['result_sum_str'] > $b['result_sum_str']) {
                        return -1;
                    } elseif ($a['result_sum_str'] < $b['result_sum_str']) {
                        return 1;
                    } else {
                        return strnatcmp($a['name'], $b['name']);
                    }
                }
            }
        );
    }
}
