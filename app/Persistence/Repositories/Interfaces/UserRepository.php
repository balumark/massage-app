<?php


namespace App\Persistence\Repositories\Interfaces;


use App\Models\User;

interface UserRepository
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findById(int $id);

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteById(int $id);
}
