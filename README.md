# php-simple-1-docker

*Тестовое задание на вакансию backend-разработчика PHP*

Организаторы провели соревнования по автогонкам среди 15 участников. У каждого участника был свой уникальный номер
(пример и формат данных в файле data_cars.json). Заезды проходили в случайном порядке,
каждому участнику было дано 4 попытки, всего было проведено 60 заездов. За каждую попытку участнику присваивались очки (результаты
каждого заезда вы можете найти в файле data_attempts.json).
Ваша задача вывести турнирную таблицу. В качестве колонок необходимо использовать: номер места, имя пилота,
город пилота, автомобиль, 1-, 2-, 3-, 4- попытки, сумма очков. На первой строчке будет участник, который набрал суммарно за 4 попытки
наибольшее количество очков, дальше участники по убыванию.

В случае совпадения суммы очков по 4 попыткам у 2 или более участников, выше по турнирной таблице должен располагаться тот участник, 
который набрал большее количество очков в четвертой попытке. В случае совпадения - в третьей, далее - второй и далее - в первой. 
Если суммы очков совпадают во всех попытках, то участников нужно отсортировать по фамилии в алфавитном порядке.

Данные требуется объединить в один массив и с помощью PHP вывести их в таблицу. 
Для верстки таблицы допустимо использовать Bootstrap v4.

На странице необходимо предусмотреть кнопку для пересчета результатов с сохранением итоговой таблицы в файл results.csv.

Проект необходимо дополнить Dockerfile, который годится для сборки образа и запуска вашего решения в среде Docker.
Входные и выходные файлы (data_cars.json, data_attempts.json, results.csv) необходимо подключить к контейнеру таким образом, 
чтобы их можно было редактировать и просматривать с хост-машины без каких-либо дополнительных манипуляций. 
Т.е. изменили что-то во входных файлах, на странице нажали кнопку Пересчитать результаты, в файле results.csv на хост-машине видим свежие данные.

Итоговую работу поместите в архив со всеми исходными файлами и вышлите ваш архив на нашу почту 153@ul.su с темой PHP-разработчик _Фамилия_

## Запуск и использование приложения
1. Скачать проект любым доступным способом
2. Перейти в директорию проекта
3. Не обязательно: скопировать файл с переменными окружения `cp .env.example .env`
4. Запустить сборку проекта: `docker compose up --build`
5. Для просмотра страницы с результатами перейти по ссылке http://localhost:8000
6. Сгенерировать первый файл `data/output/result.csv` нажатием на кнопку `Посчитать результат`
7. При необходимости изменить входные данные в директории `data/input` и нажать на кнопку `Пересчитать результат`
8. При необходимости есть возможность запустить автотесты бизнес-логики: `docker exec -it -w /usr/local/src/ race-results.php-fpm ./vendor/bin/phpunit tests`
