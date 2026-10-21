<?php

declare(strict_types=1);

use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');

// === Halaman publik ===
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('jasa-top-up-paypal', 'Home::topup', ['as' => 'service.topup']);
$routes->get('jasa-pembayaran-paypal', 'Home::payService', ['as' => 'service.pay']);
$routes->get('blog', 'Home::blog', ['as' => 'blog']);
$routes->get('contact', 'Home::contact', ['as' => 'contact']);
$routes->get('page/(:any)', 'Home::page/$1', ['as' => 'page']);
$routes->get('api/simulate', 'Api::simulate', ['as' => 'api.simulate']);
$routes->post('api/simulate', 'Api::simulate');

// === Autentikasi ===
$routes->get('login', 'Auth::loginView', ['as' => 'auth.login']);
$routes->post('login', 'Auth::login', ['as' => 'auth.login.post']);
$routes->get('register', 'Auth::registerView', ['as' => 'auth.register']);
$routes->post('register', 'Auth::register', ['as' => 'auth.register.post']);
$routes->get('logout', 'Auth::logout', ['as' => 'auth.logout']);

// === Dashboard (butuh login) ===
$routes->group('dashboard', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Dashboard::index', ['as' => 'dashboard.index']);
    $routes->get('top-up', 'Dashboard::topupForm', ['as' => 'dashboard.topup']);
    $routes->post('top-up', 'Dashboard::storeTopup', ['as' => 'dashboard.topup.store']);
    $routes->get('jasa-bayar', 'Dashboard::payForm', ['as' => 'dashboard.pay']);
    $routes->post('jasa-bayar', 'Dashboard::storePay', ['as' => 'dashboard.pay.store']);
    $routes->get('order/(:num)', 'Dashboard::show/$1', ['as' => 'dashboard.show']);
    $routes->get('invoice/(:num)', 'Dashboard::invoice/$1', ['as' => 'dashboard.invoice']);
    $routes->get('profil', 'Dashboard::profile', ['as' => 'dashboard.profile']);
    $routes->post('profil', 'Dashboard::saveProfile', ['as' => 'dashboard.profile.save']);
});

// === Streaming bukti pengiriman (pemilik order / admin) ===
$routes->get('proof/(:num)', 'Admin::proof/$1', ['as' => 'proof.view']);

// === Panel admin ===
$routes->group('admin', ['filter' => 'admin'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Admin::orders', ['as' => 'admin.orders']);
    $routes->post('order/(:num)/proof', 'Admin::uploadProof/$1', ['as' => 'admin.proof']);
    $routes->post('order/(:num)/status', 'Admin::updateStatus/$1', ['as' => 'admin.status']);
    $routes->get('pelanggan', 'Admin::users', ['as' => 'admin.users']);
});

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

