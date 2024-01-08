<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class School extends Model
{
    public $timestamps = false;
    protected $table = 'schools';

    protected $fillable = ['name', 'district', 'alias','description','images','files'];

    /**
     * Получить все предметы школы
     *
     * @return BelongsToMany
     */
    public function subjects(): BelongsToMany
    {

        return $this->belongsToMany(Subject::class, 'school_subject');
    }
}
