<?php

namespace App;

use App\Models\Message;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\hasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use KodiComponents\Support\Upload;
use Illuminate\Http\UploadedFile;
use Cmgmyr\Messenger\Traits\Messagable;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use App\Models\UserProperty;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 * @property string $name
 * @property string $surname
 * @property string|null $login
 * @property int|null $group_math
 * @property int|null $group_physics
 * @property string|null $description
 * @property int|null $logins
 * @property int|null $last_login
 * @property mixed $avatar
 * @property string|null $class_person_id
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $sex
 * @property string|null $notify
 * @property int|null $active
 * @property-read string $avatar_url_or_blank
 * @property-read string $full_name
 * @property-read Collection|Message[] $messages
 * @property-read Collection|Participant[] $participants
 * @property-read Collection|Role[] $roles
 * @property-read Collection|Thread[] $threads
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User active($active)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereClassPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupMath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGroupPhysics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLogins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $gold
 * @property int|null $experience
 * @property int|null $tasks
 * @property-read Collection|\App\Models\Artifact[] $artifacts
 * @property-read int|null $artifacts_count
 * @property-read Collection|\App\Models\ClassPerson[] $classes_person
 * @property-read int|null $classes_person_count
 * @property-read Collection|\App\Models\GradeMath[] $grade_math
 * @property-read int|null $grade_math_count
 * @property-read Collection|\App\Models\GradePhysics[] $grade_physics
 * @property-read int|null $grade_physics_count
 * @property-read int|null $messages_count
 * @property-read int|null $participants_count
 * @property-read Collection|\App\Models\ProcessMath[] $processes_math
 * @property-read int|null $processes_math_count
 * @property-read Collection|\App\Models\ProcessPhysics[] $processes_physics
 * @property-read int|null $processes_physics_count
 * @property-read Collection|\App\Models\Progress[] $progresses
 * @property-read int|null $progresses_count
 * @property-read UserProperty|null $property
 * @property-read int|null $roles_count
 * @property-read Collection|\App\Models\Stage[] $stages_math
 * @property-read int|null $stages_math_count
 * @property-read Collection|\App\Models\Stage[] $stages_physics
 * @property-read int|null $stages_physics_count
 * @property-read int|null $threads_count
 * @property-read Collection|\App\Models\UserTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read Collection|\App\Models\ImageOfCharacter[] $user_bodies
 * @property-read int|null $user_bodies_count
 * @property-read Collection|\App\Models\Mission[] $user_missions
 * @property-read int|null $user_missions_count
 * @property-read Collection|\App\Models\Subject[] $user_subjects
 * @property-read int|null $user_subjects_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTasks($value)
 */
class User extends Authenticatable
{
        use HasRoles, Upload, Messagable;
        use PivotEventTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'description',
        'avatar',
        'sex',
        'active',
        'gold',
        'experience',
        'tasks'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'avatar' => 'string',
    ];

    /**
     * @return array
     */
    public function getUploadSettings(): array
    {
        return [
            'avatar' => [
                'fit' => [300, 300, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                }],
            ],
        ];
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    protected function getUploadFilename(UploadedFile $file): string
    {
        return md5($this->id).'.'.$file->getClientOriginalExtension();
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(string $password): void
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * @return string $full_name
     */
    public function getFullNameAttribute(): string
    {
        return $this->attributes['name'].' '.$this->attributes['surname'];
    }

    /**
     * @return string
     */
    public function getAvatarUrlOrBlankAttribute(): string
    {
        if (empty($url = $this->avatar_url)) {
            return asset('images/avatar/default/no-photo-male.png');
        }

        return $url;
    }


    /**
     * @param string $query
     * @param int $active
     * @return string
     * Принимает get запрос ?active=1, ?active=0
     */
    public function scopeActive(string $query, int $active): string
    {
        return $query->where('active', $active);
    }
    /**
     * Получить с все артефакты пользователя
     *
     * @return BelongsToMany
     */
    public function artifacts(): BelongsToMany
    {

        return $this->belongsToMany(Models\Artifact::class, 'user_artifact')->withPivot('equip');
    }
    /**
     * Получить все классы пользователя
     *
     * @return BelongsToMany
     */
    public function classes_person(): BelongsToMany
    {

        return $this->belongsToMany(Models\ClassPerson::class, 'user_class')->withPivot(['active']);
    }

    /**
     * Получить свойства пользователя
     *
     * @return HasOne
     */
    public function property(): HasOne
    {

        return $this->hasOne(Models\UserProperty::class);
    }

    /**
     * Получить все достижения пользователя
     *
     * @return BelongsToMany
     */
    public function progresses(): BelongsToMany
    {

        return $this->belongsToMany(Models\Progress::class, 'user_progress')->withPivot('progress_quality');
    }
    /**
     * Получить все образы пользователя
     *
     * @return BelongsToMany
     */
    public function user_bodies(): BelongsToMany
    {

        return $this->belongsToMany(Models\ImageOfCharacter::class, 'user_body')->withPivot('on');
    }
    /**
     * Получить все миссии пользователя
     *
     * @return BelongsToMany
     */
    public function user_missions(): BelongsToMany
    {

        //Передаём дополнительные параметры 'done', 'updated_at', 'created_at'
        return $this->belongsToMany(Models\Mission::class, 'user_mission')->withPivot('done', 'updated_at', 'created_at');
    }
    /**
     * Получить все выбранные предметы пользователя
     *
     * @return BelongsToMany
     */
    public function user_subjects(): BelongsToMany
    {

        return $this->belongsToMany(Models\Subject::class, 'user_subject');
    }

    /**
     * Получить весь процесс пользователя по математике
     *
     * @return HasMany
     */
    public function processes_math(): HasMany
    {

        return $this->hasMany(Models\ProcessMath::class);
    }

    /**
     * Получить весь процесс пользователя по физике
     *
     * @return HasMany
     */
    public function processes_physics(): HasMany
    {

        return $this->hasMany(Models\ProcessPhysics::class);
    }

    /**
     * Связанные Stage, через ProcessMath
     * firstKey - ключ по которому Process ищется из модели User process.user_id = id(localKey)
     * secondKey - ключ по которому Stage соединяется с Process process.stage_id(secondLocalKey) = stage.id(secondKey)
     * localKey - ключ по которому ищется текущая модель id(localKey)
     * secondLocalKey - ключ по которому соединается Process process.stage_id(secondLocalKey) = stage.id(secondKey)
     *
     * @return hasManyThrough
     */
    public function stages_math(): hasManyThrough
    {
        return $this->hasManyThrough(Models\Stage::class, Models\ProcessMath::class, 'user_id', 'id', 'id', 'stage_id');
    }

    /**
     * Связанные Stage, через ProcessPhysics
     *
     * @return hasManyThrough
     */
    public function stages_physics(): hasManyThrough
    {
        return $this->hasManyThrough(Models\Stage::class, Models\ProcessPhysics::class, 'user_id', 'id', 'id', 'stage_id');
    }

    /**
     * Получить всю статистику пользователя по математике
     *
     * @return HasMany
     */
    public function grade_math(): HasMany
    {

        return $this->hasMany(Models\GradeMath::class);
    }

    /**
     * Получить всю статистику пользователя по физике
     *
     * @return HasMany
     */
    public function grade_physics(): HasMany
    {

        return $this->hasMany(Models\GradePhysics::class);
    }

    /**
     * Получить всю статистику пользователя по математике
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {

        return $this->hasMany(Models\UserTransaction::class);
    }

    /**
     * Создаём события когда связанная модель создалась
     * После создания User и установления класса героя, создаётся UserProperty
     * pivotDetaching, pivotDetached, pivotUpdating, pivotUpdated
     */
    public static function boot()
    {
        parent::boot();

        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes){

                $classes_person = $model->classes_person()->first();

                //Если запись есть, то игнорируем базовые характеристики UserProperty
                if(!UserProperty::where('user_id', $model->id)->exists() && $classes_person){

                    UserProperty::firstOrCreate([
                        'user_id' => $model->id,
                        'attack' => $classes_person->attack,
                        'shield' => $classes_person->shield,
                        'damage_min' => $classes_person->damage_min,
                        'damage_max' => $classes_person->damage_max,
                        'hp' => $classes_person->hp,
                        'mp' => $classes_person->mp,
                        'energy' => $classes_person->energy,
                        'critical_damage' => $classes_person->critical_damage,
                        'critical_chance' => $classes_person->critical_chance,
                        'type_id' => $classes_person->type_id,
                    ]);
                }

        });
    }
}
