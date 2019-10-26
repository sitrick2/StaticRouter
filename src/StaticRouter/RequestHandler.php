<?php

namespace StaticRouter;


use InvalidControllerReferenceException;

class RequestHandler
{

    public function handleDefault(): bool
    {
        $_SESSION['404'] = "{$_SERVER['SERVER_PROTOCOL']} 404 Not Found";
        return false;
    }

    public function handleInvalid(): bool
    {
        $_SESSION['405'] = "{$_SERVER['SERVER_PROTOCOL']} 405 Method Not Allowed";
        return false;
    }

    public function handleBadContentType(): bool
    {
        $_SESSION['400'] = "{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request";
        return false;
    }
}