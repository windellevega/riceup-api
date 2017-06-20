## Setup and Configuration


• Clone this repository
```
git clone https://windellevega@bitbucket.org/techventuresphwebdevelopers/riceup-api.git
```

• Download objects and refs from remote repository and change branch
```
git fetch && git checkout api-auth
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

• Seed your database with sample data to start of
```
php artisan db:seed
```

• Setup Laravel Passport for API authentication
```
php artisan passport:install
```
NOTE: Generated Client ID and Client Secrets shall be used by your front end application


## Client Authentication on API

• Use this request format to authenticate your user (may vary depending on your language)
```
#!javascript
$response = $http->post('http://your-app.com/oauth/token', [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '<client-id>',
        'client_secret' => '<client-secret>',
        'username' => '<registered-username>',
        'password' => '<registered-password>',
        'scope' => '',
    ],
]);

```