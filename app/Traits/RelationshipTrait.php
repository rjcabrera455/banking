<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;

trait RelationshipTrait
{

    public function loadRelationships($query, $relations = null)
    {
        $relations = $relations ?? $this->relations ?? [];
        foreach ($relations as $relation) {
            $query->when(
                $this->includeRelationships($relation),
                fn ($q) => $query instanceof Model ? $query->load($relation) : $q->with($relation)
            );
        }

        return $query;
    }

    protected function includeRelationships($relation)
    {
        $include = request()->query('include');

        if (!$include) return false;

        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}
