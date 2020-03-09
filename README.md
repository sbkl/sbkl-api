# sbkl-api

A Laravel starter package.

### 1- Create a new laravel project

```
laravel new <project_name>
```

### 2- Create a new database

```
<project_name>
```

### 3- Setup .env

Update the database name, mail config and add a client URL for the password reset feature to work.

Do not forget to update the credentials `MAIL_USERNAME`, `MAIL_PASSWORD` and `MAIL_FROM_ADDRESS`.

```
DB_DATABASE=database_name

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="\${APP_NAME}"

CLIENT_URL=http://localhost:3000/
```

### 4- Install sbkl-api package

```
composer require sbkl/sbkl-api
```

### 5- Spatie roles and permissions config

Publish the config and migration files:

```
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

Change the permission migration name as below:

```
2001_01_01_000000_create_permission_tables
```

### 6- sbkl-api config

```
php artisan vendor:publish --force --provider="sbkl\SbklApi\SbklComponentsServiceProvider"
```

```
composer dump-autoload
```

### 7- Launch migration with seeder

```
php artisan migrate:refresh —seed
```

### 8- Passport setup

Generate the encryption key for Passport to generate tokens

```
php artisan passport:keys
```

Create passport oauth keys for project-app and project-client

```
php artisan passport:client --password
```

In Config/auth.php:

```php
'api' => [
    'driver' => 'passport',
    'provider' => 'users',
    'hash' => false,
],
```

### 9- Cors setup

In Config/cors.php:

```php
'paths' => [
    'api/*',
    'oauth/token',
],
```

### 9- Clean routes

Remove user routes from routes/api.php.

### Apendix

Setup test xml

```xml
<?xml version="1.0" encoding="UTF-8"?>

<phpunit backupGlobals="false"
         backupStaticAttributes="false"
         bootstrap="vendor/autoload.php"
         colors="true"
         convertErrorsToExceptions="true"
         convertNoticesToExceptions="true"
         convertWarningsToExceptions="true"
         processIsolation="false"
         stopOnFailure="false">
<testsuites>
<testsuite name="Unit">
<directory suffix="Test.php">./tests/Unit</directory>
</testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
    <filter>
        <whitelist processUncoveredFilesFromWhitelist="true">
            <directory suffix=".php">./app</directory>
        </whitelist>
    </filter>
    <php>
        <server name="APP_ENV" value="testing"/>
        <server name="BCRYPT_ROUNDS" value="4"/>
        <server name="CACHE_DRIVER" value="array"/>
        <server name="MAIL_DRIVER" value="array"/>
        <server name="DB_CONNECTION" value="sqlite"/>
        <server name="DB_DATABASE" value=":memory:"/>
        <server name="QUEUE_CONNECTION" value="sync"/>
        <server name="SESSION_DRIVER" value="array"/>
    </php>

</phpunit>
```

Symlink package in composer.json

```
    "repositories": [
        {
            "type": "path",
            "url": "../../package/php/sbkl-api"
        }
    ]
```
