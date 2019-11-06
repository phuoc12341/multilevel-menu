<?php
namespace App\Repo;

use App\Models\Employee;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * @var Employee
     */
    protected $model;

    /**
     *
     * @param \App\Models\Employee $employee
     */
    public function __construct(Employee $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function select(array $data)
    {
        return $this->model->select($data)->get()->toArray();
    }
}
