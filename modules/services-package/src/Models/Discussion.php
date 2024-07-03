<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Satis2020\ServicePackage\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class Discussion extends Model implements CanFilterContract
{
    use HasTranslations, UuidAsId, SoftDeletes, SecureDelete, Filterable;

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
    public $translatable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['deleted_at' => 'datetime',];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['name', 'claim_id', 'created_by'];

    /**
     * Get the claim associated with the discussion
     * @return BelongsTo
     */
    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    /**
     * Get the staff who register the discussion
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    /**
     * Get the staff associated with the discussion
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }

    /**
     * Get the messages associated with the discussion
     * @return HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    

}
