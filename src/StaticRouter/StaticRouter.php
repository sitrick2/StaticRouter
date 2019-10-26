<?php

namespace StaticRouter;

/**
 * Class StaticRouter
 *
 * @package StaticRouter
 * @method static patch(string $string, string $string1)
 */
class StaticRouter
{
    protected static $router;

    public static function __callStatic($name, $arguments)
    {
        if (session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }

        if (isset($_SESSION['200'])){
            return;
        };

        [$route, $method] = $arguments;
        static::$router = new Router();
        $canRender = static::$router->$name($route, $method);
        if (!$canRender){
            return $_SESSION;
        }

        header('200 Success');
        echo $_SESSION['200'];
        return $_SESSION['200'];
    }
}