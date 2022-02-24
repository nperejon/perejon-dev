<?php

namespace App\Infra;

final class Filter
{
  private string $field;
  private $value;

  private function __construct(string $field, $value)
  {
    $this->field = $field;
    if (is_string($value)) $this->value = htmlspecialchars(trim($value));
    $this->value = $value;
  }

  public static function field(string $field, $value): Filter
  {
    return new Filter($field, $value);
  }

  public function isRequired(): Filter
  {
    if (empty($this->value)) {
      throw new \InvalidArgumentException("The field {$this->field} is required");
    }

    return $this;
  }

  public function isEmail(): Filter
  {
    if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid email");
    }

    return $this;
  }

  public function isPassword(): Filter
  {
    if (strlen($this->value) < 6) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid password");
    }

    return $this;
  }

  public function isDddd(): Filter
  {
    if (strlen($this->value) != 2) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid ddd");
    }

    return $this;
  }

  public function isCellphone(): Filter
  {
    $this->value = str_replace('-', '', $this->value);

    if (strlen($this->value) != 8 && strlen($this->value) != 9) {
      return throw new \InvalidArgumentException("The field {$this->field} is not a valid cellphone");
    }

    if (!is_numeric($this->value)) {
      return throw new \InvalidArgumentException("The field {$this->field} is not a valid cellphone");
    }

    return $this;
  }

  public function isRole(): Filter
  {
    if (!in_array($this->value, ['student', 'teacher', 'admin'])) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid role");
    }

    return $this;
  }

  public function isInt(): Filter
  {
    if (!filter_var($this->value, FILTER_VALIDATE_INT)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid integer");
    }

    return $this;
  }

  public function isDate(): Filter
  {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->value)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid date");
    }

    return $this;
  }

  public function isString(): Filter
  {
    if (!is_string($this->value)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid string");
    }

    return $this;
  }

  public function isArray(): Filter
  {
    if (!is_array($this->value)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid array");
    }

    return $this;
  }

  public function isBool(): Filter
  {
    if (!is_bool($this->value)) {
      throw new \InvalidArgumentException("The field {$this->field} is not a valid boolean");
    }

    return $this;
  }

  public function value()
  {
    return $this->value;
  }
}