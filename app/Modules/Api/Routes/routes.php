<?php

/*
 |====================================================================================================
 | API
 |====================================================================================================
 | All Routes  begin with api prefix
 |
 */

// VER 1.0
$app->group('/api/v1', function () {
    $this->get('/banner', ['App\\Api\\Http\\Controllers\\BannerController', 'index']);
    $this->get('/banner/{slug}/show', ['App\\Api\\Http\\Controllers\\BannerController', 'show']);
});

// VER 2.0
$app->group('/api/v2', function () {
    $this->get('/banner', ['App\\Api\\Http\\Controllers\\BannerController', 'index']);
    $this->get('/banner/{slug}/show', ['App\\Api\\Http\\Controllers\\BannerController', 'show']);
});