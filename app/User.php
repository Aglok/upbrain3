<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use KodiComponents\Support\Upload;
use Illuminate\Http\UploadedFile;
use Cmgmyr\Messenger\Traits\Messagable;
use Hash;

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
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string|null $sex
 * @property string|null $notify
 * @property int|null $active
 * @property-read string $avatar_url_or_blank
 * @property-read string $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cmgmyr\Messenger\Models\Participant[] $participants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cmgmyr\Messenger\Models\Thread[] $threads
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
 */
class User extends Authenticatable
{
        use HasRoles, Upload, Messagable;

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
        'active'
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
        'avatar' => 'image',
    ];
    
    /**
     * @return array
     */
    public function getUploadSettings()
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
    protected function getUploadFilename(UploadedFile $file)
    {
        return md5($this->id).'.'.$file->getClientOriginalExtension();
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function isManager()
    {
        return $this->hasRole('manager');
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        if (!empty($password) && Hash::needsRehash($password)) {
            $this->attributes['password'] = bcrypt($password);
        }

    }

    /**
     * @return string $full_name
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['name'].' '.$this->attributes['surname'];
    }

    /**
     * @return string
     */
    public function getAvatarUrlOrBlankAttribute()
    {
        if (empty($url = $this->avatar_url)) {
            return asset('images/avatar/default/no-photo-male.png');
        }

        return $url;
    }


    /**
     * @return string
     * Принимает get запрос ?active=1, ?active=0
     */
    public function scopeActive($query, $active)
    {
        return $query->where('active', $active);
    }
    /**
     * Получить с все артифакты пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artifacts(){

        return $this->belongsToMany(Models\Artifact::class, 'user_artifact')->withPivot('equip');
    }
    /**
     * Получить все классы пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function classes_person(){

        return $this->belongsToMany(Models\ClassPerson::class, 'user_class');
    }
    /**
     * Получить все достижения пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function progresses(){

        return $this->belongsToMany(Models\Progress::class, 'user_progress');
    }
    /**
     * Получить все образы пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user_bodies(){

        return $this->belongsToMany(Models\ImageOfCharacter::class, 'user_body');
    }
    /**
     * Получить все миссии пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user_missions(){

        //Передаём дополнительные параметры 'done', 'updated_at', 'created_at'
        return $this->belongsToMany(Models\Mission::class, 'user_mission')->withPivot('done', 'updated_at', 'created_at');
    }
    /**
     * Получить все выбранные предметы пользователя
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user_subjects(){

        return $this->belongsToMany(Models\Subject::class, 'user_subject');
    }

    /**
     * Получить весь процесс пользователя по математике
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processes_math(){

        return $this->hasMany(Models\ProcessMath::class);
    }

    /**
     * Получить весь процесс пользователя по физике
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processes_physics(){

        return $this->hasMany(Models\ProcessPhysics::class);
    }

    /**
     * Получить всю статистику пользователя по математике
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grade_math(){

        return $this->hasMany(Models\GradeMath::class);
    }

    /**
     * Получить всю статистику пользователя по физике
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grade_physics(){

        return $this->hasMany(Models\GradePhysics::class);
    }
}
