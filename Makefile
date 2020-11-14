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

destroy:
	cd container && docker-compose down

test:
	./bin/phpunit