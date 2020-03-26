<?php

$config = config(MdPages::class);

foreach(explode(',', $config->route) as $route)
{
    $routes->add($route, '\Denis303\MdPages\Controllers\MdPages::index');
    $routes->add($route . '/:any', '\Denis303\MdPages\Controllers\MdPages::index');
}