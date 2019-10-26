<?php

namespace StaticRouter;

use StaticRouter\RequestMethods\Get;
use StaticRouter\RequestMethods\Post;
use StaticRouter\RequestMethods\Patch;
use StaticRouter\RequestMethods\Delete;

class Router
{
    private $requestHandler;
    private $get;
    private $post;
    private $patch;
    private $delete;

    private $acceptedHttpMethods;

    public function __construct(IRequest $request = null)
    {
        if ($request === null) {
            $request = new Request();
        }

        $this->get = new Get($request);
        $this->post = new Post($request);
        $this->patch = new Patch($request);
        $this->delete = new Delete($request);

        $this->acceptedHttpMethods = [
            'get', 'post', 'patch', 'delete'
        ];

        $this->requestHandler = new RequestHandler();
    }

    public function __call($name, $args)
    {
        [$route, $method] = $args;
        if (in_array($name, $this->acceptedHttpMethods, true)){
            return $this->$name->handle($route, $method);
        }

        $this->requestHandler->handleInvalid();
    }
}