<?php

namespace Modules\Widgets\Listeners;

use Modules\Widgets\Events\RenderWidgets;
use Modules\Widgets\Models\Widget;

class InjectWidgets
{
    public function handle(RenderWidgets $event): string
    {

        $roleId = $event->user->role_id;

        $widgets = Widget::query()
            ->whereRaw("JSON_CONTAINS_PATH(user_groups, 'one', '$.\"$roleId\"')")
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('widgets::partials.widgets', compact('widgets'))->render();
    }
}
