<?php

namespace App\Infra\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class HomeController
{
  public static function index(RequestInterface $request): ResponseInterface
  {
    return new Response(200, ['Content-Type' => 'application/json', 'X-Foo' => 'Bar'], $request->getBody()->getContents());
  }
}