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

class Metadata extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

    const AUTH_PARAMETERS = "auth-parameters";
    const REGULATORY_LIMIT = "regulatory-limit";


    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['data'];

    protected $casts = [
        'data' => 'json',
        'deleted_at' => 'datetime',
    ];
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
        'name', 'data'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Scope a query to only include metadata of a given name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
