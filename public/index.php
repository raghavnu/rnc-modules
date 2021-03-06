<?php
// Start PHP session
session_start();
/*
 |==================================================================
 | Application root file
 |==================================================================
 |
 * */
define('ROOT',getcwd().'/');

require ROOT . '../vendor/autoload.php';

/*
 |==================================================================
 | Environment File
 |==================================================================
 |
 * */
$dotEnv = new Dotenv\Dotenv('../');
$dotEnv->load();

/*
 |==================================================================
 | Bootstrap file
 |==================================================================
 |
 * */
require ROOT . '../config/Bootstrap.php';

$app = new \Config\Framework();

/*
 |==================================================================
 | Routes
 |==================================================================
 |
 * */
require ROOT . '../config/Routes.php';

$app->run();
