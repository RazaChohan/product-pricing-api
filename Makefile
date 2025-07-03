.PHONY: all build up down composer-install migrate test fetch-prices logs

all: build up composer-install migrate

build:
	@echo "Building Docker containers..."
	docker compose build

up:
	@echo "Starting Docker containers..."
	docker compose up -d

down:
	@echo "Stopping Docker containers..."
	docker compose down

composer-install:
	@echo "Installing Composer dependencies..."
	docker compose exec app composer install

migrate:
	@echo "Running database migrations..."
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

test:
	@echo "Running PHPUnit tests..."
	docker compose exec app vendor/bin/phpunit

fetch-prices:
	@echo "Fetching and storing prices..."
	docker compose exec app php bin/console app:fetch-prices