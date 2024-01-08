<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

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
 * @property int|null $slot_id
 * @property int|null $artifact_trade_id
 * @property int|null $critical_damage
 * @property float|null $critical_chance
 * @property int|null $shield
 * @property int|null $damage
 * @property int|null $hp
 * @property int|null $mp
 * @property int|null $class_type_id
 * @property-read \App\Models\ArtifactTrade|null $artifact_trade
 * @property-read \App\Models\ArtifactType|null $artifact_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Feature[] $features
 * @property-read int|null $features_count
 * @property-read int|null $missions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Progress[] $progresses
 * @property-read int|null $progresses_count
 * @property-read \App\Models\Rarity|null $rarity
 * @property-read \App\Models\Slot|null $slot
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subject[] $subjects
 * @property-read int|null $subjects_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereArtifactTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereClassTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereCriticalChance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereCriticalDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereDamage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereMp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereShield($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Artifact whereSlotId($value)
 */
class Artifact extends Model
{

    public $timestamps = false;
    protected $table = 'artifacts';
    protected $fillable = ['name', 'description', 'image', 'artifact_type_id', 'artifact_trade_id', 'slot_id', 'attack', 'damage_min', 'damage_max', 'critical_damage' ,'critical_chance' ,'shield', 'hp' ,'mp', 'energy', 'rarity_id', 'weight', 'user_level', 'price', 'class_type_id', 'progress_id'];

    /**
     * Получить квест связанный с артифактом.
     */
    public function missions(): BelongsToMany
    {
        return $this->belongsToMany(Mission::class, 'mission_artifact');
    }

    /**
     * Получить тип артефакта.
     */
    public function artifact_type(): BelongsTo
    {
        return $this->belongsTo(ArtifactType::class);
    }

    /**
     * Получить cлот артефакта.
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(Slot::class);
    }

    /**
     * Получить редкость артефакта.
     */
    public function rarity(): BelongsTo
    {
        return $this->belongsTo(Rarity::class);
    }

    /**
     * Получить пользователей артефакта.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_artifact')->withPivot('equip');
    }

    /**
     * Получить расширения артефакта.
     */
    public function features(): MorphToMany
    {
        return $this->morphToMany(Feature::class, 'entity', 'feature_entity');
    }

    /**
     * Получить достижения, которые наделяют условием чтобы надеть артефакт.
     */
    public function progresses(): BelongsToMany
    {
        return $this->belongsToMany(Progress::class);
    }
    /**
     * Получить предметы, которые наделяют условием чтобы надеть артефакт.
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class)->withPivot('user_level');
    }

    /**
     * Получить цену за артефакт золото, алмазы.
     */
    public function artifact_trade(): BelongsTo
    {
        return $this->belongsTo(ArtifactTrade::class);
    }
}