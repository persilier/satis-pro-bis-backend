<?php


namespace Satis2020\ServicePackage\Models;
use App\Scopes\SortScope;
use Spatie\Activitylog\LogOptions;
use \Spatie\Permission\Models\Role as SpatieRole;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;
use Satis2020\ServicePackage\Traits\Sortable;

/**
 * Class Role
 * @package Satis2020\ServicePackage\Models
 */
class Role extends SpatieRole 
{
    use Sortable;
    public static function getRoles()
    {
        return SpatieRole::where('guard_name', 'api')
            ->get()
            ->map(function ($item, $key) {
                return ['label' => $item['name'], 'value' => $item['name']];
            })
            ->toArray();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable();
    }

    
}