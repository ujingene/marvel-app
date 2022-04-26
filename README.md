# Marvel Characters APi & Bulk Csv Upload

## Marvel Universe Laravel Web App

This app displays a list of Marvel superheroes in a that fetch data from the [Marvel Comics API](https://developer.marvel.com/).

## Bulk Csv Upload
 The app also provides a way to bulk upload csv uploads


# Setup
Open up a terminal and navigate to the root directory of this project.

```
cp .env.example .env
```

## install composer dependecies
```
composer run install
```

## install npm dependecies
```
npm i
```

## Generate Application Key

```
php artisan key:generate
```

## Clear Application Configurations and Cache by running the following commands

```
php artisan config:cache
php artisan migrate:install
```

## update the database configurations with your preferred details

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marvel
DB_USERNAME=root
DB_PASSWORD=
```

## Run migrations
```
php artisan migrate:fresh
```

## Swap your Marvel Comics Api credentials here

```
MARVEL_API_KEY="${MARVEL_PUBLIC_API_KEY}"
MARVEL_API_SECRET="${MARVEL_PRIVATE_API_KEY}"
```

### run composer update
```
composer update
```

### start laravel dev server
```
php artisan serve
```

### open another terminal to execute queue worker
```
php artisan queue:worker
```

# To Execute tests
```
composer run tests
```
