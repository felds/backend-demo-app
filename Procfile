web: $(composer config bin-dir)/heroku-php-apache2 public/
release: bin/console doctrine:database:update --dump-sql --force
