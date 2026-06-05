A Laravel Livewire app to view and manage imported developer jobs.

## Setup

Run the setup command setup .env install composer / node dependancies.

```bash
composer run setup
```

Edit the .env file and fill in values.

Run database migrations after filling in databse credentials.

```bash
php artisan migrate
```

Run database seeder.

```bash
php artisan db:seed
```

Run the app.

```bash
composer run dev
```

## Commands

Running unit tests.

```bash
php artisan test
```

Check code coverage.

```bash
php artisan test --coverage
```

Running PHPStan checks.

```bash
composer run phpstan
```

Running Lint checks.

```bash
composer run test:lint
```

## Notes

Current Laravel version is 12.

[Upgrade to Laravel 13 guide](https://laravel.com/docs/13.x/upgrade)

[Laravel Security Support dates](https://laravel.com/docs/12.x/releases#support-policy)
