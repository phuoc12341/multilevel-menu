<?php

namespace App\Repo;

use App\Models\Unit;

class UnitRepository extends BaseRepository implements UnitRepositoryInterface
{
    /**
     * @var Unit
     */
    protected $model;

    /**
     * UnitRepository constructor.
     *
     * @param Unit $model
     */
    public function __construct(Unit $model)
    {
        parent::__construct($model);
    }

    public function findByName(string $name)
    {
        return $this->model->where('name', $name)->first();
    }
}
