# Click reward system

## How the API works
API supports 3 requests:

1. To get current balance by the campaignId: http://localhost/2023-06/balance?campaignId=1&currency=USD:
* campaignId (required, int)
* currency (required, enum [USD, EUR, GBP])

2. To count a click by the campaignId: http://localhost/2023-06/click
* campaignId (required, int)

3. To set currency ratio: http://localhost/2023-06/currency/ratio:
* currency (required, enum [GBP, EUR])
* ratio (required, float)

There is a postman collection [api_postman_collection.json](api_postman_collection.json) in the app folder of the project to try these requests.


## How to start project

These are following steps to set up project:

```
cd app
cp .env.dist .env
``` 

then prepare docker environment:
```
cd ../docker
docker-compose build
docker-compose up -d
```

final project steps inside of docker container:
```
docker exec -it click-reward-system-php composer install
docker exec -it click-reward-system-php php bin/console doctrine:migrations:migrate
docker exec -it click-reward-system-php php bin/console doctrine:fixtures:load 
```

## Tests
The service is covered with basic unit tests.
The results are available by running the following command:
```
docker exec -it click-reward-system-php php bin/phpunit
```