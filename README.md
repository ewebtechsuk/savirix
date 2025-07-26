# ressapp

This repository contains a Laravel application.

## Running Artisan Commands

All Artisan commands must be executed from the project root where the `artisan` file lives.
For example, to view the list of available commands run:

```bash
php artisan list
```

You may run any other Artisan command in the same way:

```bash
php artisan migrate
```

## Running Tests

Tests are written with PHPUnit. After installing dependencies with Composer run the test suite from the project root:


```bash
./vendor/bin/phpunit
```

If you have PHPUnit installed globally you can simply run `phpunit` instead.


### Continuous Integration

A GitHub Actions workflow runs the PHPUnit suite on every push and pull request. The workflow is defined in `.github/workflows/ci.yml`.

## Deploying to Hostinger

1. Push your local code to a remote Git provider such as GitHub.
2. In Hostinger's **Git** interface choose **Add repository** and clone the repo into your account.
3. Set your domain (e.g. `darkorange-chinchilla-918430.hostingersite.com`) to use the project's `public` directory as its document root.
4. Enable SSH access and run the helper script from the project root:

   ```bash
   ./hostinger-setup.sh
   ```

   The script installs Composer dependencies, copies `.env.example` if needed,
   runs database migrations and adjusts directory permissions.

After configuration the site will be accessible at your Hostinger domain.

