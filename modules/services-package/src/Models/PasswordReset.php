<?php

namespace Satis2020\ServicePackage\Models;

use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

/**
 * Class PasswordReset
 * @package App
 */
class PasswordReset extends Model implements CanFilterContract
{
    use Filterable;
    
    protected $fillable = [
        'email', 'token'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}
