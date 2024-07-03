<?php


namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Satis2020\ServicePackage\Traits\Sortable;

class Client extends Model 
{
    use UuidAsId, SoftDeletes, SecureDelete, Sortable;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['others' => 'array', 'deleted_at' => 'datetime',];

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
        'identites_id', 'others'
    ];


    public function identite()
    {
        return $this->belongsTo(Identite::class, 'identites_id');
    }

    /**
     * Get the client_institution associated with the client
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client_institution()
    {
        return $this->hasOne(ClientInstitution::class, 'client_id');
    }

    /**
     * Get the client_institution associated with the client
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function client_institutions()
    {
        return $this->hasMany(ClientInstitution::class, 'client_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
