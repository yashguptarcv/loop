<?php

namespace Modules\EmailNotification\Repositories;

use Rcv\Core\Repositories\BaseRepository as CoreBaseRepository;

class BaseRepositoryRepository extends CoreBaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BaseRepositoryRepository::class;
    }

    /**
     * Get all records
     *
     * @param array $columns
     * @return mixed
     */
    public function getAll(array $columns = ['*'])
    {
        return $this->model->all($columns);
    }

    /**
     * Get paginated records
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function getPaginated(int $perPage = 15, array $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Find record by ID
     *
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function getById(int $id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find record by field
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return mixed
     */
    public function getByField(string $field, $value, array $columns = ['*'])
    {
        return $this->model->where($field, $value)->first($columns);
    }
} 