## Setup and Configuration


• Clone this repository
```
git clone https://windellevega@bitbucket.org/techventuresphwebdevelopers/riceup-api.git
```

• Install different packages using composer
```
composer install
```

• Edit `.env.example` file place necessary database credentials and save it as `.env`

• Generate Key
```
php artisan key:generate
```

•Create an empty database in MySQL (make sure that the database name matches the one you've placed on your `.env` file)

• Migrate the tables
```
php artisan migrate
```

• Setup Laravel Passport for API authentication
```
php artisan passport:install
```