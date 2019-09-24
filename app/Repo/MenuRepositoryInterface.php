<?php

namespace App\Repo;

use Illuminate\Support\Collection;

use App\Models\Menu;

interface MenuRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Load Parent Relation Of Menu.
     *
     * @return Illuminate\Support\Collection
     */
    public function loadParentRelation(Collection $listMenu);

    /**
     * Load Parent Relation Of Menu.
     *
     * @return Menu
     */
    public function getRootMenu();

    /**
     * Load Parent Relation Of Menu.
     *
     * @return array
     */
    public function findByDepth(string $depth, string $parent_id, string $exceptId);
}
