<?php

namespace StaticRouter\RequestMethods;

use StaticRouter\Validation;

class Post extends AbstractMethod
{

    public function handle($route, $method): bool
    {
        if (!Validation::requestTypeMatchesRESTFunction('post', $_SERVER['REQUEST_METHOD'])){
            return $this->requestHandler->handleInvalid();
        }

        if (!$this->handleRequestErrors($route, $method)){
            return false;
        }

        $_SESSION['200'] = $this->executeMethod($method);
        return $_SESSION['200'];
    }
}