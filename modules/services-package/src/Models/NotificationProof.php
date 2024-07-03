<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Satis2020\ServicePackage\Traits\Sortable;

class NotificationProof extends Model  
{
    use UuidAsId, Sortable;

    protected $fillable = [
        "to",
        "institution_id",
        "status",
        "channel",
        "sent_at",
        "message"
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function to()
    {
        return $this->belongsTo(Identite::class,"to");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
