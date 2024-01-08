<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Progress
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $rank
 * @property int|null $quality
 * @property string $description
 * @property string|null $image
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListCategorySubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListCountTasks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $super_progress_id
 * @property int|null $subject_id
 * @property string|null $list_section_id
 * @property string|null $list_categories_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mission[] $missions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListCategoriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereListSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Progress whereSuperProgressId($value)
 * @property string|null $list_grade
 * @property string|null $list_count_tasks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mission[] $mission
 * @property-read int|null $mission_count
 * @method static \Illuminate\Database\Eloquent\Builder|Progress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Progress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Progress query()
 */
class Progress extends Model
{
    
    protected $table = 'progresses';
    protected $fillable = ['id', 'super_progress_id', 'subject_id', 'name', 'type', 'rank' , 'quality', 'description','image','created_at','updated_at'];

    /**
     * Получить все квести связанные с прогрессом.
     */
    public function mission()
    {
        return $this->hasMany(Mission::class);
    }
}
