<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class Modal extends Component
{
    public $class;
    public $id;
    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = [], $id = null, $title = '')
    {
        $defaultClasses = ['modal'];
        $this->class = array_merge($defaultClasses, $class);
        $this->id = $id;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.modal');
    }
}
