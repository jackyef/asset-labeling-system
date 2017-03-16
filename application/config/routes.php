<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
 * ROUTE EXAMPLE
 * using wildcard like :num and :any
 * $route['product/:num']='catalog/product_lookup'; :num will match any number
 * using regex
 * $route['products/([a-z]+)/(\d+)']='$1/id_$2';
 * In the above example, a URI similar to products/shoes/123
 * would instead call the “shoes” controller class and the “id_123” method.
 */

$route['master/item-type'] = 'master/item_type';
$route['master/item-type/new'] = 'master/item_type_insert_form';
$route['master/item-type/new/submit'] = 'master/item_type_insert';
$route['master/item-type/edit/:num'] = 'master/item_type_update_form/:num';
$route['master/item-type/edit/submit/:num'] = 'master/item_type_update/:num';


$route['master/brand'] = 'master/brand';
$route['master/brand/new'] = 'master/Brand_insert_form';
$route['master/brand/new/submit'] = 'master/brand_insert';
$route['master/brand/edit/:num'] = 'master/brand_update_form/:num';
$route['master/brand/edit/submit/:num'] = 'master/brand_update/:num';


$route['master/model'] = 'master/model';
$route['master/model/new'] = 'master/model_insert_form';
$route['master/model/new/submit'] = 'master/model_insert';
$route['master/model/edit/:num'] = 'master/model_update_form/:num';
$route['master/model/edit/submit/:num'] = 'master/model_update/:num';

$route['master/supplier'] = 'master/supplier';
$route['master/supplier/new'] = 'master/supplier_insert_form';
$route['master/supplier/new/submit'] = 'master/supplier_insert';
$route['master/supplier/edit/:num'] = 'master/supplier_update_form/:num';
$route['master/supplier/edit/submit/:num'] = 'master/supplier_update/:num';


$route['master/company'] = 'master/company';
$route['master/company/new'] = 'master/company_insert_form';
$route['master/company/new/submit'] = 'master/company_insert';
$route['master/company/edit/:num'] = 'master/company_update_form/:num';
$route['master/company/edit/submit/:num'] = 'master/company_update/:num';


$route['master/location'] = 'master/location';
$route['master/location/new'] = 'master/location_insert_form';
$route['master/location/new/submit'] = 'master/location_insert';
$route['master/location/edit/:num'] = 'master/location_update_form/:num';
$route['master/location/edit/submit/:num'] = 'master/location_update/:num';

$route['master/fsub-location'] = 'master/first_sub_location';
$route['master/fsub-location/new'] = 'master/first_sub_location_insert_form';
$route['master/fsub-location/new/submit'] = 'master/first_sub_location_insert';
$route['master/fsub-location/edit/:num'] = 'master/first_sub_location_update_form/:num';
$route['master/fsub-location/edit/submit/:num'] = 'master/first_sub_location_update/:num';

$route['master/ssub-location'] = 'master/second_sub_location';
$route['master/ssub-location/new'] = 'master/second_sub_location_insert_form';
$route['master/ssub-location/new/submit'] = 'master/second_sub_location_insert';
$route['master/ssub-location/edit/:num'] = 'master/second_sub_location_update_form/:num';
$route['master/ssub-location/edit/submit/:num'] = 'master/second_sub_location_update/:num';

$route['master/mutation-status'] = 'master/mutation_status';
$route['master/mutation-status/new'] = 'master/mutation_status_insert_form';
$route['master/mutation-status/new/submit'] = 'master/mutation_status_insert';
$route['master/mutation-status/edit/:num'] = 'master/mutation_status_update_form/:num';
$route['master/mutation-status/edit/submit/:num'] = 'master/mutation_status_update/:num';

$route['master/employee'] = 'master/employee';
$route['master/employee/new'] = 'master/employee_insert_form';
$route['master/employee/new/submit'] = 'master/employee_insert';
$route['master/employee/edit/:num'] = 'master/employee_update_form/:num';
$route['master/employee/edit/submit/:num'] = 'master/employee_update/:num';

$route['master/user'] = 'master/user';
$route['master/user/new'] = 'master/user_insert_form';
$route['master/user/new/submit'] = 'master/user_insert';
$route['master/user/edit/:num'] = 'master/user_update_form/:num';
$route['master/user/edit/submit/:num'] = 'master/user_update/:num';

$route['master/os'] = 'master/operating_system';
$route['master/os/new'] = 'master/operating_system_insert_form';
$route['master/os/new/submit'] = 'master/operating_system_insert';
$route['master/os/edit/:num'] = 'master/operating_system_update_form/:num';
$route['master/os/edit/submit/:num'] = 'master/operating_system_update/:num';

$route['home/login'] = 'home/login';
$route['logout'] = 'home/logout';
$route['home/help'] = 'home/help';
$route['home/login/auth'] = 'home/login_auth';
$route['home/chpass/:num'] = 'home/chpass/:num';
$route['help'] = 'home/help';
$route['about'] = 'home/about';

$route['item'] = 'item/index';
$route['item/new'] = 'item/item_insert_form';
$route['item/new/submit'] = 'item/item_insert';
$route['item/edit/:num'] = 'item/item_update_form/:num';
$route['item/edit/submit/:num'] = 'item/item_update/:num';
$route['item/mutate/:num'] = 'item/item_mutate_form/:num';
$route['item/mutate/submit/:num'] = 'item/item_mutate/:num';


$route['company'] = 'company/index';
$route['company/edit/:num'] = 'company/company_update_form/:num';
$route['company/edit/submit/:num'] = 'company/company_update/:num';
$route['company/detail/:num'] = 'company/detail/:num';

$route['employee'] = 'employee/index';
$route['employee/edit/:num'] = 'employee/employee_update_form/:num';
$route['employee/edit/submit/:num'] = 'employee/employee_update/:num';
