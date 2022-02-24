<?php

namespace App\Domain\User;

use App\Domain\User\ValueObjects\Cellphone;
use App\Domain\User\ValueObjects\Cpf;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Password;
use App\Domain\User\ValueObjects\Role;

final class User
{
  private string $name;
  private Email $email;
  private array $cellphones;
  private Cpf $cpf;
  private Role $role;
  private Password $password;

  private function __construct(string $name, Cpf $cpf, Email $email)
  {
    $this->name = $name;
    $this->cpf = $cpf;
    $this->email = $email;
    $this->cellphones = [];
    $this->role = new Role('student');
  }

  public static function create(string $name, string $cpf, string $email): User
  {
    return new User($name, new Cpf($cpf), new Email($email));
  }

  public function setcellphone(string $ddd, string $number): User
  {
    $cellphone = new Cellphone($ddd, $number);
    $this->cellphones[] = $cellphone;

    return $this;
  }

  public function setrole(string $role): User
  {
    $this->role = new Role($role);

    return $this;
  }

  public function setpassword(string $password): User
  {
    $this->password = new Password($password);

    return $this;
  }

  public function name(): string
  {
    return $this->name;
  }

  public function email(): string
  {
    return $this->email;
  }

  public function cpf(): string
  {
    return $this->cpf;
  }

  public function cellphones(): array
  {
    return array_map(function (Cellphone $cellphone) {
      return (string) $cellphone;
    }, $this->cellphones);
  }

  public function role(): string
  {
    return $this->role;
  }

  public function password(): string
  {
    return $this->password;
  }
}