<?php

namespace Illuminate\Support\Facades;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class Auth
{
    private static string $defaultGuard = 'web';

    /** @var array<string, AuthGuard> */
    private static array $guards = [];

    public static function guard(?string $name = null): AuthGuard
    {
        $name ??= self::$defaultGuard;

        if (!isset(self::$guards[$name])) {
            $guardConfig = config("auth.guards.$name");

            if ($guardConfig === null) {
                throw new InvalidArgumentException("Auth guard [$name] is not defined.");
            }

            $providerName = $guardConfig['provider'] ?? null;
            $providerConfig = $providerName ? config("auth.providers.$providerName") : null;

            self::$guards[$name] = new AuthGuard($providerConfig ?? []);
        }

        return self::$guards[$name];
    }

    public static function shouldUse(string $name): void
    {
        self::$defaultGuard = $name;
    }

    public static function check(): bool
    {
        return self::guard()->check();
    }

    public static function user(): ?Model
    {
        return self::guard()->user();
    }

    public static function id(): ?int
    {
        return self::guard()->id();
    }

    public static function login(Authenticatable|Model $user, bool $remember = false): void
    {
        self::guard()->login($user, $remember);
    }

    public static function logout(): void
    {
        self::guard()->logout();
    }

    public static function attempt(array $credentials, bool $remember = false): bool
    {
        return self::guard()->attempt($credentials, $remember);
    }
}

class AuthGuard
{
    /** @var array<string, mixed> */
    private array $providerConfig;

    private ?Model $user = null;

    /**
     * @param  array<string, mixed>  $providerConfig
     */
    public function __construct(array $providerConfig = [])
    {
        $this->providerConfig = $providerConfig;
    }

    public function check(): bool
    {
        return $this->user !== null;
    }

    public function user(): ?Model
    {
        return $this->user;
    }

    public function id(): ?int
    {
        return $this->user?->getKey();
    }

    public function login(Authenticatable|Model $user, bool $remember = false): void
    {
        if (! $user instanceof Model) {
            $resolved = $this->resolveModelInstance($user);

            if (! $resolved) {
                throw new InvalidArgumentException('Unable to resolve guard user instance for login.');
            }

            $user = $resolved;
        }

        $this->user = $user;
    }

    public function logout(): void
    {
        $this->user = null;
    }

    public function attempt(array $credentials, bool $remember = false): bool
    {
        $user = $this->retrieveByCredentials($credentials);

        if (! $user) {
            return false;
        }

        $password = $credentials['password'] ?? null;

        if ($password === null || ! $this->validateCredentials($user, $password)) {
            return false;
        }

        $this->login($user, $remember);

        return true;
    }

    public function validate(array $credentials): bool
    {
        $user = $this->retrieveByCredentials($credentials);

        if (! $user) {
            return false;
        }

        $password = $credentials['password'] ?? null;

        return $password !== null && $this->validateCredentials($user, $password);
    }

    private function validateCredentials(Model $user, string $password): bool
    {
        $passwordField = $this->providerConfig['password_field'] ?? 'password';
        $stored = $user->getAttribute($passwordField);

        if ($stored === null) {
            return false;
        }

        return Hash::check($password, (string) $stored);
    }

    private function retrieveByCredentials(array $credentials): ?Model
    {
        $emailField = $this->providerConfig['email_field'] ?? 'email';

        $value = $credentials[$emailField] ?? $credentials['email'] ?? null;

        if ($value === null) {
            return null;
        }

        $modelClass = $this->providerConfig['model'] ?? User::class;

        if (! is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("Auth provider model [$modelClass] must extend " . Model::class . '.');
        }

        /** @var Model $model */
        return $modelClass::query()->where($emailField, $value)->first();
    }

    private function resolveModelInstance(Authenticatable $user): ?Model
    {
        $modelClass = $this->providerConfig['model'] ?? User::class;

        if (is_subclass_of($modelClass, Model::class) && method_exists($user, 'getAuthIdentifier')) {
            $identifier = $user->getAuthIdentifier();

            /** @var Model|null $model */
            $model = $modelClass::query()->find($identifier);

            return $model;
        }

        return null;
    }
}
