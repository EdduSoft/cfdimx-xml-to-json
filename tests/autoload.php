<?php

include_once __DIR__ . "../../vendor/autoload.php";

$classLoader = new \Composer\Autoload\ClassLoader();
$classLoader->addPsr4("Lib\\", __DIR__, true);
$classLoader->addPsr4("Lib\\Tests\\", __DIR__, true);
$classLoader->register();