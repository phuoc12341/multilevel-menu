<?php

namespace App\Repo;

use App\Models\Post;
use App\Models\Menu;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    /**
     * @var Post
     */
    protected $model;

    /**
     * PostRepository constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
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
