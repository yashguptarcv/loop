<?php

namespace Modules\Core\Events;

use Modules\Core\Helpers\MenuItem;

class Menus
{
    /** @var MenuItem[] */
    public array $items = [];

    public function register(MenuItem $item): void
    {
        $this->items[] = $item;
    }

    public function all(): array
    {
        return array_map(fn ($i) => $i->toArray(), $this->items);
    }
}
