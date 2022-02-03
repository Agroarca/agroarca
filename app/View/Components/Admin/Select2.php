<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Select2 extends Component
{
    public $id;
    public $name;
    public $values;
    public $selected;
    public $placeholder;
    public $selectPlaceholder;
    public $class;

    public function __construct($name, $values, $placeholder = null, $selected = null, $id = null, $class = null, $selectPlaceholder = false)
    {
        $this->id = $id ?? $name;
        $this->name = $name;
        $this->values = $values;
        $this->selected = null;
        $this->placeholder = $placeholder;
        $this->class = $class;
        $this->selectPlaceholder = $selectPlaceholder;

        foreach ($values as $key => $value) {
            if ($selected == $key) {
                $this->selected = $selected;
                break;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.select2');
    }
}
