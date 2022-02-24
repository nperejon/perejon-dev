<?php

use App\Domain\User\ValueObjects\Password;

$faker = Faker\Factory::create('pt_BR');

test('should throws if password length is less than 6', function () {
    new Password('12345');
})->throws(InvalidArgumentException::class);

test('should return true if password is valid', function () use ($faker) {
    $password = $faker->password;
    $hash = new Password($password);
    expect(Password::validate($password, $hash))->toBe(true);
});