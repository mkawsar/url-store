# Url Store

## Project installation and setup

> #### STEP 01: Install composer on docker:

```bash
https://github.com/mkawsar/url-store
```

> #### STEP 02: Project clone from GitHub:

```bash
git clone https://github.com/mkawsar/url-store
```

> #### STEP 03: Enter project directory:

```bash
cd url-store
```

> #### STEP 04: Build app

```bash
docker-compose up --build -d
```
> #### STEP 05: Project Environment setup

```bash
docker-compose exec app composer install
```

```bash
docker container start scheduler
```

```bash
docker-compose exec app cp .env.example .env
```

> #### STEP 06: App key generate
```bash
docker-compose exec app php artisan key:generate
```
> #### STEP 07: Database setup
```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```
###### Note: Replace the database section of the previous env file with the new database config

> #### STEP 08: Database migration:

```bash
docker-compose exec app php artisan migrate
```

> #### STEP 09: Stop the project:

```bash
docker-compose down
```

### Support
If you have any questions or confusion please email me at **mkawsarahmed@outlook.com** or open an issue in the repository.
Done !
