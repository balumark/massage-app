<?php


namespace App\Persistence\Repositories\Interfaces;


use App\Models\ServiceAppointment;

interface ServiceAppointmentRepository
{

    /**
     * @return mixed
     */
    public function findForFilter();

    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findByAttributes(array $filters): ?ServiceAppointment;

    /**
     * @param ServiceAppointment $service
     * @return mixed
     */
    public function save(ServiceAppointment $service);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);
}
