<?php


namespace App\Persistence\Repositories\Interfaces;


use App\Models\Service;

interface ServiceRepository
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
     * @param Service $service
     * @return mixed
     */
    public function save(Service $service);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);
}
