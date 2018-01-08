web: $(composer config bin-dir)/heroku-php-apache2 public/
release: bin/console doctrine:schema:update --dump-sql --force
