<?php

namespace App\Application\User;

use App\Infra\Filter;

class RegisterUserData
{
  private string $name;
  private string $cpf;
  private string $email;
  private string $password;

  public function __construct(string $name, string $cpf, string $email, string $password)
  {
    $this->name = Filter::field('name', $name)->isRequired()->isString()->value();
    $this->cpf = Filter::field('cpf', $cpf)->isRequired()->isString()->value();
    $this->email = Filter::field('email', $email)->isRequired()->isEmail()->value();
    $this->password = Filter::field('password', $password)->isRequired()->isPassword()->value();
  }

  public function name(): string
  {
    return $this->name;
  }

  public function cpf(): string
  {
    return $this->cpf;
  }

  public function email(): string
  {
    return $this->email;
  }

  public function password(): string
  {
    return $this->password;
  }
}