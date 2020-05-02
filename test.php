<?php
function variable_extractor($uri, $regexUri) {
    $params = [];
    preg_match_all('\'' . '{(\w+)}' . '\'', $regexUri, $matches);

    $matches = $matches[0];

    foreach ($matches as $key => $value)
    {
        $matches[$key] = str_replace('{', '', $matches[$key]);
        $matches[$key] = str_replace('}', '', $matches[$key]);
    }

    $regexUri = preg_replace('%' . '{(\w+)}' . '%', '(\w+|\d+)', $regexUri);

    $regexUri .= '$';
    $regexUri = '%^' . $regexUri . '%';
    $res = preg_match($regexUri, $uri, $params);

    if (!$res || $res == 0 )
    {
        return array();
    }

    $paramLength = count($matches);
    $keyParams = array();
    for ($i=0; $i < $paramLength; $i++)
    {
        $keyParams[$matches[$i]] = $params[$i+1];
    }

    return $keyParams;
}

$result = variable_extractor("/a_re_name/a_res_name/", "/{category}/{product}/");
var_dump($result);