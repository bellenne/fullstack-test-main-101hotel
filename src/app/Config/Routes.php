<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Comments::index');
$routes->get('comments/sort', 'Comments::sort');
$routes->post('comments/create', 'Comments::create');
$routes->post('comments/remove', 'Comments::destroy');
