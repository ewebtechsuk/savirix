<?php

namespace App\Support;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;

class AppKeyManager
{
    /**
     * Ensure the application has an encryption key.
     */
    public static function ensure(): void
    {
        $key = static::normalise(Config::get('app.key'))
            ?? static::normalise(env('APP_KEY'))
            ?? static::readStoredKey();

        if ($key === null) {
            $key = static::generateKey(Config::get('app.cipher', 'AES-256-CBC'));
            static::storeKey($key);
        } else {
            static::storeKeyIfMissing($key);
        }

        static::inject($key);
    }

    /**
     * Normalise a potential key value.
     */
    protected static function normalise(?string $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    /**
     * Read a stored key from disk.
     */
    protected static function readStoredKey(): ?string
    {
        $path = static::keyStoragePath();

        if (! is_file($path)) {
            return null;
        }

        return static::normalise(@file_get_contents($path) ?: null);
    }

    /**
     * Generate a new key for the application.
     */
    protected static function generateKey(string $cipher): string
    {
        return 'base64:'.base64_encode(Encrypter::generateKey($cipher));
    }

    /**
     * Store the key on disk if it is missing or different.
     */
    protected static function storeKeyIfMissing(string $key): void
    {
        $path = static::keyStoragePath();

        if (is_file($path)) {
            $existing = static::normalise(@file_get_contents($path) ?: null);

            if ($existing === $key) {
                return;
            }
        }

        static::storeKey($key);
    }

    /**
     * Persist the key to storage.
     */
    protected static function storeKey(string $key): void
    {
        $path = static::keyStoragePath();
        $directory = dirname($path);

        if (! is_dir($directory)) {
            @mkdir($directory, 0755, true);
        }

        if (! is_writable($directory)) {
            return;
        }

        @file_put_contents($path, $key.PHP_EOL, LOCK_EX);
    }

    /**
     * Resolve the storage path for the key file.
     */
    protected static function keyStoragePath(): string
    {
        return storage_path('app.key');
    }

    /**
     * Inject the key into the runtime configuration and environment.
     */
    protected static function inject(string $key): void
    {
        Config::set('app.key', $key);

        putenv('APP_KEY='.$key);
        $_ENV['APP_KEY'] = $key;
        $_SERVER['APP_KEY'] = $key;
    }
}
