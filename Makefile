# Makefile for developer productivity
SHELL := /usr/bin/env bash
.DEFAULT_GOAL := help
APP_PORT ?= 8000
PHP ?= php
ARTISAN := $(PHP) artisan
help:
	@echo "Available targets:";
	@grep -E '^[a-zA-Z0-9_.-]+:.*?## ' $(MAKEFILE_LIST) | sed -E 's/:.*## / -> /'
init: ## Full project initialization (deps, wait DB, seed)
	@chmod +x setup.sh || true
	./setup.sh --db-wait --seed
dev: ## Serve the application
	$(ARTISAN) serve --host=0.0.0.0 --port=$(APP_PORT)
fresh: ## Fresh migrate + seed
	$(ARTISAN) migrate:fresh --seed
seed: ## Seed database only
	$(ARTISAN) db:seed
migrate: ## Run new migrations
	$(ARTISAN) migrate
refresh-db: ## Drop all tables & migrate
	$(ARTISAN) migrate:fresh
optimize: ## Artisan optimize
	$(ARTISAN) optimize
cache-clear: ## Clear all caches
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) route:clear
	$(ARTISAN) view:clear
pint: ## Run Laravel Pint (if installed)
	@if command -v vendor/bin/pint >/dev/null 2>&1; then vendor/bin/pint; else echo "Pint not installed (composer require laravel/pint --dev)"; fi
test: ## Run PHPUnit tests
	$(PHP) vendor/bin/phpunit
test-parallel: ## Run parallel tests (requires laravel/parallel-testing)
	$(ARTISAN) test --parallel
node-dev: ## JS dev server (if script exists)
	@if grep -q '"dev"' package.json 2>/dev/null; then npm run dev; else echo "No dev script in package.json"; fi
node-build: ## JS production build (if script exists)
	@if grep -q '"build"' package.json 2>/dev/null; then npm run build; else echo "No build script in package.json"; fi
lint: pint ## Alias for Pint ##
clean: cache-clear ## Clear caches ##
.PHONY: help init dev fresh seed migrate refresh-db optimize cache-clear pint test test-parallel node-dev node-build lint clean