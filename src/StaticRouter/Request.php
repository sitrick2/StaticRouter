<?php

namespace StaticRouter;

/**
 * @property  string requestMethod
 * @property  string requestUri
 */
class Request implements IRequest
{
    public function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf(): void
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{Validation::toCamelCase($key)} = $value;
        }
    }


    public function getBody(): array
    {

        if(in_array($this->requestMethod, ['GET', 'DELETE']))
        {
            return [];
        }

        $body = [];
        if ($this->requestMethod === 'POST'){
            if (empty($_POST)){
                $body = json_decode(file_get_contents('php://input'), true);
            } else {
                $input = $_POST;
                foreach ($input as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        } else { // handling puts and patches
            $input = file_get_contents('php://input');
            if (!$body = json_decode($input, true)){
                parse_str($input, $body);
            }
        }

        return $body;
    }
}