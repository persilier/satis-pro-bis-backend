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

class InstitutionType extends Model
{

    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait;

    protected static $logName = 'institution_type';

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
    protected $fillable = [
        'name', 'description', 'application_type', 'maximum_number_of_institutions'
    ];

    /**
     * Get the institutions associated with the institution_type
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
