<?php

namespace Modules\Core\Events;

class RegisterSettingsMenu
{
    /**
     * @var array
     */
    public array $items = [];

    public function register(array $item): void
    {
        $this->items[] = $item;
    }
}
