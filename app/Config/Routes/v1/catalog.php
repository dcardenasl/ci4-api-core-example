<?php

/** @var \CodeIgniter\Router\RouteCollection $routes */

$routes->group('catalog', ['namespace' => '\App\Controllers\Api\V1\Catalog'], function ($routes) {

    // Auth & Admin Protected Group
    $routes->group('', ['filter' => []], function ($routes) {
        // Product Routes
        $routes->get('products', 'ProductController::index');
        $routes->get('products/(:num)', 'ProductController::show/$1');
        $routes->post('products', 'ProductController::create');
        $routes->put('products/(:num)', 'ProductController::update/$1');
        $routes->delete('products/(:num)', 'ProductController::delete/$1');


        // Category Routes
        $routes->get('categories', 'CategoryController::index');
        $routes->get('categories/(:num)', 'CategoryController::show/$1');
        $routes->post('categories', 'CategoryController::create');
        $routes->put('categories/(:num)', 'CategoryController::update/$1');
        $routes->delete('categories/(:num)', 'CategoryController::delete/$1');


        // Resource routes will be injected here
    });
});
