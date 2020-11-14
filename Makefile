.PHONY: setup init

setup:
	make build
	cd container && docker-compose up -d

build:
	cd container && docker-compose build

init:
	docker exec -it container_php_1 bash -c 'make install'
	make ssh

install:
	composer install

ssh:
	docker exec -it container_php_1 bash

lint:
	vendor/bin/php-cs-fixer --config=.php_cs.dist fix -vvv

check:
	vendor/bin/php-cs-fixer --dry-run --config=.php_cs.dist fix -vvv

phpstan:
	vendor/bin/phpstan analyze --memory-limit=1G -l 7 src

scan:
	make check
	make phpstan
	make test-coverage

destroy:
	cd container && docker-compose down

test:
	./bin/phpunit