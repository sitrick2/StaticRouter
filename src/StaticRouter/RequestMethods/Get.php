<?php

namespace StaticRouter\RequestMethods;

use StaticRouter\Validation;

class Get extends AbstractMethod
{

    public function handle($route, $method): bool
    {
        if (!Validation::requestTypeMatchesRESTFunction('get', $_SERVER['REQUEST_METHOD'])){
            return $this->requestHandler->handleInvalid();
        }

        if (!$this->handleRequestErrors($route, $method)){
            return false;
        }

        $_SESSION['200'] = $this->executeMethod($method);
        return $_SESSION['200'];
    }
}