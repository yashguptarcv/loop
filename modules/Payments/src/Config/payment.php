<?php

use Modules\Payments\Processors\StripeProcessor;

return [
    'processors' => [
        'stripe' => StripeProcessor::class,
    ],

    'default_currency' => 'USD',
];
