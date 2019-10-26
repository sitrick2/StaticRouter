<?php

namespace StaticRouter;

class Validation
{
    /**
     * Removes trailing forward slashes from the right of the route and filters out URL params.
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
     *  Try and match the incoming request's URI with the specified route pattern.
     *
     * @param $route
     * @param $requestUri
     *
     * @return array|bool
     */
    public static function routeMatchesURI($route, $requestUri)
    {
        $routeArr = static::parseRouteKeys($route);
        $uriArr = static::parseUriKeys($requestUri);

        //try and find perfect matches
        $matched = static::matchCheck($routeArr, $uriArr);
        if ($matched !== false){
            return $matched;
        }

        //ok, didn't find perfect matches. Let's explode the dot notation and see if that reveals some matches
        [$routeArr, $uriArr] = static::lookForMatchesInDotNotation($routeArr, $uriArr);

        //return the match if we have one, otherwise we're done here.
        return static::matchCheck($routeArr, $uriArr) ?? false;
    }

    /**
     * Tests whether the request's REST method matches the route's expected REST method.
     *
     * @param $routeMethod
     * @param $requestMethod
     *
     * @return bool
     */
    public static function requestTypeMatchesRESTFunction($routeMethod, $requestMethod): bool
    {
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

    /**
     * Verifies incoming POST or PUT requests are either json or urlencoded
     *
     * @param $content_type
     *
     * @return bool
     */
    public static function hasAcceptableContentType($content_type): bool
    {
        $goodContentTypes = [
            'application/json',
            'application/x-www-form-urlencoded'
        ];
        return in_array(strtolower($content_type), $goodContentTypes, true);
    }

    /**
     * Takes a route string, filters out dynamic parameters ('{id}' type values), returns the keys in dot notation and dynamic parameters as values
     *
     * @param $route
     *
     * @return array
     */
    private static function parseRouteKeys($route) :array
    {
        $resultsArr = static::createRouteArray($route);

        if (count($resultsArr) === 1) {
            return [$resultsArr[0] => ''];
        }

        //loop through the exploded route array and look for ID values
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

    /**
     * Takes a uri string, filters out dynamic parameters, returns the keys in dot notation and dynamic parameters as values
     *
     * @param $uri
     *
     * @return array
     */
    private static function parseUriKeys($uri) :array
    {
        $resultsArr = static::createRouteArray($uri);


        if (count($resultsArr) === 1) {
            return [$resultsArr[0] => ''];
        }

        //loop through the exploded URI array and look for ID values
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

    /**
     * Format URI or Route string as an Array for parsing elsewhere.
     *
     * @param $string
     *
     * @return array
     */
    private static function createRouteArray($string): array
    {
        $string = trim($string, '/');
        $resultsArr = explode('/', $string);

        if (count($resultsArr) === 0){
            return [];
        }

        if (count($resultsArr) % 2 === 1)
        {
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

    /**
     * Takes arrays generated from a route string and uri string respectively and checks for matching. Returns both if match is found, otherwise returns false.
     *
     * @param $routeArr
     * @param $uriArr
     *
     * @return array|bool
     */
    private static function matchCheck($routeArr, $uriArr)
    {
        if(array_keys($routeArr) === array_keys($uriArr)){
            return static::emptiesMatch($routeArr, $uriArr);
        }

        return false;
    }

    /**
     * Explodes a URI string with a dot delimiter in case we mistakenly caught a dynamic value as a key
     *
     * @param $routeArr
     * @param $uriArr
     *
     * @return array
     */
    private static function lookForMatchesInDotNotation($routeArr, $uriArr): array
    {
        if (count($routeArr) === count($uriArr)){
            foreach ($uriArr as $key => $value){
                if (!array_key_exists($key, $routeArr)){
                    $explodedDotNotation = explode('.', $key);
                    if (array_key_exists($explodedDotNotation[0], $routeArr)){
                        if (strpos($routeArr[$explodedDotNotation[0]], '{') !== false){
                            $uriArr[$explodedDotNotation[0]] = $explodedDotNotation[1];
                            unset($uriArr[$key]);
                        }
                    }
                }
            }
        }

        return [$routeArr, $uriArr];
    }
}