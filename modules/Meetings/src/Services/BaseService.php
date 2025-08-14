<?php

namespace Modules\Meetings\Services;

use Rcv\Core\Services\BaseService as CoreBaseService;

 
class BaseService extends CoreBaseService
{
   
    protected $repository;

    
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get all records
     *
     * @param array $columns
     * @return mixed
     */
    public function getAll(array $columns = ['*'])
    {
        return $this->repository->getAll($columns);
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
        return $this->repository->getPaginated($perPage, $columns);
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
        return $this->repository->getById($id, $columns);
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
        return $this->repository->getByField($field, $value, $columns);
    }

    /**
     * Create new record
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update record
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete record
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Get repository instance
     *
     * @return BaseRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
} 