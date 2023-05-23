<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');
$routes->get('/', 'AuthC::login');
$routes->get('/form', 'FormC::form');
$routes->post('/form/add', 'FormC::formAdd');
$routes->add('/form/fix', 'FormC::formFix');
$routes->get('/first', 'FormC::first');
$routes->post('/first/add', 'FormC::firstAdd');
$routes->get('/isi_form', 'FormC::isi');
// $routes->get('/dashboard', 'Dashboard::index');
// $routes->add('/dashboard/add', 'Dashboard::add_data');
// $routes->add('/dashboard/edit', 'Dashboard::edit_data');

// $routes->get('/dashboard', 'Home::index');

// $routes->get('/pengajuan', 'Pengajuan::index');

$routes->add('/login', 'AuthC::login');
// $routes->add('/logout', 'Auth::logout');
// $routes->add('/isilah', 'Auth::regisAsal');

// $routes->post('/add','Dashboard::add_data');x`

$routes->get('/add','InjectData::regisAsal');
$routes->get('/tampil','InjectData::tampil');
$routes->get('/cookie','InjectData::cookie');
$routes->get('/coba','InjectData::cobaAjax');

$routes->get('/form1','InjectData::form1');
$routes->get('/form2','InjectData::form2');
$routes->get('/form3','InjectData::form3');

$routes->get('/tabel-tkl','AdminC::index');
$routes->get('/tabel-tkl/(:num)','AdminC::coba/$1');

$routes->get('/header','InjectData::header');
$routes->get('/headeri','InjectData::isiCoba');
$routes->get('/struktur-table','InjectData::Struktur');
$routes->add('/Struktur-Table/add','InjectData::addStruktur');
$routes->get('/Struktur-Table/delete','InjectData::deleteStruktur');
$routes->add('/Struktur-Table/edit','InjectData::editStruktur');
// $routes->add('/cobas','InjectData::cobaS');
$routes->post('/Dashboard/add','InjectData::addForm');

$routes->get('/DashboardV3','InjectData::dashV3');
$routes->get('/lov/add','InjectData::addLov');
$routes->add('/coba/add','InjectData::cobaAdd');
$routes->add('/coba/edit','InjectData::cobaEdit');
$routes->add('/coba/fix','InjectData::cobaFix');
$routes->add('/coba/delete','InjectData::cobaDelete');
$routes->add('/dd','InjectData::deleteCell');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
