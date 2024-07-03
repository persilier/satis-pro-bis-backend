<?php

namespace Satis2020\ServicePackage\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait Sortable
{
    
    public function scopeSortable($query, $defaultSort = null, $direction = 'asc')
    {

        if ($this->sortingIsActive()) {
            return $this->buildQuery(
                $query,
                collect(request()->only(['sort', 'direction']))
            );
        }

        if (!is_null($defaultSort)) {
            return $query->orderBy($defaultSort, $direction);
        }
     
        return $query;
    }

    private function buildQuery($query, $sortParams)
    {
        $column = $sortParams->get('sort');
        $direction = $sortParams->get('direction');

        if ($this->columnIsRelated($column)) {
            $relatedModel = $this->getRelatedModel($column);
            $parameters = collect([
                'column' => $this->getRelatedSortColumn($column),
                'direction' => $direction
            ]);
            
            $relation = $query->getRelation($relatedModel);
            return $query->join(
                $this->relatedTable($relation),
                $this->parentPrimaryKey($relation),
                '=',
                $this->relatedPrimaryKey($relation)
            )
                ->select(
                    $this->parentTable($relation) . '.*',
                    $this->getRelatedSelectAttribute($relation, $column)
                )
                ->orderBy(
                    $parameters->get('column'),
                    $parameters->get('direction')
                );
        }

        return $query->orderBy($column, $direction);
    }

    private function getRelatedSelectAttribute($relation, $column)
    {
        return implode('.', [
            $this->relatedTable($relation),
            $this->getSortColumn($column)
        ]) . ' as ' . $this->getRelatedSortColumn($column);
    }

    private function parentTable($relation)
    {
        return $relation->getParent()->getTable();
    }

    private function relatedTable($relation)
    {
        return $relation->getRelated()->getTable();
    }

    private function relatedPrimaryKey($relation)
    {
        if ($relation instanceof HasOne) {
            return $relation->getQualifiedForeignKeyName();
        }

        return $relation->getQualifiedOwnerKeyName();
    }

    private function parentPrimaryKey($relation)
    {
       
        if ($relation instanceof HasOne) {
            return $relation->getQualifiedParentKeyName();
        }
        
        return $relation->getQualifiedForeignKeyName();
    }

    private function sortingIsActive()
    {
        return request()->has('sort') && request()->has('direction');
    }

    private function getSortColumn($column)
    {
        return $this->parseRelation($column)->last();
    }

    private function getRelatedSortColumn($column)
    {
        return implode('_', [
            $this->parseRelation($column)->first(),
            $this->parseRelation($column)->last()
        ]);
    }

    private function getRelatedModel($column)
    {
        return $this->parseRelation($column)
            ->first();
    }

    private function parseRelation($column)
    {
        return collect(
            explode('.', $column)
        );
    }

    private function columnIsRelated($column)
    {
        return strpos($column, '.');
    }
}
