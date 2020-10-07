docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

test:
	docker exec app_php-cli_1 vendor/bin/phpunit --colors=always

assets-install:
	docker exec app_node_1 yarn install

assets-dev:
	docker exec app_node_1 yarn run dev

assets-watch:
	docker exec app_node_1 yarn run watch

migrate:
	docker exec app_php-cli_1 php artisan migrate

seed:
	docker exec app_php-cli_1 php artisan db:seed

clear:
	docker exec app_php-cli_1 php artisan config:clear
	docker exec app_php-cli_1 php artisan cache:clear

key:
	 docker exec app_php-cli_1 php artisan key:generate

#docker exec app_node_1 npm rebuild node-sass --force
#docker exec app_node_1 npm install
#cd /var/lib/mysql/
#chown mysql:mysql db_ads/ -R
#docker exec app_php-cli_1 chown 777 storage/ -R
#docker exec app_php-cli_1 chown 777 storage/framework/cache/data/* -R

perm:
	sudo chown ${USER}:${$USER} bootstrap/cache -R
	sudo chown ${USER}:${$USER} storage/ -R
	sudo chown ${USER}:${$USER} storage/logs/ -R
	if [ -d "node_modules" ]; then sudo chown ${USER} node_modules -R; fi
	if [ -d "public/build" ]; then sudo chown ${USER} public/build -R; fi

