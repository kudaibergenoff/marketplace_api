##################
# Variables
##################
DOCKER_COMPOSE = docker compose -f ./compose.yml --env-file ./.env
##################
# Docker compose
##################
dc_build:
	echo "Executing 'docker compose build'..."
	${DOCKER_COMPOSE} build

dc_start:
	echo "Executing 'docker compose start'..."
	${DOCKER_COMPOSE} start

dc_stop:
	echo "Executing 'docker compose stop'..."
	${DOCKER_COMPOSE} stop

dc_up:
	echo "Executing 'docker compose up -d'..."
	${DOCKER_COMPOSE} up -d --remove-orphans

dc_ps:
	echo "Executing 'docker compose ps'..."
	${DOCKER_COMPOSE} ps

dc_logs:
	echo "Executing 'docker compose logs -f'..."
	${DOCKER_COMPOSE} logs -f

dc_down:
	echo "Executing 'docker compose down -v'..."
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

dc_restart:
	echo "Executing 'docker compose restart'..."
	make dc_stop dc_start

dc_rebuild_up:
	echo "Executing 'docker compose rebuild and up'..."
	make dc_stop dc_build dc_up

app_bash:
	echo "Executing 'docker exec bash'..."
	${DOCKER_COMPOSE} exec -u www-data api bash

app_doc_generate:
	echo "Executing 'generate documentation'..."
	${DOCKER_COMPOSE} exec -u www-data api php artisan l5-swagger:generate

app_install:
	echo "Executing application installation..."
	make dc_build dc_up
	${DOCKER_COMPOSE} exec -u www-data api cp .env.example .env
	${DOCKER_COMPOSE} exec -u www-data api composer install
	${DOCKER_COMPOSE} exec -u www-data api php artisan migrate
	make app_db_seed
	${DOCKER_COMPOSE} exec -u www-data api php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
	make app_doc_generate

app_db_seed:
	echo "Excuting 'seeder'"
	${DOCKER_COMPOSE} exec -u www-data api php artisan db:seed --class=RoleSeeder
	${DOCKER_COMPOSE} exec -u www-data api php artisan db:seed --class=UserSeeder
	${DOCKER_COMPOSE} exec -u www-data api php artisan db:seed --class=CategorySeeder
	${DOCKER_COMPOSE} exec -u www-data api php artisan db:seed --class=ProductSeeder
