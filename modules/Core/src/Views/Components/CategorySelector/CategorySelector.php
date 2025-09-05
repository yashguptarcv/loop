<?php

namespace Modules\Core\Views\Components\CategorySelector;

use Illuminate\View\Component;

class CategorySelector extends Component
{
    /**
     * Parent categories with children.
     *
     * Example:
     * [
     *   'Technology' => ['AI', 'Blockchain'],
     *   'Finance' => ['Banking', 'Insurance']
     * ]
     */
    public array $parentCategories;

    public ?string $selectedParent;
    public ?string $selectedChild;
    public ?string $parentname;
    public ?string $childname;
    public ?string $othername;
    public ?bool $showLabel = true;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $parentCategories = [],
        string $selectedParent = null,
        string $selectedChild = null,
        string $parentname = null,
        string $childname = null,
        string $othername = null,
        bool $showLabel = null
    ) {
        $this->parentCategories = $parentCategories;
        $this->selectedParent = $selectedParent;
        $this->selectedChild = $selectedChild;
        $this->showLabel = $showLabel;
        $this->parentname = $parentname;
        $this->childname = $childname;
        $this->othername = $othername;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('core::components.category-selector.categoryselector');
    }
}
