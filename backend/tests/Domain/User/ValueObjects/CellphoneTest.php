<?php

use App\Domain\User\ValueObjects\Cellphone;

$faker = Faker\Factory::create('pt_BR');

test('should throw exception if cellphone is not 8 or 9 digits', function () use ($faker) {
  new Cellphone($faker->areaCode, $faker->randomNumber(7));
})->throws(InvalidArgumentException::class);

test('should throw exception if ddd is not 2 digits', function () use ($faker) {
  new Cellphone($faker->randomNumber(1), $faker->cellphone);
})->throws(InvalidArgumentException::class);

test('should throw exception if cellphone contains character', function () use ($faker) {
  new Cellphone($faker->areaCode, $faker->cellphone . 'a');
})->throws(InvalidArgumentException::class);

test('should throw if ddd is not numeric', function () use ($faker) {
  new Cellphone('dd', $faker->cellphone);
})->throws(InvalidArgumentException::class);

test('should return ddd if ddd function is called', function () use ($faker) {
  $ddd = $faker->areaCode;
  $cellphone = new Cellphone($ddd, $faker->cellphone);
  expect($cellphone->ddd())->toEqual($ddd);
});

test('should return number if number function is called', function () use ($faker) {
  $number = $faker->cellphone;
  $cellphone = new Cellphone($faker->areaCode, $number);
  expect($cellphone->number())->toEqual($number);
});

test('should return value if cellphone is valid', function () use ($faker) {
  $ddd = $faker->areaCode;
  $number = $faker->cellphone;
  $cellphone = new Cellphone($ddd, $number);
  expect($cellphone)->toEqual("({$ddd}) {$number}");
});