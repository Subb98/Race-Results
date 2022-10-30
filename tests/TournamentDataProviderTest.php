<?php

declare(strict_types=1);

namespace Subb98\RaceResults\Tests;

use PHPUnit\Framework\TestCase;
use Subb98\RaceResults\TournamentDataProvider;

/**
 * Class TournamentDataProviderTest
 * Класс для тестирования бизнес-логики результатов соревнований
 * Покрывает следующие кейсы:
 * 1. Входной файл не найден
 * 2. Входной файл пустой
 * 3. Входной файл заполнен некорректно
 * 4. Участник, набравший в сумме больше всего баллов - находится на первой позиции
 * 5. При совпадении суммарных баллов у двух участников позиция выше у того, который набрал больше баллов в 4-ом заезде, затем в 3-ем, во 2-ом и в 1-ом
 * 6. Если суммы очков совпадают во всех попытках, то участников нужно отсортировать по фамилии в алфавитном порядке
 * @package Subb98\RaceResults\Tests
 */
final class TournamentDataProviderTest extends TestCase
{
    /**
     * Проверяет, что сработает ошибка при отсутствии хотя бы одного из входных файлов
     * @return void
     */
    public function testInputFileNotFound(): void
    {
        $tournamentDataProvider = new TournamentDataProvider('cars.json', 'attempts.json');
        $this->expectError();
        $this->expectErrorMessage('file_get_contents(cars.json): Failed to open stream: No such file or directory');
        $tournamentDataProvider->loadData();
    }

    /**
     * Проверяет, что сработает ошибка, если хотя бы один из входных файлов пустой
     * @return void
     */
    public function testInputFileIsEmpty(): void
    {
        $inputDataFileCars = realpath(__DIR__ . '/fixtures/data_cars.json');
        $inputDataFileAttempts = realpath(__DIR__ . '/fixtures/data_attempts_empty.json');

        $tournamentDataProvider = new TournamentDataProvider($inputDataFileCars, $inputDataFileAttempts);
        $this->expectError();
        $this->expectErrorMessage('Trying to access array offset on value of type null');
        $tournamentDataProvider->loadData();
    }

    /**
     * Проверяет, что сработает ошибка, если хотя бы для одного из заездов данные заполнены неверно
     * @return void
     */
    public function testInputFileIsInvalid(): void
    {
        $inputDataFileCars = realpath(__DIR__ . '/fixtures/data_cars.json');
        $inputDataFileAttempts = realpath(__DIR__ . '/fixtures/data_attempts_broken.json');

        $tournamentDataProvider = new TournamentDataProvider($inputDataFileCars, $inputDataFileAttempts);
        $this->expectError();
        $this->expectErrorMessage('Undefined array key "result"');
        $tournamentDataProvider->loadData();
    }

    /**
     * Проверяет, что участник, набравший в сумме больше всего баллов - находится на первой позиции
     * @return void
     */
    public function testTournamentWinner(): void
    {
        $inputDataFileCars = realpath(__DIR__ . '/fixtures/data_cars.json');
        $inputDataFileAttempts = realpath(__DIR__ . '/fixtures/data_attempts.json');

        $tournamentDataProvider = new TournamentDataProvider($inputDataFileCars, $inputDataFileAttempts);
        $tournamentData = $tournamentDataProvider->loadData();
        $this->assertEquals('Стулов К.', $tournamentData[0]['name'], 'Unexpected winner name');
        $this->assertEquals(279, $tournamentData[0]['result_sum'], 'Unexpected winner result_sum');
    }

    /**
     * Проверяет, что позиция участников с одинаковым кол-вом общих очков выбрана корректно, согласно условию:
     * При совпадении суммарных баллов у двух участников позиция выше у того, который набрал больше баллов в 4-ом заезде, затем в 3-ем, во 2-ом и в 1-ом
     * @return void
     */
    public function testSimilarResults(): void
    {
        $inputDataFileCars = realpath(__DIR__ . '/fixtures/data_cars.json');
        $inputDataFileAttempts = realpath(__DIR__ . '/fixtures/data_attempts.json');

        $tournamentDataProvider = new TournamentDataProvider($inputDataFileCars, $inputDataFileAttempts);
        $tournamentData = $tournamentDataProvider->loadData();

        $this->assertEquals('Савинов С.', $tournamentData[9]['name'], 'Unexpected driver name');
        $this->assertEquals(44, $tournamentData[9]['result_sum'], 'Unexpected driver result_sum');
        $this->assertEquals(44, $tournamentData[9]['result_3'], 'Unexpected lap result');

        $this->assertEquals('Савинов С.', $tournamentData[10]['name'], 'Unexpected driver name');
        $this->assertEquals(44, $tournamentData[10]['result_sum'], 'Unexpected driver result_sum');
        $this->assertEquals(44, $tournamentData[10]['result_2'], 'Unexpected lap result');
    }

    /**
     * Проверяет, что позиция участников с одинаковым кол-вом общих очков выбрана корректно, согласно условию:
     * Если суммы очков совпадают во всех попытках, то участников нужно отсортировать по фамилии в алфавитном порядке
     * @return void
     */
    public function testSimilarResultsName(): void
    {
        $inputDataFileCars = realpath(__DIR__ . '/fixtures/data_cars.json');
        $inputDataFileAttempts = realpath(__DIR__ . '/fixtures/data_attempts_similar.json');

        $tournamentDataProvider = new TournamentDataProvider($inputDataFileCars, $inputDataFileAttempts);
        $tournamentData = $tournamentDataProvider->loadData();

        $this->assertEquals('Игнатко С.', $tournamentData[10]['name'], 'Unexpected driver name');
        $this->assertEquals(44, $tournamentData[10]['result_sum'], 'Unexpected driver result_sum');
        $this->assertEquals(44, $tournamentData[10]['result_2'], 'Unexpected lap result');

        $this->assertEquals('Савинов С.', $tournamentData[11]['name'], 'Unexpected driver name');
        $this->assertEquals(44, $tournamentData[11]['result_sum'], 'Unexpected driver result_sum');
        $this->assertEquals(44, $tournamentData[11]['result_2'], 'Unexpected lap result');
    }
}
