<?php


namespace App\Persistence\Repositories\Implements;


use App\Models\User;
use App\Persistence\Repositories\Interfaces\UserRepository;

class EloquentUserRepository implements UserRepository
{
    /**
     * @var User
     */
    private $model;

    /**
     * EloquentUserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
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
    public function save(User $user)
    {
        $user->save();
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id)
    {
        $user = $this->findById($id);
        if(!$user){
            throw new \Exception("User not found!",404);
        }
        $user->delete();
    }
}
