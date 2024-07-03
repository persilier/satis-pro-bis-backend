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

class File extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['deleted_at' => 'datetime',];

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
    protected $fillable = ['title', 'url'];

    /**
     * Get the lead flag for the staff.
     *
     * @return bool
     */
    public function getBase64Attribute()
    {
        return base64_encode(file_get_contents(public_path($this->attributes['url'])));
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Get the owning attachmentable model.
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentable()
    {
        return $this->morphTo();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
