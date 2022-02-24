<?php

use App\Main\App;

require __DIR__.'../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'../../');
$dotenv->load();

App::start();