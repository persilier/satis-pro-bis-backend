<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Satis2020\ServicePackage\Traits\ActivityTrait;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Satis2020\ServicePackage\Traits\Sortable;

class Channel extends Model 
{

    use HasTranslations, Sluggable, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Sortable;

    protected static $logName = 'channel';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'slug',
        'name',
        'is_editable',
        'is_response',
        'can_be_response'
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
    public $translatable = ['name'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'json',
        'is_editable' => 'integer',
        'is_response' => 'integer',
        'can_be_response' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the claims associated with the channel as a request_channel
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(Claim::class, 'request_channel_slug', 'slug');
    }

    /**
     * Get the claims associated with the channel as a response_channel
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responseClaims()
    {
        return $this->hasMany(Claim::class, 'response_channel_slug', 'slug');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

}
