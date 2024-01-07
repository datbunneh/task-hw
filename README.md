## Installation
1. Build containers:
```bash
docker compose up -d --build
```
2. Enter "server-php" container:
```bash
docker compose exec server-php bash
```
3. Install dependencies:
```bash
composer install
```
4. Create database:
```bash
bin/console doctrine:database:create
```
5. Execute migrations:
```bash
bin/console doctrine:migrations:migrate
```
6. Optionally load fixtures:
```bash
bin/console doctrine:fixture:load
```
7. Enter "client-php" container:
```bash
docker compose exec client-php bash
```
8. Install dependencies:
```bash
composer install
```
9. Show the list of available commands:
```bash
bin/console list api
```
