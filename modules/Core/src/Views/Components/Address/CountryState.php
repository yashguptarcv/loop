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
    public $country_name;
    public $state_name;

    /**
     * Create a new component instance.
     */
    public function __construct($selectedCountry = null, $selectedState = null, $prefix = null, $country_name = null, $state_name = null)
    {
        $this->countries = Country::orderBy('name')->get();
        $this->selectedCountry = $selectedCountry;
        $this->selectedState = $selectedState;
        $this->prefix = $prefix;
        $this->country_name = $country_name;
        $this->state_name = $state_name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('core::components.address.country-state');
    }
}
