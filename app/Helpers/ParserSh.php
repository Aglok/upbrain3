<?php

namespace App\Helpers;

class ParserSh{

    public $link = 'https://shkolkovo.net/catalog';

    protected $settings = [];

    public function setSettingsFilterElement($key, $value)
    {
        $this->settings[$key] = $value;
    }

}