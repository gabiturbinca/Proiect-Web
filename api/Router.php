<?php

class Router {
    private array $routes = [];
    private Container $container;
    public function __construct(Container $container) {
        $this->container = $container;
    }
    private function addRoute(string $method,
                                string $path,
                                array $handler,
                                array $middleware) : void {
        $pattern = preg_replace('/\{(\w+)\}/', '(\d+)', $path);
        $pattern = "#^$pattern$#";
        $this->routes[] = ['method' => $method,
                            'pattern' => $pattern,
                            'handler' => $handler,
                            'middleware' => $middleware];
    }
    public function get(string $path, array $handler, array $middleware = []) : void {
        $this->addRoute('GET', $path, $handler, $middleware);
    }
    public function post(string $path, array $handler, array $middleware = []) : void {
        $this->addRoute('POST', $path, $handler, $middleware);
    }
    public function put(string $path, array $handler, array $middleware = []) : void {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }
    public function delete(string $path, array $handler, array $middleware = []) : void {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }
    public function patch(string $path, array $handler, array $middleware = []) : void {
        $this->addRoute('PATCH', $path, $handler, $middleware);
    }

    public function dispatch(string $method, string $uri) : mixed {
        $parsed_uri = parse_url($uri, PHP_URL_PATH);
        foreach($this->routes as $route) {
            if($route['method'] === $method) {
                if(preg_match($route['pattern'], $parsed_uri, $matches)) {
                    array_shift($matches);
                    foreach ($route['middleware'] as $midClass) {
                        $this->container->get($midClass)->handle();
                    }
                    [$controllerClass, $myMethod] = $route['handler'];

                    $myController = $this->container->get($controllerClass);
                    return call_user_func_array([ $myController, $myMethod ], $matches);
                }
            }
        }
        throw new NotFoundException("Specified route was not found $method \n $uri");
    }
}