<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserArtifact
 *
 * @property int $id
 * @property int|null $artifact_id
 * @property int|null $user_id
 * @property-read \App\Models\Artifact|null $artifact
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserArtifact whereArtifactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserArtifact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserArtifact whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $equip
 * @method static \Illuminate\Database\Eloquent\Builder|UserArtifact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArtifact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArtifact query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserArtifact whereEquip($value)
 */
class UserArtifact extends Model
{
    public $timestamps = false;

    protected $table = 'user_artifact';
    protected $fillable = ['artifact_id', 'user_id'];

    public function artifact(){
        return $this->belongsTo(Artifact::class);
    }

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
