<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Satis2020\ServicePackage\Traits\ActivityTrait;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Satis2020\ServicePackage\Traits\Sortable;

class SeverityLevel extends Model 
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Sortable;

    protected static $logName = 'severity_level';

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
    protected $casts = ['name' => 'json', 'description' => 'json', 'others' => 'json', 'deleted_at' => 'datetime',];

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
        'name', 'description', 'status', 'color', 'others'
    ];

    /**
     * Get the claimObject associated with the claimObject
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claimObjects()
    {
        return $this->hasMany(ClaimObject::class, 'severity_levels_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
