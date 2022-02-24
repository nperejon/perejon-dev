<?php

use App\Domain\User\User;
use App\Domain\User\ValueObjects\Password;

function makeUserSut(
  string $name = null,
  string $cpf = null,
  string $email = null
): User
{
  $faker = Faker\Factory::create('pt_BR');
  $user = User::create(
    $name ?? $faker->name,
    $cpf ?? $faker->cpf,
    $email ?? $faker->email
  );

  return $user;
}

test('should return a user', function () {
  $user = makeUserSut();
  expect($user)->toBeInstanceOf(User::class);
});

test('should return name of user on method name', function () {
  $faker = Faker\Factory::create('pt_BR');
  $name = $faker->name;
  $user = makeUserSut($name);
  expect($name)->toBe($user->name());
});

test('should return cpf of user on method cpf', function () {
  $faker = Faker\Factory::create('pt_BR');
  $cpf = $faker->cpf;
  $user = makeUserSut(null, $cpf);
  expect($cpf)->toBe($user->cpf());
});

test('should return email of user on method email', function () {
  $faker = Faker\Factory::create('pt_BR');
  $email = $faker->email;
  $user = makeUserSut(null, null, $email);
  expect($email)->toBe($user->email());
});

test('should return cellphone of user on method cellphone', function () {
  $faker = Faker\Factory::create('pt_BR');
  $ddd = $faker->areaCode;
  $number = $faker->cellphone;
  $cellphone = "({$ddd}) {$number}";
  $user = makeUserSut();
  $user->setcellphone($ddd, $number);
  expect(in_array($cellphone, $user->cellphones()))->toBe(true);
});

test('should return hash password of user on method password', function () {
  $faker = Faker\Factory::create('pt_BR');
  $password = $faker->password;
  $user = makeUserSut();
  $user->setpassword($password);
  expect(Password::validate($password, $user->password()))->toBe(true);
});

test('should set a role to user if function setrole is called', function () {
  $role = 'admin';
  $user = makeUserSut();
  $user->setrole($role);
  expect($user->role())->toBe($role);
});