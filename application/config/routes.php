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
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["forbidden"] = "forbidden/index";

$route["register"] = "welcome/view_register_page";
$route["login"] = "welcome/index";

$route["dashboard"] = "dashboard/index";

//User Management
$route["user"] = "user/view_user_management";
$route["get_user"] = "user/get_user";
$route["validate_user_add"] = "user/validate_user_add";
$route["get_user_detail"] = "user/get_user_detail";
$route["user_detail"] = "user/view_user_detail";
$route["validate_user_edit"] = "user/validate_user_edit";
$route["delete_user"] = "user/process_user_delete";
$route["generate_absen"] = "user/process_generate_register_code";

// Master data
$route["master_data"] = "master_data/index";
$route["get_kelas"] = "master_data/get_kelas_listed";
$route["add_kelas"] = "master_data/validate_kelas_add";
$route["get_kelas_detail"] = "master_data/get_kelas_detail";
$route["edit_kelas"] = "master_data/validate_kelas_edit";
$route["delete_kelas"] = "master_data/process_kelas_delete";

$route["add_angkatan"] = "master_data/validate_angkatan_add";
$route["get_angkatan"] = "master_data/get_angkatan_detail";
$route["edit_angkatan"] = "master_data/validate_angkatan_edit";
$route["delete_angkatan"] = "master_data/process_angkatan_delete";

$route["add_cabang"] = "master_data/validate_cabang_add";
$route["get_cabang"] = "master_data/get_cabang_detail";
$route["edit_cabang"] = "master_data/validate_cabang_edit";
$route["delete_cabang"] = "master_data/process_cabang_delete";

// Absensi
$route["absen"] = "Absen/view_absensi_management";
$route["get_absen"] = "Absen/get_absen_listed";
$route["generate_absen_code"] = "Absen/generate_absen_code";
$route["create_absen"] = "Absen/process_absen_create";
$route["get_absen_detail"] = "Absen/get_absen_detail";
$route["update_absen"] = "Absen/validate_absen_edit";

// Data Kas
$route["data_kas"] = "Kas/view_kas_management";
$route["get_kas"] = "Kas/get_kas_listed";
$route["search_user"] = "Kas/process_search_user";
$route["search_user_edit"] = "Kas/process_search_user_edit";
$route["add_kas"] = "Kas/validate_kass_add";
$route["get_kas_detail"] = "Kas/get_kas_detail";
$route["edit_kas"] = "Kas/validate_kas_edit";
$route["delete_kas"] = "Kas/process_kas_delete";

// Setting
$route["change_week"] = "Setting/process_week_change";
$route["switch_absen"] = "Setting/process_switch_absen";
$route["switch_register"] = "Setting/process_switch_register";