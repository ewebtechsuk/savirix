<?php

namespace App\Services;

use App\Models\Tenant;

class TenantProvisioningResult
{
    public const STATUS_SUCCESS = 'success';
    public const STATUS_PARTIAL = 'partial_failure';
    public const STATUS_ROLLED_BACK = 'rolled_back';

    /**
     * @param array<int, string> $messages
     * @param array<int, string> $errors
     */
    private function __construct(
        private readonly string $status,
        private readonly ?Tenant $tenant,
        private readonly array $messages,
        private readonly array $errors,
    ) {
    }

    /**
     * @param array<int, string> $messages
     */
    public static function success(Tenant $tenant, array $messages = []): self
    {
        return new self(self::STATUS_SUCCESS, $tenant, $messages, []);
    }

    /**
     * @param array<int, string> $messages
     * @param array<int, string> $errors
     */
    public static function partial(Tenant $tenant, array $messages = [], array $errors = []): self
    {
        return new self(self::STATUS_PARTIAL, $tenant, $messages, $errors);
    }

    /**
     * @param array<int, string> $messages
     * @param array<int, string> $errors
     */
    public static function rolledBack(?Tenant $tenant, array $messages = [], array $errors = []): self
    {
        return new self(self::STATUS_ROLLED_BACK, $tenant, $messages, $errors);
    }

    public function status(): string
    {
        return $this->status;
    }

    public function tenant(): ?Tenant
    {
        return $this->tenant;
    }

    /**
     * @return array<int, string>
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * @return array<int, string>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    public function message(): string
    {
        return trim(implode(' ', array_merge($this->messages, $this->errors)));
    }

    public function flashLevel(): string
    {
        return match ($this->status) {
            self::STATUS_SUCCESS => 'success',
            self::STATUS_PARTIAL => 'warning',
            default => 'error',
        };
    }

    /**
     * @return array{status: string, tenant_id: string|null, messages: array<int, string>, errors: array<int, string>}
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'tenant_id' => $this->tenant?->getKey(),
            'messages' => $this->messages,
            'errors' => $this->errors,
        ];
    }
}
