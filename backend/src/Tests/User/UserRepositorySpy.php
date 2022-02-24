<?php

namespace App\Tests\User;

use App\Domain\User\User;
use App\Domain\User\UserRepository;
use App\Domain\User\ValueObjects\Cpf;

class UserRepositorySpy implements UserRepository
{
  public ?User $user;

  public function __construct()
  {
  }

  public function add(User $user): void
  {
    $this->user = $user;
  }

  public function edit(User $user): void
  {}

  public function getByCpf(Cpf $cpf): ?User
  {
    return $this->user;
  }
  
  public function removeByCpf(Cpf $cpf): void
  {}
}