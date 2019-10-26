<?php

namespace StaticRouter\RequestMethods;

use StaticRouter\Validation;

class Patch extends AbstractMethod
{

    public function handle($route, $method)
    {
        if (!Validation::requestTypeMatchesRESTFunction('patch', $_SERVER['REQUEST_METHOD'])){
            return $this->requestHandler->handleInvalid();
        }

        if (!$this->handleRequestErrors($route, $method)){
            return false;
        }

        if ($this->keysAreEmpty()){
            return $this->requestHandler->handleBadContentType();
        }

        $_SESSION['200'] = $this->executeMethod($method);
        return $_SESSION['200'];
    }
}