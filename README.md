composer install

php app/console doctrine:database:create

php app/console doctrine:schema:update --force

php app/console doctrine:fixtures:load

app/console server:run

bin/behat

bin/phpunit --debug --verbose -c app