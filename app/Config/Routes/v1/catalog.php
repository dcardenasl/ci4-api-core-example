<?php

/** @var \CodeIgniter\Router\RouteCollection $routes */

$routes->group('catalog', ['namespace' => '\App\Controllers\Api\V1\Catalog'], function ($routes) {

    // Auth & Admin Protected Group
    $routes->group('', ['filter' => []], function ($routes) {
        // Category Routes
        $routes->get('categories', 'CategoryController::index');
        $routes->get('categories/(:num)', 'CategoryController::show/$1');
        $routes->post('categories', 'CategoryController::create');
        $routes->put('categories/(:num)', 'CategoryController::update/$1');
        $routes->delete('categories/(:num)', 'CategoryController::delete/$1');


        // Resource routes will be injected here
    });
});
