<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;
use Stringable;

final class Password implements Stringable
{
  private string $password;

  public function __construct(string $password)
  {
    if (strlen($password) < 6) {
      throw new InvalidArgumentException('Password must be at least 6 characters');
    }
    $this->password = password_hash($password, PASSWORD_ARGON2ID);
  }

  public static function validate(string $password, string $hash): bool
  {
    return password_verify($password, $hash);
  }

  public function __toString()
  {
    return $this->password;
  }
}