<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SheetsSectionsImport implements WithMultipleSheets
{
    /**
     * @param string
     * Название листа в таблице
     */
    public $subject;



    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function sheets(): array
    {
        return [
            'sections_'.$this->subject => new SectionsImport('sections_'.$this->subject),
            'categories_'.$this->subject => new SectionsImport('categories_'.$this->subject),
        ];
    }
}
