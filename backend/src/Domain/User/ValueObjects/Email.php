<?php

namespace App\Domain\User\ValueObjects;

use Stringable;

final class Email implements Stringable
{
  private string $address;

  public function __construct(string $address)
  {
    if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
      throw new \InvalidArgumentException('Invalid email address');
    }
    $this->address = $address;
  }

  public function __toString(): string
  {
    return $this->address;
  }
}