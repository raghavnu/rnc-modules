<?php

/*
 |====================================================================================================
 | BACKEND ROUTES ADMIN
 |====================================================================================================
 | All Routes  begin with admin prefix
 |
 */
$app->group('/admin', function () {

    //DASHBOARD
    $this->get('/dashboard', ['App\\Main\\Http\\Controllers\\DashboardController', 'index'])->setName('dashboard');

    //BANNER
    $this->get('/banner', ['App\\Main\\Http\\Controllers\\BannerController', 'index'])->setName('banner.list');
    $this->get('/banner/{slug}/show', ['App\\Main\\Http\\Controllers\\BannerController', 'show'])->setName('banner.show');

});