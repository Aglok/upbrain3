<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $phone
 * @property string $address
 * @property string|null $email
 * @property string|null $friend
 * @property string $comment
 * @property string $birthday
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereFriend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $patronymic
 * @property string|null $subjects
 * @property string|null $type_of_training
 * @property string|null $hei
 * @property string|null $place
 * @property string|null $points
 * @property string|null $additionally
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereAdditionally($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereHei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSubjects($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereTypeOfTraining($value)
 */
class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'patronymic' ,
        'phone',
        'subjects',
        'link',
        'type_of_training',
        'hei',
        'points',
        'place',
        'additionally',
        'address',
        'email',
        'special_offer',
        'comment',
        'birthday'
    ];
}
