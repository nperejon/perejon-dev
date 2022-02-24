<?php

namespace App\Routes;


use App\Infra\Controllers\HomeController;
use App\Infra\Routers\AuraRouter as Router;

class Routes
{
  public static function get()
  {
    $router = new Router();
    $router->add('GET', '/a/{user_id}', [HomeController::class, 'index'], 'home', $middlewares = []);

    $router->dispatch();
  }
}