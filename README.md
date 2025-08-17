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

## GitHub Pages preview

The static frontend located in `frontend/` is automatically published to GitHub Pages using the workflow in `.github/workflows/pages.yml`.
Push changes to `main` and visit the repository's Pages environment to view the site.

## Development Environment

Enhanced setup workflow:

### Dev Container (optional)
If using VS Code Dev Containers or GitHub Codespaces, the provided devcontainer will:
- Install PHP, Node.js, and MySQL
- Run `./setup.sh --db-wait --seed`
- Serve the app on port 8000

### Local Setup
Requirements: PHP (compatible with project), Composer, Node (npm/yarn/pnpm), and a MySQL database (or update DB_* in .env).

Commands:
```bash
./setup.sh --db-wait --seed
# or
make init
```

Re-run safely at any time; the script is idempotent.

### setup.sh Flags
| Flag | Description |
|------|-------------|
| `--db-wait` | Wait for database readiness |
| `--db-timeout=SECONDS` | Override wait timeout (default 90) |
| `--seed` | Seed after migrate |
| `--refresh-db` | Use migrate:fresh |
| `--skip-migrate` | Skip all migrations |
| `--skip-npm` | Skip npm install |
| `--skip-composer` | Skip composer install |
| `--optimize` | Run artisan optimize |
| `--verbose` | Extra debug output |
| `--help` | Show help |

Examples:
```bash
./setup.sh --db-wait --seed
./setup.sh --refresh-db --seed
./setup.sh --skip-npm --skip-migrate
./setup.sh --db-wait --db-timeout=150 --optimize
```

### Makefile Targets
Run `make help` to list all targets.
Common:
- `make init`
- `make dev`
- `make migrate` / `make fresh` / `make seed`
- `make test` / `make test-parallel`
- `make pint`
- `make node-dev` / `make node-build`

### Troubleshooting
| Issue | Resolution |
|-------|------------|
| DB wait timeout | Increase `--db-timeout` |
| Permission denied on setup.sh | `chmod +x setup.sh` |
| DB auth errors | Check DB_* values in `.env` |
| Node version mismatch | Align local Node version with project requirements |
