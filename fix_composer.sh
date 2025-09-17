#!/bin/bash

# Remove the vendor directory to ensure a clean state while keeping the lockfile
rm -rf vendor

# Clear Composer cache
composer clear-cache

# Install dependencies fresh
composer install

# Run the existing setup script to finish app setup
./setup.sh
