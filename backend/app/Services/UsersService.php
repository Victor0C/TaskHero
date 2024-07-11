<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\User;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Services\Interfaces\UsersServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class UsersService implements UsersServiceInterface {
    public function __construct(private UsersRepositoryInterface $usersRepository)
    {

    }
    public function findAll(): Collection{
        $user = $this->usersRepository->findAll();
        return $user;
    }

    public function find(int $id): User
    {
        //try and catch necessary to prevent Eloquent from sending its own exception to whoever is consuming the API
        try{
            $user =  $this->usersRepository->find($id);

            return $user;

        }catch(\Exception){
            throw new NotFoundException("User not found with ID: $id");
        }      
    }

    public function create(User $userDTO): User
    {       
        $user = new User();
        $user->fill($userDTO->toArray());

        return $this->usersRepository->create($user);
    }

    public function update(int $id, User $userDTO): User
    {
       $user= $this->find($id);
       $user->fill($userDTO->toArray());

        return $this->usersRepository->update($id, $user);
    }

    public function delete(int $id): void
    {
        $this->find($id);

        $this->usersRepository->delete($id);
    }
}