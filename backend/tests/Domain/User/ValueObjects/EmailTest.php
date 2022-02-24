<?php

use App\Domain\User\ValueObjects\Email;

$faker = Faker\Factory::create('pt_BR');

test('should throw exception if email is not valid', function () {
    new Email('invalid');
})->throws(InvalidArgumentException::class);

test('should return value if email is valid', function () use ($faker) {
    $emailValue = $faker->email;
    $email = new Email($emailValue);
    expect($email)->toEqual($emailValue);
});