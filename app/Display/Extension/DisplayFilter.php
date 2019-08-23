<?php

namespace App\Display\Extension;

use SleepingOwl\Admin\Display\Extension\Extension;
use KodiComponents\Support\HtmlAttributes;
use SleepingOwl\Admin\Contracts\Display\Placable;

class DisplayFilter extends Extension implements Placable
{
    use HtmlAttributes;

    protected $actions;
    public $view = 'admin.extensions.html';
    protected $placement = 'after.panel';

    public function __construct()
    {
        $this->setView($this->view);

    }

    public function setView($view)
    {
        $this->view = view($view);
        return $this;
    }

    function toArray()
    {
        return [
            'placement' => $this->getPlacement()
        ];
    }
    public function getPlacement()
    {
        return $this->placement;
    }

    public function getView()
    {
        return $this->view;
    }

}