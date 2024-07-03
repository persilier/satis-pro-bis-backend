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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class ReportingTask extends Model implements CanFilterContract
{
    use UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Filterable;

    const BIANNUAL_REPORT = "biannual";


    protected static $logName = 'reporting_task';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['staffs' => 'array', 'deleted_at' => 'datetime',];
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
        'period', 'staffs', 'institution_id', 'institution_targeted_id', 'reporting_type'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institutionTargeted()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function cronTasks()
    {
        return $this->morphMany(CronTask::class, 'model');
    }


    /**
     * @return BelongsToMany
     */
    public function staffs()
    {
        return $this->belongsToMany(Staff::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
