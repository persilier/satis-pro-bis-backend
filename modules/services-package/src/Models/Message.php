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

class Message extends Model implements CanFilterContract
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
    public $fillable = ['text', 'posted_by', 'discussion_id', 'parent_id'];

    /**
     * Get the staff who send the message
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function postedBy()
    {
        return $this->belongsTo(Staff::class, 'posted_by');
    }

    /**
     * Get the discussion to which the message belongs to
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get the parent associated with the message
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get all of the message's files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'attachmentable');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
