<?php

namespace App\Main;

use App\Routes\Routes;

final class App
{
  public static function start()
  {
    Routes::get();
  }
}