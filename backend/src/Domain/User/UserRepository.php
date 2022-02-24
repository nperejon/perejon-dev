<?php

namespace App\Domain\User;

use App\Domain\User\ValueObjects\Cpf;

interface UserRepository
{
  public function add(User $user): void;
  public function edit(User $user): void;

  public function getByCpf(Cpf $cpf): ?User;
  public function removeByCpf(Cpf $cpf): void;
}