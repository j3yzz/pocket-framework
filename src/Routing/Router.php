<?php

namespace Pocket\Routing;

use Pocket\Application;
use Pocket\Request\Request;
use Pocket\Response;
use Pocket\Routing\Exceptions\NotFoundException;

class Router
{
    protected Request $request;

    protected Response $response;

    protected array $routes = [];

    protected array $params = [];

    protected array $methods = [
        'get',
        'post',
        'put',
        'patch',
        'delete',
    ];

    /**
     * Router constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }


    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? null;

        if (! $callback) {
            $this->response->setStatusCode(404);
            return "Page Not Found";
        }

        switch (gettype($callback)) {
            case "NULL":
                throw new NotFoundException();
                break;
            case 'array':
                return $this->renderController($callback);
                break;
            case 'object':
                return $this->renderClosure($callback);
                break;
            default:
                throw new \Exception('Callback type is invalid');
        }
    }

    protected function renderController(array $callback): bool|string
    {
        try {
            $callback[0] = new $callback[0]();

            return call_user_func($callback, $this->request);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
    protected function renderClosure($callback): bool|string
    {
        try {
            return call_user_func($callback);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}