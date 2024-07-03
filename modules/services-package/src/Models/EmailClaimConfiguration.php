<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class EmailClaimConfiguration extends Model implements CanFilterContract
{

    use UuidAsId, SoftDeletes, SecureDelete, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'email', 'host', 'port', 'protocol', 'password', 'institution_id', 'subscriber_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['deleted_at' => 'datetime',];

    /**
     * Get the claims associated with the currency
     * @return BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
    
}
