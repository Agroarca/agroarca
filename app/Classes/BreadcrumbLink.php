<?php

namespace App\Classes;

class BreadcrumbLink
{
    public $link;
    public $texto;

    public function __construct($link, $texto){
        $this->link = $link;
        $this->texto = $texto;
    }
}
