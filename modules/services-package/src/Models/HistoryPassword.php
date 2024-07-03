<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

/**
 * Class HistoryPassword
 * @package Satis2020\ServicePackage\Models
 */
class HistoryPassword extends Model implements CanFilterContract
{
    use UuidAsId, Filterable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'password'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
