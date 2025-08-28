<?php

namespace Modules\Core\Views\Components\Address;

use Illuminate\View\Component;
use Modules\Admin\Models\Country;

class CountryState extends Component
{
    public $countries;
    public $selectedCountry;
    public $selectedState;
    public $prefix;

    /**
     * Create a new component instance.
     */
    public function __construct($selectedCountry = null, $selectedState = null, $prefix = null)
    {
        $this->countries = Country::orderBy('name')->get();
        $this->selectedCountry = $selectedCountry;
        $this->selectedState = $selectedState;
        $this->prefix = $prefix;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('core::components.address.country-state');
    }
}
