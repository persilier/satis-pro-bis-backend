<?php

namespace Satis2020\ServicePackage\Traits;

use App\Scopes\SortScope;
use Baro\PipelineQueryCollection\Sort;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait AsSort
{
    protected static function bootAsSort()
    {
        static::addGlobalScope(new SortScope);
    }
}
