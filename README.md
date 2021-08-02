# How to install
```
cp .env.example .env
ln -sf .docker/compose/docker-compose.dev.yml docker-compose.yml
docker-compose up -d

composer install
```

Game related code in app/Domain

to run tests:
```
php vendor/bin/phpunit
```
