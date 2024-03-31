<?php


namespace App\Persistence\Repositories\Implements;


use App\Models\Service;
use App\Persistence\Repositories\Interfaces\ServiceRepository;

class EloquentServiceRepository implements ServiceRepository
{
    /**
     * @var Service
     */
    private $model;

    /**
     * EloquentServiceRepository constructor.
     * @param Service $model
     */
    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function findForFilter()
    {
        return $this->model->query();
    }

    /**
     * @inheritDoc
     */
    public function findById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function save(Service $service)
    {
        $service->save();
        return $service;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id)
    {
        $service = $this->findById($id);
        if (!$service) {
            throw new \Exception("Service not found!", 404);
        }
        $service->delete();
    }
}
