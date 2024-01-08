<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserTransaction
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $artifact_id
 * @property string|null $action
 * @property int|null $gold
 * @property int|null $red_crystal
 * @property int|null $blue_crystal
 * @property int|null $green_crystal
 * @property int|null $yellow_crystal
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereArtifactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereBlueCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereGreenCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereRedCrystal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserTransaction whereYellowCrystal($value)
 * @mixin \Eloquent
 */
class UserTransaction extends Model
{
    protected $table = 'user_transaction';
    protected $fillable = ['user_id', 'artifact_id', 'action', 'gold', 'quantity'];

    public function user(){
        return $this->belongsTo(\App\User::class);
    }
}
