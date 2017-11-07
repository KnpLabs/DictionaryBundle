fix:
	bin/php-cs-fixer --diff -v fix

test:
	bin/phpspec run -fpretty
