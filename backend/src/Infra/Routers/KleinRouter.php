<?php

namespace App\Infra\Routers;

use App\Infra\Controllers\Router;
use Klein\Klein;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Psr7\Request as GuzzleRequest;
use Klein\Request as KleinRequest;
use Klein\Response as KleinResponse;

class KleinRouter implements Router
{
  private $router;

  public function __construct()
  {
    $this->router = new Klein();
  }

  private function adaptRequest(KleinRequest $kleinRequest, array $attributes): RequestInterface
  {
    $guzzleRequest = new GuzzleRequest(
      $kleinRequest->method(),
      $kleinRequest->uri(),
      $kleinRequest->headers()->all(),
      json_encode($attributes)
    );
    return $guzzleRequest;
  }

  private function adaptResponse(ResponseInterface $response): KleinResponse
  {
    $headers = $response->getHeaders();
    $kleinResponse = new KleinResponse();
    $kleinResponse->code($response->getStatusCode());
    $kleinResponse->body($response->getBody());
    foreach ($headers as $header => $value) {
      $kleinResponse->header($header, $value[0]);
    }
    return $kleinResponse;
  }

  public function add(string $method, string $path, array $handler, string $routename, array $middlewares): void
  {
    $this->router->respond($method, $path, function (KleinRequest $request, KleinResponse $response) use ($handler, $middlewares) {
        $postParams = $request->paramsPost()->all();
        $routeParams = $request->params();
        $queryParams = $request->paramsGet()->all();
        $bodyParams = (array) json_decode($request->body());
        $attributes = array_merge($postParams, $routeParams, $queryParams, $bodyParams);
        
        foreach ($middlewares as $middleware) {
          $attributes = call_user_func_array($middleware, [$attributes]);
        }

        $guzzleRequest = $this->adaptRequest($request, $attributes);
        $guzzleResponse = call_user_func_array($handler, [$guzzleRequest]); // $handler[0] = class, $handler[1] = method
        $response = $this->adaptResponse($guzzleResponse);
        return $response;
    });
  }

  public function dispatch(): void
  {
    $this->router->dispatch();
  }
}