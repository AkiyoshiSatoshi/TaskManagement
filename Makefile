install:
	cp ./backend/.env.example ./backend/.env
	docker run --rm -u "$(id -u):$(id -g)" -v "$(shell pwd)/backend:/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs
	@make up
up:
	docker compose up -d
down:
	docker compose down
test:
	./backend/vendor/bin/sail php artisan test
migrate:
	./backend/vendor/bin/sail php artisan migrate
fresh:
	./backend/vendor/bin/sail php artisan migrate:fresh --seed
seed:
	./backend/vendor/bin/sail php artisan db:seed
pint:
	./backend/vendor/bin/pint -v
stan:
	cd backend && ./vendor/bin/phpstan analyse --memory-limit=2G
lint:
	docker compose exec nuxt npm run lint
format:
	docker compose exec nuxt npm run format