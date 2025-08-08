<?php
namespace Modules\DataView\View\Components\DataView;

use Illuminate\View\Component;

class Layout extends Component
{
    public $title;
    public $data;
    public $back_url;
    public $back_title;
    public function __construct(array $data = [], $title = '', $back_url = '', $back_title = '')
    {
        $this->title = $title;
        $this->data = $data;
        $this->back_url = $back_url;
        $this->back_title = $back_title;
    }

    public function render()
    {
     
        $data = $this->data;
        return view('dataview::components.dataView.layout', compact('data'));
    }
}
