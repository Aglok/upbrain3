<?php namespace App\Models;

use App\User;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string|null $image
 * @property string|null $alt
 * @property string $text_html
 * @property int|null $user_id
 * @property string|null $keywords
 * @property string|null $description
 * @property string|null $link
 * @property int|null $published
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read mixed $cut
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post postForId()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAlt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTextHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{

    protected $table = 'posts';
    //Добавляем в выдачу вычисляемое поле
    protected $appends = array('cut');//регистрируем метод getCutAttribute()(Cut вставляется между get и Attribute), и создает поле которого нет в таблице БД.
    //Делаем поля доступными для автозаполнения
    protected $fillable = array('title', 'keywords', 'description', 'text', 'link', 'image',' alt', 'author', 'published', 'subject_title', 'subject_image', 'subject_text');

    public function getCutAttribute()
    {
        return Str::limit($this->attributes['text'], 120);//ограничивает по количеству символов
    }

    public function getValidator()
    {
        //массив со статистическими данными
        $validation = array(
            'title' => 'required|max:256',
            'link' => 'required|between:2,32',
            'text' => 'required'
        );

        return $validation;
    }

    public function scopePostForId($query)
    {
        return $query->where('id', '>', '3');
    }

    public function user() {

        return $this->belongsTo(\App\User::class);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function isAuthor(User $user)
    {
        return ! is_null($author = $this->user) && $author->id == $user->id;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->HasMany(Comment::class);
    }

    public function arrayTags(){
        return $this->tags()->get();
    }

    public function createdAt()
    {
        return $this->created_at->format('d.m.Y h:m');
    }

    public function author(){
        return User::find($this->user_id);
    }
}
