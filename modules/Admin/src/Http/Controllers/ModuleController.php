<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ModuleController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
} 