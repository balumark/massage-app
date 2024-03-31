<?php


namespace App\Persistence\Repositories\Implements;

use App\Models\ServiceAppointment;
use App\Persistence\Repositories\Interfaces\ServiceAppointmentRepository;

class EloquentServiceAppointmentRepository implements ServiceAppointmentRepository
{
    /**
     * @var ServiceAppointment
     */
    private $model;

    /**
     * EloquentServiceRepository constructor.
     * @param Service $model
     */
    public function __construct(ServiceAppointment $model)
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
    public function findByAttributes(array $filters): ?ServiceAppointment
    {
        return ServiceAppointment::where($filters)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function save(ServiceAppointment $service)
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
