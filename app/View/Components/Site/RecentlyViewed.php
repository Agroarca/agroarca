<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class RecentlyViewed extends Component
{
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = [])
    {
        $defaultClasses = ['container'];
        $this->class = array_merge($defaultClasses, $class);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.recently-viewed');
    }
}
