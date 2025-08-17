#!/bin/bash

# Remove vendor and lock file to ensure a clean state
rm -rf vendor composer.lock

# Clear Composer cache
composer clear-cache

# Install dependencies fresh
composer install

# Run the existing setup script to finish app setup
./setup.sh
