<?php namespace App\Models;

use App\User;
use illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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
