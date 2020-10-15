docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

test:
	docker exec ad-laravel_php-cli vendor/bin/phpunit --colors=always

assets-install:
	docker exec ad-laravel_node yarn install

assets-dev:
	docker exec ad-laravel_node yarn run dev

assets-watch:
	docker exec ad-laravel_node yarn run watch

migrate:
	docker exec ad-laravel_php-cli php artisan migrate

seed:
	docker exec ad-laravel_php-cli php artisan db:seed

clear:
	docker exec ad-laravel_php-cli php artisan config:clear
	docker exec ad-laravel_php-cli php artisan cache:clear

key:
	 docker exec ad-laravel_php-cli php artisan key:generate

test:
	docker exec ad-laravel_php-cli vendor/bin/phpunit

#docker exec app_node_1 npm rebuild node-sass --force
#docker exec app_node_1 npm install
#cd /var/lib/mysql/
#chown mysql:mysql db_ads/ -R
#docker exec ad-laravel_php-cli chown 777 storage/ -R
#docker exec ad-laravel_php-cli chown 777 storage/framework/cache/data/* -R

perm:
	sudo chown ${USER}:${$USER} bootstrap/cache -R
	sudo chown ${USER}:${$USER} storage/ -R
	sudo chown ${USER}:${$USER} storage/logs/ -R
	if [ -d "node_modules" ]; then sudo chown ${USER} node_modules -R; fi
	if [ -d "public/build" ]; then sudo chown ${USER} public/build -R; fi

