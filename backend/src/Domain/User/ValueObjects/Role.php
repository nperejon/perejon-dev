<?php

namespace App\Domain\User\ValueObjects;

use Stringable;

final class Role implements Stringable
{
  private string $role;
  private array $possibleRoles = ['admin', 'student', 'teacher'];

  public function __construct(string $role)
  {
    if (!in_array($role, $this->possibleRoles)) {
      throw new \InvalidArgumentException('Invalid role');
    }

    $this->role = $role;
  }

  public function __toString(): string
  {
    return $this->role;
  }

  public function isAdmin(): bool
  {
    return $this->role === 'admin';
  }

  public function isStudent(): bool
  {
    return $this->role === 'student';
  }

  public function isTeacher(): bool
  {
    return $this->role === 'teacher';
  }
}