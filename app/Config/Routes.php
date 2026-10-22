<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('customers', 'CustomerController::index');
$routes->get('customers/new', 'CustomerController::newForm');
$routes->post('customers/create', 'CustomerController::create');
$routes->get('customers/edit/(:num)', 'CustomerController::edit/$1');
$routes->post('customers/update/(:num)', 'CustomerController::update/$1');
$routes->get('users', 'UserController::index');
$routes->get('users/new', 'UserController::newForm');
$routes->post('users/create', 'UserController::create');
$routes->get('users/edit/(:num)', 'UserController::edit/$1');
$routes->post('users/update/(:num)', 'UserController::update/$1');
