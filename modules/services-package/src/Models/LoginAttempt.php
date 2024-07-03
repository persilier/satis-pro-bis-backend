<?php

namespace Satis2020\ServicePackage\Models;


use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Satis2020\ServicePackage\Traits\UuidAsId;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class LoginAttempt extends Model implements CanFilterContract
{
    use UuidAsId, Filterable;

    protected $fillable = ['email',"ip","attempts","last_attempts_at"];

    const UPDATED_AT = null;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
