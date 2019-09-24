<?php

namespace App\Repo;

use App\Models\Page;
use App\Models\Menu;

class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    /**
     * @var Page
     */
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    /**
     * Attach a model instance to the parent model.
     *
     * @return Illuminate\Support\Collection
     */
    public function attachModelToParent(int $id, Menu $menu)
    {
        return $this->model->where('id', $id)->first()->menu()->save($menu);
    }
}
