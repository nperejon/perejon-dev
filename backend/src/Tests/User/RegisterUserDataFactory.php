<?php

namespace App\Tests\User;

use App\Application\User\RegisterUserData;
use Faker\Factory as FakerFactory;

class RegisterUserDataFactory
{
  public static function make(string $name = null, string $cpf = null, string $email = null, string $password = null): RegisterUserData
  {
    $faker = FakerFactory::create('pt_BR');
    $name = $name ?? $faker->name;
    $cpf = $cpf ?? $faker->cpf;
    $email = $email ?? $faker->email;
    $password = $password ?? $faker->password;
    $data = new RegisterUserData($name, $cpf, $email, $password);
    return $data;
  }
}