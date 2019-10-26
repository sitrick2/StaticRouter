<?php

namespace StaticRouter\RequestMethods;

use DI\Container;
use InvalidControllerReferenceException;
use StaticRouter\Controllers\PatientsController;
use StaticRouter\IRequest;
use StaticRouter\RequestHandler;
use StaticRouter\Validation;

abstract class AbstractMethod
{
    protected $requestHandler;
    protected $request;
    protected $keys;

    public function __construct(IRequest $request)
    {
        $this->requestHandler = new RequestHandler();
        $this->request = $request;
        $this->keys = [];
    }

    /**
     * @param $method
     *
     * @return mixed
     */
    protected function executeMethod($method)
    {
        if ($method instanceof \Closure){
            return $method($this->request);
        }

        $methodArr = explode('@', $method);
        [$controller, $controllerMethod] = $methodArr;

        $controllerClass = new $controller();

        array_unshift($this->keys, $this->request);

        return call_user_func_array([$controllerClass, $controllerMethod], array_values($this->keys));
    }

    /**
     * @param $method
     * @param $route
     *
     * @return mixed
     */
    protected function handleRequestErrors($route, $method)
    {
        if ($method === null || !$keys = Validation::routeMatchesURI($route, $_SERVER['REQUEST_URI'])){
            return $this->requestHandler->handleDefault();
        }

        $this->keys = $keys;

        if (isset($_SERVER['HTTP_CONTENT_TYPE']) && !Validation::hasAcceptableContentType($_SERVER['HTTP_CONTENT_TYPE'])) {
            return $this->requestHandler->handleBadContentType();
        }

        return true;
    }

    protected function keysAreEmpty():bool
    {

        foreach ($this->keys as $key => $value){
            if ($value === ''){
                return true;
            }
        }

        return false;
    }
}