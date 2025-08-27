<?php
namespace Modules\Core\View\Components;

use Illuminate\View\Component;
use Modules\Admin\Models\Country;

class LocationSelector extends Component
{
    public $countries;
    public $selectedCountry;
    public $selectedState;
    public $selectedCity;
    
    public function __construct($selectedCountry = null, $selectedState = null, $selectedCity = null)
    {
        $this->countries = Country::all();
        $this->selectedCountry = $selectedCountry;
        $this->selectedState = $selectedState;
        $this->selectedCity = $selectedCity;
    }
    
    public function render()
    {
        return view('admin::components.location-selector');
    }
}