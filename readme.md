# Up and running


## Install dependencies

```bash
composer install
```

## Create your database file

```bash
touch /absolute/path/to/db.sqlite
```

## Update your .env

Copy `.env.example` to `.env`
Change the `DB_DATABASE=/absolute/path/to/db.sqlite`

## Serve locally

```bash
php artisan serve
```

Visit http://localhost:8000

## Run the tests

```bash
./vendor/bin/phpunit
```

## Available JSON API endpoints

POST /storeProduct
{name, description, price}

GET /listProducts
[
{name, description, price},
{name, description, price},
{name, description, price},
...
]