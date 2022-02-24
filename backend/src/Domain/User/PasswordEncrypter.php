<?php

namespace App\Domain\User;

interface PasswordEncrypter
{
  public function encrypt(string $password): string;
  public function verify(string $passwordInClear, string $passwordEncrypted): bool;
}