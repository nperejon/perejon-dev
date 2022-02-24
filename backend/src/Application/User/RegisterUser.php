<?php

namespace App\Application\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;

class RegisterUser
{
  private UserRepository $repo;
  
  public function __construct(UserRepository $repo)
  {
    $this->repo = $repo;  
  }

  public function register(RegisterUserData $data): User
  {
    $user = User::create($data->email(), $data->cpf(), $data->email(), $data->password());
    $this->repo->add($user);
    
    return $user;
  }
}