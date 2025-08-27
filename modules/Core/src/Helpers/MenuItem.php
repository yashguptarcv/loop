<?php

namespace Modules\Core\Helpers;

class MenuItem
{
    public string $label;
    public ?string $route = null;
    public ?string $icon = null;
    public ?string $permission = null;
    /** @var MenuItem[] */
    public array $children = [];

    public function __construct(
        string $label,
        ?string $route = null,
        ?string $icon = null,
        ?string $permission = null,
        array $children = []
    ) {
        $this->label = $label;
        $this->route = $route;
        $this->icon = $icon;
        $this->permission = $permission;

        // Normalize children into MenuItem objects
        foreach ($children as $child) {
            $this->children[] = $child instanceof MenuItem
                ? $child
                : new MenuItem(...$child);
        }
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'route' => $this->route,
            'icon'  => $this->icon,
            'permission' => $this->permission,
            'children' => array_map(fn($c) => $c->toArray(), $this->children),
        ];
    }
}
