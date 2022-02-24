<?php

use App\Application\User\RegisterUser;
use App\Domain\User\User;
use App\Tests\User\RegisterUserDataFactory;
use App\Tests\User\UserRepositorySpy;

function makeRegisterSut(): array
{
  $repo = new UserRepositorySpy();
  $sut = new RegisterUser($repo);

  return [$sut, $repo];
}

test('should return a user', function () {
  [$sut] = makeRegisterSut();
  $user = $sut->register(RegisterUserDataFactory::make());
  
  expect($user)->toBeInstanceOf(User::class);
});

test('should add in repository', function () {
  [$sut, $repo] = makeRegisterSut();
  $user = $sut->register(RegisterUserDataFactory::make());

  expect($repo->user)->toBe($user);
});