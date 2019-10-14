<?php

namespace App\Repo;

use App\Models\Menu;

use Illuminate\Support\Collection;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface
{
    /**
     * @var Menu
     */
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    /**
     * Load Parent Relation Of Menu.
     *
     * @return Illuminate\Support\Collection
     */
    public function loadParentRelation(Collection $listMenu)
    {
        return $listMenu->load(['parent' => function ($query) {
            $query->select(['id', 'name']);
            $query->orderBy('lft');
        }])->get('menus.id', 'menus.parent_id', 'menus.name', 'menus.menuable_type', 'menus.menuable_id');  // dong nay em viet nhung ko co tac dung anh a, no van lay het cac truong cua bang menus
    }

    /**
     * Load Parent Relation Of Menu.
     *
     * @return App\Models\Menu
     */
    public function getRootMenu()
    {
        return $this->model->where('parent_id', null)->first();
    }

    /**
     * Load Parent Relation Of Menu.
     *
     * @return array
     */
    public function findByDepth(string $depth, string $parent_id, string $exceptId)
    {
        return $this->model->where('depth', $depth)->where('parent_id', $parent_id)->get()->except([$exceptId])->modelKeys();
    }
}
