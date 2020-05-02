<?php


namespace Routing;


class Router
{
    private $routes;

    private function __construct(Array $routes)
    {
        $this->routes = $routes;
    }

    public function create(Array $routes) : ?Router
    {
        if(!empty($routes)){
            return new self($routes);
        }
        return null;
    }

    public function match($uri): ?Object
    {
        $match = new \stdClass();
        foreach ($this->routes as $key => $urlValue) {

            $expresion = $this->generateExpresion($urlValue);
            $pass = preg_match($expresion, $uri);
            if($pass){
                $match->status = true;
                $match->uri = $urlValue;
                $match->id = $key;
                return $match;
            }
        }
        $match->status = false;
        return $match;
    }

    private function generateExpresion($url) : string
    {
        $url = str_replace("/", "\/",$url);
        $url = str_replace("{id}", "+\d*", $url);
        $url = str_replace("{name}", "+[a-z]*", $url);
        $url = "/". $url . "$/";
        return $url;
    }

}