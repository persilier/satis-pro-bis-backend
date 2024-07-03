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

class TypeClient extends Model implements CanFilterContract
{

    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Filterable;

    protected static $logName = 'type_client';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['name', 'description'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['name' => 'json', 'description' => 'json', 'deleted_at' => 'datetime',];

    /**
     * Get the clients associated with the type clients
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(Client::class, 'type_clients_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
    
}
