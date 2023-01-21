install:
	composer install

dump:
	composer dump-autoload

lint:
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests

test:
	composer exec --verbose phpunit tests
