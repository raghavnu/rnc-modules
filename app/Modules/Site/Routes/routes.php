<?php
/*
 |====================================================================================================
 | FRONTEND ROUTES
 |====================================================================================================
 | Frontend routes
 |
 */
$app->group('', function () {
    $this->get('/', ['App\\Site\\Http\\Controllers\\HomeController', 'index'])->setName('home');
});