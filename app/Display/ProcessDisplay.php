<?php

namespace App\Display;

class ProcessDisplay extends \SleepingOwl\Admin\Display\Display
{
    /**
     * Display constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->extend('process_table', new \App\Display\Extension\ProcessTable());
    }
}