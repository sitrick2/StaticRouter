<?php

namespace StaticRouter\RequestMethods;

use StaticRouter\Validation;

class Patch extends AbstractMethod implements MethodInterface
{

    public function handle($route, $method)
    {
        return $this->abstractHandler($route, $method, 'patch');
    }
}