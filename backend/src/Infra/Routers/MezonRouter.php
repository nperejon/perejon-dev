<?php

namespace App\Infra\Routers;

use App\Infra\Controllers\Router;
use Laminas\Diactoros\ServerRequestFactory;
use \Mezon\Router\Router as MRouter;
use Laminas\Diactoros\ServerRequest as LaminasRequest;
use Laminas\Diactoros\Response as LaminasResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use \GuzzleHttp\Psr7\Request as GuzzleRequest;

class MezonRouter implements Router
{
  private $router;

  public function __construct()
  {
    $this->router = new MRouter();
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
    $this->router->addRoute($path, function(string $route, array $parameters) use ($handler, $middlewares) {
      $laminaRequest = ServerRequestFactory::fromGlobals();
      
      $postParams = $laminaRequest->getParsedBody();
      $routeParams = $laminaRequest->getAttributes();
      $queryParams = $laminaRequest->getQueryParams();
      $bodyParams = (array) json_decode($laminaRequest->getBody()->getContents());
      $attributes = array_merge($postParams, $routeParams, $queryParams, $bodyParams, $parameters);

      foreach ($middlewares as $middleware) {
        $attributes = call_user_func_array($middleware, [$attributes]);
      }
      
      $guzzleRequest = $this->adaptRequest($laminaRequest, $attributes);
      
      $guzzleResponse = call_user_func_array($handler, [$guzzleRequest]); // $handler[0] = class, $handler[1] = method
      $laminaResponse = $this->adaptResponse($guzzleResponse);
      
      foreach ($laminaResponse->getHeaders() as $name => $values) {
        foreach ($values as $value) {
          header(sprintf('%s: %s', $name, $value), false);
        }
      }
      http_response_code($laminaResponse->getStatusCode());
      echo $laminaResponse->getBody();
    }, $method, $routename);
  }

  public function dispatch(): void
  {
    $request = ServerRequestFactory::fromGlobals();
    $uri = $request->getUri()->getPath();
    $this->router->callRoute($uri);
  }
}