<?php

use App\Domain\User\ValueObjects\Cpf;

$faker = Faker\Factory::create('pt_BR');

test('should throw exception if cpf is a sequence of digits', function () {
  new Cpf('12345678901');
})->throws(InvalidArgumentException::class);

test('should throw exception if cpf is a sequence of same digit', function () {
  new Cpf('11111111111');
})->throws(InvalidArgumentException::class);

test('should throw exception if cpf contains character', function () use ($faker) {
  new Cpf($faker->randomNumber(10) . 'a');
})->throws(InvalidArgumentException::class);

test('should throw exception if cpf is not 11 digits', function () use ($faker) {
  new Cpf($faker->randomNumber(9));
})->throws(InvalidArgumentException::class);

test('should throw exception if cpf is not valid', function () use ($faker) {
  new Cpf($faker->randomNumber(11) . '1');
})->throws(InvalidArgumentException::class);

test('should return value if cpf is valid', function () use ($faker) {
  $cpfValue = $faker->cpf;
  $cpf = new Cpf($cpfValue);
  expect($cpf)->toEqual($cpfValue);
});