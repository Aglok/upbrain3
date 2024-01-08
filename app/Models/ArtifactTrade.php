<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArtifactTrade
 *
 * @property int $id
 * @property int|null $artifact_id
 * @property int|null $gold
 * @property int|null $red_crystal
 * @property int|null $blue_crystal
 * @property int|null $green_crystal
 * @property int|null $yellow_crystal
 * @method static Builder|ArtifactTrade newModelQuery()
 * @method static Builder|ArtifactTrade newQuery()
 * @method static Builder|ArtifactTrade query()
 * @method static Builder|ArtifactTrade whereArtifactId($value)
 * @method static Builder|ArtifactTrade whereBlueCrystal($value)
 * @method static Builder|ArtifactTrade whereGold($value)
 * @method static Builder|ArtifactTrade whereGreenCrystal($value)
 * @method static Builder|ArtifactTrade whereId($value)
 * @method static Builder|ArtifactTrade whereRedCrystal($value)
 * @method static Builder|ArtifactTrade whereYellowCrystal($value)
 * @mixin \Eloquent
 */
class ArtifactTrade extends Model
{
    public $timestamps = false;

    protected $table = 'artifacts_trade';
    protected $fillable = ['artifact_id', 'gold', 'crystal_red', 'crystal_blue', 'crystal_green', 'crystal_yellow'];
}
