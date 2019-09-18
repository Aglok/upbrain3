<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Artifact
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $image
 * @property int|null $artifact_type_id
 * @property int|null $attack
 * @property int|null $damage_min
 * @property int|null $damage_max
 * @property int|null $defense
 * @property int|null $magic
 * @property int|null $energy
 * @property float|null $increase_experience
 * @property float|null $increase_gold
 * @property int|null $rarity_id
 * @property float|null $weight
 * @property int|null $user_level
 * @property int|null $class_person_id
 * @property string|null $condition
 * @property int|null $durability
 * @property float|null $price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereArtifactTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereAttack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereClassPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereDamageMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereDamageMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereDefense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereDurability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereEnergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereIncreaseExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereIncreaseGold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereMagic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereRarityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereUserLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Artifact whereWeight($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Mission[] $missions
 */
class Artifact extends Model
{

    public $timestamps = false;

    protected $table = 'artifacts';
    protected $fillable = ['name', 'description', 'image', 'artifact_type_id', 'slot_id','attack', 'damage', 'shield', 'hp' ,'mp', 'energy', 'increase_experience', 'increase_gold', 'rarity_id', 'weight', 'user_level', 'price', 'class_person_id'];

    /**
     * Получить квест связанный с артифактом.
     */
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function artifact_type(){
        return $this->belongsTo(ArtifactType::class);
    }

    public function slot(){
        return $this->belongsTo(Slot::class);
    }

    public function rarity(){
        return $this->belongsTo(Rarity::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_artifact');
    }

    public function features(){
        return $this->morphToMany(Feature::class, 'entity', 'feature_entity');
    }
}