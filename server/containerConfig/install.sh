docker compose up -d
docker exec criminal-cases-server composer update
docker exec criminal-cases-server composer install
docker exec criminal-cases-server composer dumpautoload