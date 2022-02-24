<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

final class Cellphone
{
  private string $ddd;
  private string $number;

  public function __construct(string $ddd, string $number)
  {
    if (!$this->validateDdd($ddd)) {
      throw new InvalidArgumentException('DDD is invalid');
    }

    if (!$this->validateNumber($number)) {
      throw new InvalidArgumentException('Number is invalid');
    }

    $this->ddd = $ddd;
    $this->number = $number;
  }

  private function validateDdd(string $ddd): bool
  {
    if (strlen($ddd) !== 2) {
      return false;
    }

    if (!is_numeric($ddd)) {
      return false;
    }

    return true;
  }

  private function validateNumber(string $number): bool
  {
    $number = str_replace('-', '', $number);

    if (strlen($number) != 8 && strlen($number) != 9) {
      return false;
    }

    if (!is_numeric($number)) {
      return false;
    }

    return true;
  }
  
  public function __toString(): string
  {
    return "({$this->ddd}) {$this->number}";
  }

  public function ddd(): string
  {
    return $this->ddd;
  }

  public function number(): string
  {
    return $this->number;
  }
}