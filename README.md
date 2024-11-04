## Marketpalace Api


### Запуск приложения
Для запуска приложения у вас должен быть установлен докер.

```shell
make dc_build
make dc_up
```
```shell
make app_install
```
### Docker-container
```shell
make app_bash
```

### Остановка приложения
```shell
make dc_stop
```

### Документация swagger доступна по адресу
```shell
http://localhost:8000/api/documentation
```





## Установка и запуск приложения

Следуйте этим шагам для установки и запуска приложения без использования команды `make`.

### 1. Сборка и запуск контейнеров

Сначала выполните сборку и запуск контейнеров:

```bash
docker-compose build
docker-compose up -d
```

### 2. Копирование файла окружения
   Скопируйте файл окружения:

```bash
docker-compose exec -u www-data api cp .env.example .env
```

### 3. Установка зависимостей с помощью Composer
Установите зависимости PHP:

```bash
docker-compose exec -u www-data api composer install
```

### 4. Выполнение миграций
Запустите миграции базы данных:

```bash
docker-compose exec -u www-data api php artisan migrate
```

### 5. Заполнение базы данных
Заполните базу данных начальными данными с помощью сидеров:

```bash
echo "Executing 'seeder'"
docker-compose exec -u www-data api php artisan db:seed --class=RoleSeeder
docker-compose exec -u www-data api php artisan db:seed --class=UserSeeder
docker-compose exec -u www-data api php artisan db:seed --class=CategorySeeder
docker-compose exec -u www-data api php artisan db:seed --class=ProductSeeder
```

### 6. Публикация ресурсов Swagger
Опубликуйте ресурсы для Swagger:

```bash 
docker-compose exec -u www-data api php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

### 7. Генерация документации Swagger
Сгенерируйте документацию Swagger:

```bash
docker-compose exec -u www-data api php artisan l5-swagger:generate
```
