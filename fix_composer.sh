#!/bin/bash

set -euo pipefail

if command -v composer >/dev/null 2>&1; then
  COMPOSER_BIN=(composer)
elif [[ -f composer.phar ]]; then
  if ! command -v php >/dev/null 2>&1; then
    echo "PHP is required to run composer.phar but was not found." >&2
    exit 1
  fi
  COMPOSER_BIN=(php composer.phar)
else
  echo "Composer is not installed. Run ./setup.sh to download a local composer.phar." >&2
  exit 1
fi

# Remove only the vendor directory to ensure a clean state while keeping composer.lock
rm -rf vendor/

# Clear Composer cache
"${COMPOSER_BIN[@]}" clear-cache

# Reinstall dependencies from the existing lockfile
"${COMPOSER_BIN[@]}" install --no-interaction --prefer-dist --no-progress
