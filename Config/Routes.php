<?php

$config = config(MdPages::class);

$routes->add($config->route, '\Denis303\MdPages\Controllers\MdPages::index');

$routes->add($config->route . '/:any', '\Denis303\MdPages\Controllers\MdPages::index');