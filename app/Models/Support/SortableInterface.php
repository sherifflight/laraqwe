<?php

namespace App\Models\Support;

/**
 * Interface SortableInterface
 * @package App\Models\Support
 */
interface SortableInterface
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSorted($query);
}
