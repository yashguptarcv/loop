<?php

use Modules\Acl\Support\Bouncer;

if (! function_exists('bouncer')) {
    function bouncer(): Bouncer {
        return new Bouncer();
    }
}