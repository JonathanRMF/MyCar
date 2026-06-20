<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── PÚBLICAS ────────────────────────────────────────────────
$routes->get('/', 'Home::index');

$routes->get('/login',    'AuthController::login');
$routes->post('/login',   'AuthController::loginProcess');
$routes->get('/register', 'AuthController::register');
$routes->post('/register','AuthController::registerProcess');
$routes->get('/logout',   'AuthController::logout');

$routes->get('/vehiculos', 'VehiculoController::index');
$routes->get('/vehiculos/categoria/(:segment)', 'VehiculoController::porCategoria/$1');
$routes->get('/vehiculos/detalle/(:num)',        'VehiculoController::detalle/$1');

// ─── CLIENTE (logueado) ───────────────────────────────────────
$routes->get('/reservas/nueva/(:num)',  'AlquilerController::nuevaReserva/$1',  ['filter' => 'auth']);
$routes->post('/reservas/guardar',     'AlquilerController::guardarReserva',    ['filter' => 'auth']);
$routes->get('/reservas/confirmacion', 'AlquilerController::confirmacion',      ['filter' => 'auth']);

// ─── ADMIN ───────────────────────────────────────────────────
$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {

    // Vehículos
    $routes->get('vehiculos',              'VehiculoController::adminIndex');
    $routes->get('vehiculos/crear',        'VehiculoController::crear');
    $routes->post('vehiculos/crear',       'VehiculoController::crearPost');
    $routes->get('vehiculos/editar/(:num)',  'VehiculoController::editar/$1');
    $routes->post('vehiculos/editar/(:num)', 'VehiculoController::editarPost/$1');
    $routes->get('vehiculos/baja/(:num)',   'VehiculoController::bajaLogica/$1');

    // Clientes
    $routes->get('clientes',               'ClienteController::adminIndex');
    $routes->get('clientes/crear',         'ClienteController::crear');
    $routes->post('clientes/crear',        'ClienteController::crearPost');
    $routes->get('clientes/editar/(:num)',  'ClienteController::editar/$1');
    $routes->post('clientes/editar/(:num)', 'ClienteController::editarPost/$1');
    $routes->get('clientes/baja/(:num)',   'ClienteController::bajaLogica/$1');

    // Alquileres
    $routes->get('alquileres',                    'AlquilerController::adminIndex');
    $routes->get('alquileres/confirmar/(:num)',    'AlquilerController::confirmarAlquiler/$1');
    $routes->get('alquileres/devolucion/(:num)',   'AlquilerController::registrarDevolucion/$1');

    // Reportes
    $routes->get('reportes',                      'ReporteController::index');
    $routes->get('reportes/vehiculo/(:num)',       'ReporteController::porVehiculo/$1');
    $routes->get('reportes/cliente/(:num)',        'ReporteController::porCliente/$1');
    $routes->get('reportes/activos',              'ReporteController::activos');
});