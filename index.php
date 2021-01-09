<?php

define('ROOT', str_replace('\\', '/', dirname(__DIR__)));

use RBCalendar\Autoloader;
use RBCalendar\Core\Main;

require_once 'Autoloader.php';
Autoloader::register();
$app = new Main();
$app->start();