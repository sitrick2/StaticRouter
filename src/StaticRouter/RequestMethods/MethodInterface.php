<?php

namespace StaticRouter\RequestMethods;

interface MethodInterface
{
    public function handle($route, $method);
}