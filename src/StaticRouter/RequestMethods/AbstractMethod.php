<?php

namespace StaticRouter\RequestMethods;

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

    protected function abstractHandler($route, $method, $restMethod)
    {
        if (!Validation::requestTypeMatchesRESTFunction($restMethod, $_SERVER['REQUEST_METHOD'])){
            return $this->requestHandler->handleInvalid();
        }

        if (!$this->handleRequestErrors($route, $method)){
            return false;
        }

        if (in_array($restMethod, ['patch', 'delete']) && $this->keysAreEmpty()) {
            return $this->requestHandler->handleBadContentType();
        }


        $_SESSION['200'] = $this->executeMethod($method);
        return $_SESSION['200'];
    }

    /**
     * Execute the controller method specified by the route declaration.
     *
     * @param $method
     *
     * @return mixed
     */
    protected function executeMethod($method)
    {
        $methodArr = explode('@', $method);
        [$controller, $controllerMethod] = $methodArr;

        $controllerClass = new $controller();

        array_unshift($this->keys, $this->request);

        return call_user_func_array([$controllerClass, $controllerMethod], array_values($this->keys));
    }

    /**
     * Handle validation of the route declaration and catch errors to be dealt with by the requestHandler.
     *
     * @param $method
     * @param $route
     *
     * @return mixed
     */
    protected function handleRequestErrors($route, $method)
    {
        if ($method instanceof \Closure){
            return $this->requestHandler->handleDefault();
        }

        $keys = Validation::routeMatchesURI($route, $_SERVER['REQUEST_URI']);
        if ($method === null || $keys === false){
            return $this->requestHandler->handleDefault();
        }

        $this->keys = $keys;

        if (isset($_SERVER['HTTP_CONTENT_TYPE']) && !Validation::hasAcceptableContentType($_SERVER['HTTP_CONTENT_TYPE'])) {
            return $this->requestHandler->handleBadContentType();
        }

        return true;
    }

    /**
     * Check to see if dynamic values are present in the route string.
     *
     * @return bool
     */
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