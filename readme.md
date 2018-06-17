# Freelancehunt test quest
### Installation
Для установки приложения, в командной строке введите следующие команды.
```sh
$ git clone https://github.com/Pefren/freelancehunt_test.git
$ composer install
```

Затем в папке проект переименуйте файл ".env.example" в ".env" и внутри него введите данные для связи с базой данных:
```sh
...
DB_DATABASE=freelancehunt
DB_USERNAME=admin
DB_PASSWORD=password
...
```
Потом введите в командной строке:
```sh
$ php artisan key:generate
$ php artisan migrate
$ php artisan csv:import
```

### Запуск приложения

Для запуска приложения либо настройте сервер на запрос файла index.php в папке проект /public, либо напишите в командной строке:
```sh
$ php artisan serve
```

По выведенному на экран адресу будет доступно разработанное приложение (как правило, по адресу "http://localhost:8000/").