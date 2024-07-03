<?php

namespace Satis2020\ServicePackage\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface CanSortContract
{
    public function scopeSort(Builder $query, $defaultSort = null, $direction = 'asc');
}
