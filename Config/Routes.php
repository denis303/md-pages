<?php

$config = config(MdPages::class);

if ($config->route)
{
    foreach(explode(',', $config->route) as $route)
    {
        $routes->add($route, '\Denis303\MdPages\Controllers\MdPages::index');
        $routes->add($route . '/:any', '\Denis303\MdPages\Controllers\MdPages::index');
    }
}