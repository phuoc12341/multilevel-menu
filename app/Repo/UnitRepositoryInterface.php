<?php

namespace App\Repo;

use App\Models\Unit;

interface UnitRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Find a model instance by name.
     *
     * @return Unit $unit
     */
    public function findByName(string $name);
}
