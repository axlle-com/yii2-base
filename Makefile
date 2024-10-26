queue:
	docker-compose exec php-cli php yii queue/listen
up:
	docker-compose up -d
	docker-compose exec php-fpm composer install
	docker-compose exec php-fpm php yii migrate
	docker-compose up -d php-cli
cache:
	docker-compose exec php-fpm php yii cache/flush-all
migrate:
	docker-compose exec php-fpm php yii migrate
composer:
	docker-compose exec php-fpm composer update
rollback:
	docker-compose exec php-fpm php yii migrate/down
logs:
	docker-compose logs -f
stop:
	docker-compose stop
refresh:
	docker-compose down --volumes --remove-orphans
	make up
build:
	docker-compose down --volumes --remove-orphans
	docker-compose build --no-cache
	make up