<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'processor',
        'is_active',
        'configuration'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'configuration' => 'array'
    ];

    public function payments()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getProcessorConfig()
    {
        $processorClass = config("payment.processors.{$this->processor}");
        
        if (!class_exists($processorClass)) {
            throw new \Exception("Payment processor {$this->processor} not found");
        }

        return new $processorClass($this->configuration ?? []);
    }
}