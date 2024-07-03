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

class Faq extends Model implements CanFilterContract
{

    use HasTranslations, Sluggable, UuidAsId, SoftDeletes, SecureDelete, LogsActivity, ActivityTrait, Filterable;

    protected static $logName = 'faq';

    /**
     * The attributes that are translatable
     *
     * @var array
     */
    public $translatable = ['slug', 'question', 'answer'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'slug',
        'question',
        'answer',
        'faq_category_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug' => 'json',
        'question' => 'json',
        'answer' => 'json',
        'deleted_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function faqCategory()
    {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id', 'id');
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'question'
            ]
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    

}
