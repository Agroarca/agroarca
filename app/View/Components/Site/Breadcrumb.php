<?php

namespace App\View\Components\Site;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $breadcrumbLinks;

    public function __construct($breadcrumbLinks)
    {
        $this->breadcrumbLinks = $breadcrumbLinks;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.site.breadcrumb');
    }
}
