<?php
namespace Modules\Admin\View\Components\Common;

use Illuminate\View\Component;

class StatusModal extends Component
{


    public function __construct(

    ) {

    }

    public function render()
    {
        return view('admin::components.common.status-modal');
    }
}
