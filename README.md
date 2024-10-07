# Тестовое задание

## Требования

1. PHP 8.3
2. MySQL 8.0
3. Composer 2.0
4. RabbitMQ 4
5. Node 18.0

## Используемые библиотеки

### Сервер

1. Laravel 11 [https://laravel.com](https://laravel.com)
2. Laravel Reverb [https://reverb.laravel.com](https://reverb.laravel.com)
3. Laravel Sanctum [https://laravel.com/docs/11.x/sanctum](https://laravel.com/docs/11.x/sanctum)
4. Laravel-Data [https://spatie.be/docs/laravel-data/v4/introduction](https://spatie.be/docs/laravel-data/v4/introduction)
5. Laravel-Query-Builder [https://spatie.be/docs/laravel-query-builder/v5/introduction](https://spatie.be/docs/laravel-query-builder/v5/introduction)
6. Telegram Notifications Channel for Laravel [https://github.com/laravel-notification-channels/telegram](https://github.com/laravel-notification-channels/telegram)
7. RabbitMQ Queue driver for Laravel [https://github.com/vyuldashev/laravel-queue-rabbitmq](https://github.com/vyuldashev/laravel-queue-rabbitmq)
8. SimplePie [https://simplepie.org](https://simplepie.org)

### Client

1. Nuxt 3 [https://nuxt.com](https://nuxt.com)
2. Nuxt UI [https://ui.nuxt.com](https://ui.nuxt.com)
3. Nuxt I18N [https://i18n.nuxtjs.org](https://i18n.nuxtjs.org)
4. Nuxt Auth [https://github.com/sidebase/nuxt-auth](https://github.com/sidebase/nuxt-auth)
5. Pinia [https://pinia.vuejs.org/ssr/nuxt.html](https://pinia.vuejs.org/ssr/nuxt.html)
6. VueUse [https://vueuse.org](https://vueuse.org)
7. Laravel Echo [https://github.com/laravel/echo](https://github.com/laravel/echo)
8. Pusher JS [https://github.com/pusher/pusher-js](https://github.com/pusher/pusher-js)
9. Yup [https://github.com/jquense/yup](https://github.com/jquense/yup)
10. DayJS [https://day.js.org](https://day.js.org)


## Установка

_Для удобства лучше использовать Docker который описан в конце документа_

### Скопировать и настроить конфигурационные файлы

```bash
cp .env.example .env
```

```bash
cp client/.env.example client/.env
```

### Установить зависимости

```bash
composer install
```

```bash
cd client
npm ci
```

### Настроить Cron

```bash
* * * * * /usr/bin/php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```

### Применить миграции

```bash
./artisan migrate
```

### Запустить парсинг новостей

```bash
./artisan news:source:parse
```

## Запуск

### Cервер

Запускаем Reverb

```bash
./artisan reverb:start 
```

Запускам очереди

```bash
./artisan queue:work 
```

Запускаем сервер

```bash
./artisan serve 
```

### Клиент

```bash
cd client
npm run dev
```

## Использование

### Web интерфейс

```text
http://localhost:4000
```

### Telegram

Получить доступ к тестовой группе куда приходят коды можно по ссылке:

```text
https://t.me/+tLb36kEIYBpjOGZi
```

### Парсинг новостей

```bash
./artisan news:source:parse 
```

### Добавление нового источника новостей

```bash
./artisan news:source:add
```

## Запуск в Docker

Для удобства настроен docker с помощью Laravel Sail и так же написан скрипт для его использования

```bash
sn docker.sh
```
