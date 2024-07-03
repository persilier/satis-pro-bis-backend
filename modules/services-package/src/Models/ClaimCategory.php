<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Baro\PipelineQueryCollection\Sort;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\AsFilter;
use Satis2020\ServicePackage\Traits\Sortable;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Baro\PipelineQueryCollection\RelationFilter;
use Satis2020\ServicePackage\Models\ClaimObject;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Satis2020\ServicePackage\Traits\ActivityTrait;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class ClaimCategory extends Model
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Sortable;

    protected static $logName = 'claim_category';

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['name', 'description', 'others'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['name' => 'json', 'description' => 'json', 'others' => 'json', 'deleted_at' => 'datetime'];

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
    protected $fillable = [
        'name', 'description', 'others'
    ];

    /**
     * Get the claimObjects associated with the claimCategory
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claimObjects()
    {
        return $this->hasMany(ClaimObject::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
    // protected static function booted(): void
    // {
    //     static::addGlobalScope(new SortScope);
    // }
  
}
