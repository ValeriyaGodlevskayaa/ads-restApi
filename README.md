## Тестовое задание

Create JSON API for ad site
It is necessary to create a service for storing and submitting ads.  Ads must be stored in a database.  The service should provide an API that runs on top of HTTP in JSON format.

Requirements

language, technologies: PHP with any framework (or without it)
the code should be posted on github

3 methods: get list of ads, get one ad, create ad
field validation (no more than 3 links to a photo, description no more than 1000 characters, title no more than 200 characters)

Method for getting list of ads

pagination is required, 10 ads should be present on one page
you need the ability to sort: by price (ascending / descending) and by date of creation (ascending / descending)
fields in the response: ad name, link to the main photo (first in the list), price

Method for getting a specific ad
required fields in the response: ad name, price, link to the main photo
optional fields (can be requested by passing the fields parameter): description, links to all photos

Ad creation method:
accepts all of the above fields: name, description, several links to photos (the photos themselves do not need to be uploaded anywhere), price
returns the ID of the created ad and the result code (error or success)


Complications

Not required, but the task can be completed with any number of complications
unit tests written
containerization - the ability to raise a project using docker-compose up
caching - to increase the speed of response from the server, caching can be added (Redis / Memcached)

## Инструкция установки

- git clone https://github.com/ValeriyaGodlevskayaa/ads-restApi.git
- cd ads-restApi
- composer install
- создать файл .env и скопировать с файла .env.example, указать свои настройки к БД
- выполнить миграции командой: `php artisan migrate`
- запустить все тесты: `vendor/bin/phpunit`

## Методы для rest api
- url: /api/v1/ads method: GET - получаем список всех объявлений, есть возможность передать дополнительные параметры(sort_price=asc/desc и sort_date=asc/desc) - сортировка по цене и дате создания
- url: /api/v1/ads/create method: POST
 
 Пример тела запроса:
 
 `name=test ads&price=33&images[1]=link one&images[2]=link two&&images[3]=link test&main_image=2&description=test description for ad`
