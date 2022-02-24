<?php

namespace App\Infra\Routers;

use App\Infra\Controllers\Router;
use Aura\Router\RouterContainer;
use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Laminas\Diactoros\ServerRequest as LaminasRequest;
use Laminas\Diactoros\Response as LaminasResponse;

class AuraRouter implements Router
{
  private $map;
  private $router;

  public function __construct($basepath = null)
  {
    $this->router = new RouterContainer($basepath);
    $this->map = $this->router->getMap();
  }

  private function adaptRequest(LaminasRequest $laminaRequest, array $attributes): RequestInterface
  {
    $guzzleRequest = new GuzzleRequest(
      $laminaRequest->getMethod(),
      $laminaRequest->getUri()->getPath(),
      $laminaRequest->getHeaders(),
      json_encode($attributes),
      $laminaRequest->getProtocolVersion()
    );
    return $guzzleRequest;
  }

  private function adaptResponse(ResponseInterface $response): LaminasResponse
  {
    return new LaminasResponse($response->getBody(), $response->getStatusCode(), $response->getHeaders());
  }

  public function add(string $method, string $path, array $handler, string $routename, array $middlewares): void
  {
    $this->map->route($routename, $path, function (LaminasRequest $laminaRequest) use ($handler, $middlewares) {
      $postParams = $laminaRequest->getParsedBody();
      $routeParams = $laminaRequest->getAttributes();
      $queryParams = $laminaRequest->getQueryParams();
      $bodyParams = (array) json_decode($laminaRequest->getBody()->getContents());
      $attributes = array_merge($postParams, $routeParams, $queryParams, $bodyParams);

      foreach ($middlewares as $middleware) {
        $attributes = call_user_func_array($middleware, [$attributes]);
      }

      $guzzleRequest = $this->adaptRequest($laminaRequest, $attributes);
      $guzzleResponse = call_user_func_array($handler, [$guzzleRequest]); // $handler[0] = class, $handler[1] = method
      $laminaResponse = $this->adaptResponse($guzzleResponse);
        
      return $laminaResponse;
    })->allows($method);
  }

  public function dispatch(): void
  {
    $request = ServerRequestFactory::fromGlobals();
    $matcher = $this->router->getMatcher();

    $route = $matcher->match($request);
    if (! $route) {
        echo "No route found for the request.";
        exit;
    }
    
    foreach ($route->attributes as $key => $val) {
        $request = $request->withAttribute($key, $val);
    }
    
    $callable = $route->handler;
    $response = $callable($request);
    foreach ($response->getHeaders() as $name => $values) {
        foreach ($values as $value) {
            header(sprintf('%s: %s', $name, $value), false);
        }
    }
    http_response_code($response->getStatusCode());
    echo $response->getBody();
  }
}