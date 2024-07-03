<?php


namespace Satis2020\ServicePackage\Traits;

use Baro\PipelineQueryCollection\Sort;


trait AsFilter
{
    protected static function bootAsFilter()
    {
        static::retrieved(function ($model) {
            $model->toQuerry()->filter([
                new Sort()
            ]);
        });
    }
}
    