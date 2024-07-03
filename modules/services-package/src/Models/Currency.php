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

class Currency extends Model
{

    use HasTranslations, Sluggable, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Sortable;

    protected static $logName = 'currency';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'slug',
        'name',
        'iso_code'
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
    protected $casts = ['name' => 'json', 'deleted_at' => 'datetime',];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'iso_code'
            ]
        ];
    }

    /**
     * Get the claims associated with the currency
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(Claim::class, 'amount_currency_slug', 'slug');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }
}
