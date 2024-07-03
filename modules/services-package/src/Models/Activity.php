<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Spatie\Activitylog\Models\Activity as ActivityLog;

class Activity extends ActivityLog
{
    use UuidAsId;
    

    /***
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
