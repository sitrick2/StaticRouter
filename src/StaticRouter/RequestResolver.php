<?php

namespace StaticRouter;

class RequestResolver
{
    public static function wrapUp()
    {
        if (!isset($_SESSION['200'])) {

            if (isset($_SESSION['400'])) {
                header($_SESSION['400']);
                echo $_SESSION['400'];
                try {
                    exit;
                } catch (Exception $e) {
                    exit;
                }

            }

            if (isset($_SESSION['404'])) {
                header($_SESSION['404']);
                echo $_SESSION['404'];
                try {
                    exit;
                } catch (Exception $e) {
                    exit;
                }
            }

            if (isset($_SESSION['405'])) {
                echo $_SESSION['405'];
                header($_SESSION['405']);
                try {
                    exit;
                } catch (Exception $e) {
                    exit;
                }

            }
        } else {
            exit;
        }
    }
}