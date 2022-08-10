<?php


namespace Pocket;


use Pocket\Request\Request;
use Pocket\Routing\Router;

class Application
{
    public Router $router;

    public Request $request;

    public Response $response;

    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}