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

class UnitType extends Model 
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Sortable;

    protected static $logName = 'unit_type';

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['name', 'description',  'others'];
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
        'name', 'description', 'parent_id', 'others', 'can_be_target', 'can_treat', 'is_editable'
    ];

    /**
     * Get the units associated with the unitType
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    /**
     * Get the unitType'children associated with the unitType
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(UnitType::class, 'parent_id');
    }

    /**
     * Get the unitType'parent associated with the unitType
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(UnitType::class, 'parent_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
