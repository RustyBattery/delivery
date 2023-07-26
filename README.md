Диаграммы: https://drive.google.com/file/d/1wqe3UR2P0oADCnJERBmTkK-BuKbmHQ9L/view?usp=sharing


--------
Деплой

Из папки deploy запустить
- docker-compose up

в каждом сервисе настроить .env файл по примеру .env.example

--------

Настройка микросервиса auth
- docker exec -it auth_app bash
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan queue:work

--------

Настройка микросервиса backend
- docker exec -it backend_app bash
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- exit

--------

Настройка микросервиса notifications
- docker run --rm -it --hostname my-rabbit -p 15672:15672 -p 5672:5672 rabbitmq:3-management
- docker exec -it notifications_app bash
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan rabbitmq:consume и php artisan queue:work redis

Необходимо также зайти в RabbitMQ по адресу http://localhost:15672 и создать очередь default

--------

Настройка микросервиса admin
- docker exec -it backend_app bash
- composer install
- npm install
- php artisan key:generate
- php artisan migrate
- npm run build
- php artisan queue:work

Административная панель будет доступна по адресу http://localhost:82
Дефолтный администратор - admin@mail.ru admin

Также необходимо будет зайти в minio по адресу http://localhost:9006, авторизоваться как minio minio123, создать testbucket и сделать его public
