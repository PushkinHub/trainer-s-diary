## Первичная установка проекта
После клонирования репозитория
* сбилдить докер контейнеры `docker-compose build`
* поднимаем докер `docker-compose up -d`
* заходим внутрь контейнера для выполнения последующих комманд `docker-compose exec php sh`
    * установить вендоров `composer install`
    * устанавливаем yarn зависимости `yarn install`
    * создаём базу данных если её не существует `php bin/console doctrine:database:create`
    * разворачиваем схему базы данных `php bin/console doctrine:migration:migrate -n`
    * загружаем в неё фикстуры для разработки `php bin/console doctrine:fixture:load`

## Запуск проекта
* Поднимаем докер `docker-compose up -d`
* запускаем webpack для работы css js `docker-compose exec php yarn encore dev --watch`
* заходим внутрь контейнера php если нужно `docker-compose exec php sh`

## Вспомогательное
* Данные для входа под тренером - email: `trainer@email`  pass: `test`
* Для полного пересоздания бд выполнить в контейнере пхп 
  `php bin/console doctr:da:dro --force && php bin/console doctr:da:create && php bin/console doctr:mi:migr -n && php bin/console doctr:fix:load`
