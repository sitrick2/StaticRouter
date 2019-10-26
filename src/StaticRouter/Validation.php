<?php

namespace StaticRouter;

use phpDocumentor\Reflection\Types\Mixed_;

class Validation
{
    /**
     * Removes trailing forward slashes from the right of the route.
     *
     * @param $route (string)
     *
     * @return string
     */
    public static function formatRoute($route): string
    {
        if (strpos($route, '?') !== false){
            $route = explode('?', $route)[0];
        }

        $result = rtrim($route, '/');
        if ($result === '')
        {
            return '/';
        }
        return $result;
    }

    /**
     * @param $route
     * @param $requestUri
     *
     * @return array|bool
     */
    public static function routeMatchesURI($route, $requestUri)
    {
        $routeArr = static::parseRouteKeys($route);
        $uriArr = static::parseUriKeys($requestUri);

        if (array_keys($routeArr) === array_keys($uriArr)){
            return static::emptiesMatch($routeArr, $uriArr);
        }

        return false;
    }

    public static function requestTypeMatchesRESTFunction($routeMethod, $requestMethod): bool
    {
//        var_dump([$routeMethod, $requestMethod]); exit;
        return strtolower($routeMethod) === strtolower($requestMethod);
    }

    public static function toCamelCase($string)
    {
        $result = strtolower(trim($string));

        preg_match_all('/[_,\s][a-z]/', $result, $matches);
        foreach($matches[0] as $match)
        {
            $c = str_replace(['_', ' '], ['', ''], strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    public static function hasAcceptableContentType($content_type): bool
    {
        $goodContentTypes = [
            'application/json',
            'application/x-www-form-urlencoded'
        ];
        return in_array(strtolower($content_type), $goodContentTypes, true);
    }

    private static function parseRouteKeys($route) :array
    {
        $resultsArr = static::createRouteArray($route);

        if (count($resultsArr) === 1) {
            return [$resultsArr[0] => ''];
        }

        //loop through the exploded route array and look for ID values -- future functionality would look for UUIDs as well
        //pair them with their keys (keys built with dot notation)
        $keyString = '';
        $response = [];

        foreach ($resultsArr as $index => $value) {
            if (strpos($value, '{') !== false){
                $response[$keyString] = $value;
                $keyString = '';
            } else if ($keyString === ''){
                $keyString = $value;
            } else {
                $keyString .= $value === '' ? '' : '.' . $value;
            }
        }

        //catching the stragglers
        if ($keyString !== ''){
            $response[$keyString] = '';
        }
        return $response === ['' => ''] ? [] : $response;
    }

    private static function parseUriKeys($uri) :array
    {
        $resultsArr = static::createRouteArray($uri);


        if (count($resultsArr) === 1) {
            return [$resultsArr[0] => ''];
        }

        //loop through the exploded URI array and look for ID values -- future functionality would look for UUIDs as well
        //pair them with their keys (keys built with dot notation)
        $keyString = '';
        $response = [];

        foreach ($resultsArr as $index => $value) {
            if (is_numeric($value) && $index !== 0){
                $response[$keyString] = $value;
                $keyString = '';
            } else if ($keyString === ''){
                $keyString = $value;
            } else {
                $keyString .= $value === '' ? '' : '.' . $value;
            }
        }

        //catching the stragglers
        if ($keyString !== ''){
            $response[$keyString] = '';
        }

        return $response === ['' => ''] ? [] : $response;
    }

    private static function createRouteArray($string): array
    {
        $string = trim($string, '/');
        $resultsArr = explode('/', $string);

        if (count($resultsArr) === 0){
            return [];
        }

        if (count($resultsArr) % 2 === 1)
        {
            //we're getting ready to parse the URI into a set of keys
            // and ID values (ie 'patients/1/metrics/2' into
            // ['patients' => 1, 'metrics' => 2]
            // If there's a key but not an ID, add a blank value
            // so we still track the key
            $resultsArr[] = '';
        }

        return $resultsArr;
    }

    /**
     * @param array $routeArr
     * @param array $uriArr
     *
     * @return array|bool
     */
    private static function emptiesMatch(array $routeArr, array $uriArr)
    {
        $keys = array_keys($routeArr);

        foreach ($keys as $key){
            if ($routeArr[$key] === '' && $uriArr[$key] !== ''){
                return false;
            }
        }

        return $uriArr;
    }
}