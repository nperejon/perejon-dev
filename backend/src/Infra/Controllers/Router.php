<?php

namespace App\Infra\Controllers;

interface Router
{
  public function add(string $method, string $path, array $handler, string $routename, array $middlewares): void;
  public function dispatch(): void;
}