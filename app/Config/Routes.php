<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ci4-api-core: health route start
$routes->get('health', static function () {
    $checker = new \dcardenasl\Ci4ApiCore\Monitoring\HealthChecker();
    $checks  = $checker->checkAll();
    $status  = $checker->getOverallStatus($checks);

    return response()->setJSON([
        'status'    => $status,
        'checks'    => $checks,
        'timestamp' => date('Y-m-d H:i:s'),
    ])->setStatusCode($status === 'unhealthy' ? 503 : 200);
});
// ci4-api-core: health route end
