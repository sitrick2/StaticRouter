<?php

namespace StaticRouter\RequestMethods;

use StaticRouter\Validation;

class Get extends AbstractMethod implements MethodInterface
{

    public function handle($route, $method): bool
    {
        return $this->abstractHandler($route, $method, 'get');
    }
}