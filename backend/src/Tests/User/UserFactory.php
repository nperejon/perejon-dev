<?php

namespace App\Tests\User;

use App\Domain\User\User;
use Faker\Factory as FakerFactory;

class UserFactory
{
  public static function make(string $name = null, string $cpf = null, string $email = null): User
  {
    $faker = FakerFactory::create('pt_BR');
    $user = User::create(
      $name ?? $faker->name,
      $cpf ?? $faker->cpf,
      $email ?? $faker->email
    );

    return $user;
  }
}