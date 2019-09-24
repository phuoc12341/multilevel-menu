<?php

namespace App\Repo;

use App\Models\Menu;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Attach a model instance to the parent model.
     *
     * @return Illuminate\Support\Collection
     */
    public function attachModelToParent(int $id, Menu $menu);
}
