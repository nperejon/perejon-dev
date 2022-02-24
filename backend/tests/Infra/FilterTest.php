<?php

use App\Infra\Filter;

test('should return value', function() {
  $filter = Filter::field('field', 'value');
  expect($filter->value())->toBe('value');
});

test('should throw if value is empty', function() {
  expect(function() {
    Filter::field('field', '')->isRequired();
  })->toThrow('InvalidArgumentException', 'The field field is required');
});

test('should throw if value is not a string', function() {
  expect(function() {
    Filter::field('field', 1)->isString();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid string');
});

test('should pass if value is a string', function() {
  $faker = Faker\Factory::create('pt_BR');
  $value = $faker->word;
  $filter = Filter::field('field', $value)->isString();
  expect($filter->value())->toBe($value);
});

test('should throw if value is not a int', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker) {
    Filter::field('field', $faker->word)->isInt();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid int');
});

test('should pass if value is a numeric string', function() {
  $filter = Filter::field('field', '1')->isInt();
  expect($filter->value())->toBe('1');
});

test('should throw if value is not a email', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker) {
    Filter::field('field', $faker->word)->isEmail();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid email');
});

test('should pass if value is a valid email', function() {
  $faker = Faker\Factory::create('pt_BR');
  $email = $faker->email;
  $filter = Filter::field('field', $email)->isEmail();
  expect($filter->value())->toBe($email);
});

test('should throw if value is not a valid password', function() {
  expect(function() {
    Filter::field('field', 'a')->isPassword();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid password');
});

test('should pass if value is a valid password', function() {
  $faker = Faker\Factory::create('pt_BR');
  $password = $faker->password;
  $filter = Filter::field('field', $password)->isPassword();
  expect($filter->value())->toBe($password);
});

test('should throw if value is not a cellphone', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker){
    Filter::field('field', $faker->word)->isCellphone();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid cellphone');
});

test('should throw if value is not a cellphone length', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker){
    Filter::field('field', $faker->randomNumber(7))->isCellphone();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid cellphone');
});

test('should throw if value is not a cellphone numeric', function() {
  expect(function() {
    Filter::field('field', 'abcdefgh')->isCellphone();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid cellphone');
});

test('should pass if value is a valid cellphone', function() {
  $faker = Faker\Factory::create('pt_BR');
  $cellphone = $faker->cellphone;
  $filter = Filter::field('field', $cellphone)->isCellphone();
  $cellphone = str_replace('-', '', $cellphone);
  expect($filter->value())->toBe($cellphone);
});

test('should throw if value is not a ddd', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker){
    Filter::field('field', $faker->randomNumber(5))->isDddd();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid ddd');
});

test('should pass if value is a valid ddd', function() {
  $faker = Faker\Factory::create('pt_BR');
  $ddd = $faker->areaCode;
  $filter = Filter::field('field', $ddd)->isDddd();
  expect($filter->value())->toBe($ddd);
});

test('should throw if value is not a role', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker) {
    Filter::field('field', $faker->word)->isRole();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid role');
});

test('should pass if value is a valid role', function() {
  $filter = Filter::field('field', 'student')->isRole();
  expect($filter->value())->toBe('student');
});

test('should throw if value is not a valid array', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker) {
    Filter::field('field', $faker->word)->isArray();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid array');
});

test('should pass if value is a valid array', function() {
  $filter = Filter::field('field', [])->isArray();
  expect($filter->value())->toBe([]);
});

test('should throw if value is not a valid bool', function() {
  expect(function() {
    Filter::field('field', 'a')->isBool();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid bool');
});

test('should pass if value is a valid bool', function() {
  $filter = Filter::field('field', true)->isBool();
  expect($filter->value())->toBe(true);
});

test('should throw if value is not a valid date', function() {
  $faker = Faker\Factory::create('pt_BR');
  expect(function() use ($faker) {
    Filter::field('field', $faker->word)->isDate();
  })->toThrow('InvalidArgumentException', 'The field field is not a valid date');
});

test('should pass if value is a valid date', function() {
  $faker = Faker\Factory::create('pt_BR');
  $date = $faker->date;
  $filter = Filter::field('field', $date)->isDate();
  expect($filter->value())->toBe($date);
});