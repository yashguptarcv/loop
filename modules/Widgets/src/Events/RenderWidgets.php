<?php

namespace Modules\Widgets\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Modules\Acl\Models\Admin;

class RenderWidgets
{
    use Dispatchable;

    public $user;

    public function __construct(Admin $user)
    {
        $this->user = $user;
    }
}
