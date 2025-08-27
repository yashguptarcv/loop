<?php

namespace Modules\Payments\Services;

use InvalidArgumentException;
use Modules\Payments\Contracts\PaymentProcessor;

class PaymentsProcessorRegistry
{
    /**
     * @var array<string, PaymentProcessor>
     */
    protected array $processors = [];

    /**
     * Register a processor.
     */
    public function register(string $code, PaymentProcessor $processor): void
    {
        $this->processors[$code] = $processor;
    }

    /**
     * Check if a processor is registered.
     */
    public function has(string $code): bool
    {
        return isset($this->processors[$code]);
    }

    /**
     * Get a processor by code.
     */
    public function get(string $code): PaymentProcessor
    {
        if (! $this->has($code)) {
            throw new InvalidArgumentException("Payment processor [{$code}] not registered.");
        }

        return $this->processors[$code];
    }

    /**
     * Get all registered processors.
     */
    public function all(): array
    {
        return $this->processors;
    }
}
