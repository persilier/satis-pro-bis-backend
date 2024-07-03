<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class Requirement extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['description'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['description' => 'json', 'deleted_at' => 'datetime',];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Get the claimObjects associated with the requirement
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function claimObjects()
    {
        return $this->belongsToMany(ClaimObject::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
