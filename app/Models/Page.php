<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['no_blocks', 'keywords', 'description', 'link' ,'title', 'title_4U', 'text', 'parent_id', 'order'];

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

}
