#!/usr/bin/env bash
# Enhanced setup script for local & Dev Container environments.
# Features: idempotent, DB wait, selective steps, seeding, refresh DB, optimize, verbose mode.
set -euo pipefail

DB_WAIT=false
DB_TIMEOUT=90
DO_SEED=false
REFRESH_DB=false
SKIP_MIGRATE=false
SKIP_NPM=false
SKIP_COMPOSER=false
RUN_OPTIMIZE=false
VERBOSE=false

COLOR_YELLOW="\033[33m"
COLOR_GREEN="\033[32m"
COLOR_RED="\033[31m"
COLOR_DIM="\033[2m"
COLOR_RESET="\033[0m"

log() { echo -e "${COLOR_GREEN}==>${COLOR_RESET} $*"; }
info() { echo -e "${COLOR_YELLOW}--${COLOR_RESET} $*"; }
warn() { echo -e "${COLOR_YELLOW}WARN:${COLOR_RESET} $*"; }
err() { echo -e "${COLOR_RED}ERROR:${COLOR_RESET} $*" >&2; }
debug() { [[ "$VERBOSE" == true ]] && echo -e "${COLOR_DIM}DEBUG:${COLOR_RESET} $*"; }

print_help() {
    cat <<'EOF'
Enhanced setup script.
Flags:
  --db-wait              Wait for database readiness
  --db-timeout=SECONDS   Override wait timeout (default 90)
  --seed                 Run db:seed after migrations
  --refresh-db           Use migrate:fresh
  --skip-migrate         Skip all migrations
  --skip-npm             Skip npm install
  --skip-composer        Skip composer install
  --optimize             Run artisan optimize
  --verbose              Extra debug output
  --help                 Show this help
Incompatible: --refresh-db with --skip-migrate
EOF
}

for arg in "$@"; do 
    case "$arg" in
        --db-wait) DB_WAIT=true;;
        --db-timeout=*) DB_TIMEOUT="${arg#*=}";;
        --seed) DO_SEED=true;;
        --refresh-db) REFRESH_DB=true;;
        --skip-migrate) SKIP_MIGRATE=true;;
        --skip-npm) SKIP_NPM=true;;
        --skip-composer) SKIP_COMPOSER=true;;
        --optimize) RUN_OPTIMIZE=true;;
        --verbose) VERBOSE=true;;
        --help|-h) print_help; exit 0;;
        *) err "Unknown flag: $arg"; print_help; exit 1;;
    esac
done

if [[ "$REFRESH_DB" == true && "$SKIP_MIGRATE" == true ]]; then 
    err "--refresh-db and --skip-migrate cannot be used together."
    exit 1
fi

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_ROOT"

if [[ ! -f artisan ]]; then 
    err "artisan not found. Run from project root."
    exit 1
fi

ensure_env() {
    if [[ ! -f .env ]]; then 
        if [[ -f .env.example ]]; then 
            log "Creating .env from .env.example"
            cp .env.example .env
        else 
            warn ".env.example missing; creating minimal .env"
            cat > .env <<EOF
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
LOG_CHANNEL=stack
LOG_LEVEL=debug
DB_CONNECTION=mysql
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-laravel}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD:-}
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
BROADCAST_DRIVER=log
EOF
        fi
    else 
        debug ".env present"
    fi
}

composer_install() {
    if [[ "$SKIP_COMPOSER" == true ]]; then 
        info "Skipping composer install"
        return
    fi
    
    if [[ -d vendor && -f vendor/autoload.php ]]; then 
        info "Composer deps already installed"
    else 
        log "Installing Composer deps"
        composer install --no-interaction --prefer-dist
    fi
}

npm_install() {
    if [[ "$SKIP_NPM" == true ]]; then 
        info "Skipping npm install"
        return
    fi
    
    if [[ -d node_modules ]]; then 
        info "node_modules present; skipping install"
    else 
        log "Installing Node deps"
        if command -v pnpm >/dev/null 2>&1 && [[ -f pnpm-lock.yaml ]]; then 
            pnpm install
        elif command -v yarn >/dev/null 2>&1 && [[ -f yarn.lock ]]; then 
            yarn install
        else 
            npm install
        fi
    fi
    
    if [[ -f package.json ]] && command -v jq >/dev/null 2>&1; then 
        if jq '.scripts | has("build")' package.json >/dev/null 2>&1; then 
            info "Optional build: npm run build"
        fi
    fi
}

generate_key() {
    if grep -q '^APP_KEY=$' .env 2>/dev/null || grep -q '^APP_KEY=""$' .env 2>/dev/null || ! grep -q '^APP_KEY=' .env; then 
        log "Generating app key"
        php artisan key:generate
    else 
        debug "APP_KEY already set"
    fi
}

wait_for_db() {
    [[ "$DB_WAIT" != true ]] && return
    
    local host="${DB_HOST:-127.0.0.1}" 
    local port="${DB_PORT:-3306}"
    log "Waiting for DB ${host}:${port} (timeout ${DB_TIMEOUT}s)"
    
    local start=$(date +%s)
    while true; do 
        if php -r "
\$h=getenv('DB_HOST')?:'127.0.0.1';
\$P=getenv('DB_PORT')?:'3306';
\$u=getenv('DB_USERNAME')?:'root';
\$p=getenv('DB_PASSWORD');
\$d=getenv('DB_DATABASE');
try {
    new PDO(\"mysql:host=\$h;port=\$P;dbname=\$d\", \$u, \$p, [PDO::ATTR_TIMEOUT=>2]);
    exit(0);
} catch(Throwable \$e) {
    exit(1);
}"; then 
            info "Database reachable"
            break
        fi
        
        local now=$(date +%s)
        if (( now - start >= DB_TIMEOUT )); then 
            err "Database wait timed out after ${DB_TIMEOUT}s"
            exit 1
        fi
        sleep 2
    done
}

run_migrations() {
    if [[ "$SKIP_MIGRATE" == true ]]; then 
        info "Skipping migrations"
        return
    fi
    
    if [[ "$REFRESH_DB" == true ]]; then 
        log "migrate:fresh"
        php artisan migrate:fresh --force
    else 
        log "migrate"
        php artisan migrate --force
    fi
    
    if [[ "$DO_SEED" == true ]]; then 
        log "Seeding database"
        php artisan db:seed --force
    fi
}

clear_caches() {
    log "Clearing framework caches"
    php artisan cache:clear || true
    php artisan config:clear || true
    php artisan route:clear || true
    php artisan view:clear || true
}

optimize() {
    if [[ "$RUN_OPTIMIZE" == true ]]; then 
        log "Optimizing"
        php artisan optimize
    else 
        info "Skipping optimize (enable with --optimize)"
    fi
}

summary() {
    echo -e "${COLOR_GREEN}Setup complete!${COLOR_RESET}"
    echo "Flags:"
    echo "  DB_WAIT=$DB_WAIT  DO_SEED=$DO_SEED  REFRESH_DB=$REFRESH_DB  SKIP_MIGRATE=$SKIP_MIGRATE"
    echo "  SKIP_NPM=$SKIP_NPM  SKIP_COMPOSER=$SKIP_COMPOSER  RUN_OPTIMIZE=$RUN_OPTIMIZE"
}

# Main execution
log "Starting setup"
ensure_env
composer_install
npm_install
generate_key
wait_for_db
run_migrations
clear_caches
optimize
summary