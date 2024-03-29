<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use function explode;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class SectionsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @var string
     * Название таблицы
     */
    public string $table;

    /**
     * @var string
     * alias предмета math, physics
     */
    public string $subject;


    public function __construct($table_name)
    {
        $table_name = explode('_', $table_name);
        $this->table = $table_name[0];
        $this->subject = $table_name[1];
    }


    /**
    * @param array $row
    *
    * @return Model|null
    */
    public function model(array $row): ?Model
    {

        if($this->table == 'sections'){
            $modelSection = 'App\Models\Section'.ucfirst($this->subject);

                $insert = [
                    'name' => $row['name'],
                    'category_id' => $row['category_id'],
                    'code' => $row['code']
                ];

            if (!empty($insert)) {
                return new $modelSection($insert);
            }

        }else{
            $modelCategory = 'App\Models\Category'.ucfirst($this->subject);

            $insert = [
                'name' => $row['name'],
                'parent_category_id' => $row['parent_category_id'],
                'code' => $row['code']
            ];

            if (!empty($insert)) {
                return new $modelCategory($insert);
            }
        }

        return null;
    }



    public function chunkSize(): int
    {
        return 1000;
    }
}
