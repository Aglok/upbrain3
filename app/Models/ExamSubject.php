<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ExamSubject
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamSubject whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExamSubject whereName($value)
 * @mixin \Eloquent
 */
class ExamSubject extends Model
{
    public $timestamps = false;
    protected $table = 'exam_subjects';
    protected $fillable = ['name', 'description'];

}
