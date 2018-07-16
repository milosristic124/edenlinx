<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainHomeController@index');

Auth::routes();
Route::get('/home', 'HomeController@index');
Route::get('admin-area/logout', 'HomeController@adminlogout');
Route::get('admin/logout', 'HomeController@superadminlogout');
Route::get('business/logout', 'HomeController@businesslogout');
Route::get('customer/logout', 'HomeController@customerlogout');
Route::get('admin-area', 'HomeController@index');
Route::get('admin-area', function(){
    return view('auth/login');
});
Route::get('admin-area/login', function(){
    return view('auth/login');
});
Route::get('admin-area/register', function(){
    return view('auth/register');
});
Route::get('privacy', function(){
    return view('privacy', array('title' => 'Privacy Policy'));
});
Route::get('terms', function(){
    return view('terms', array('title' => 'Terms and Conditions'));
});
Route::get('contact', 'MainHomeController@contact');
Route::get('categorylist', 'MainHomeController@categorylist');
Route::get('getaboutus', 'MainHomeController@getaboutus');

Route::get('/password/sendemail', 'MainHomeController@password_sendemail');

Route::prefix('admin')->group(function (){
    Route::get('/', 'AdminController@index');
    Route::get('/dashboard', 'AdminController@dashboard');

    Route::get('/adminusers', 'AdminController@adminusers');
    Route::get('/adminusers/table_getall', 'AdminController@adminusers_table_getall');
    Route::get('/adminusersadd', 'AdminController@adminusersadd');
    Route::post('/adminusersadd/save', 'AdminController@adminusersadd_save');

    Route::get('/salesstaff', 'AdminController@salesstaff');
    Route::get('/salesstaff/table_getall', 'AdminController@salesstaff_table_getall');
    Route::get('/salesstaff/edit', 'AdminController@salesstaff_edit');
    Route::get('/salesstaff/table_getallbusiness', 'AdminController@salesstaff_table_getallbusiness');
    Route::get('/salesstaff/checkregister', 'AdminController@salesstaff_checkregister');
    Route::post('/salesstaff/save', 'AdminController@salesstaff_editsave');
    Route::get('/salesstaff/del', 'AdminController@salesstaff_del');

    Route::get('/categories', 'AdminController@categories');
    Route::get('/categories/table_getall', 'AdminController@categories_table_getall');
    Route::get('/categories/edit', 'AdminController@categories_edit');
    Route::get('/categories/checkregister', 'AdminController@categories_checkregister');
    Route::post('/categories/save', 'AdminController@categories_save');
    Route::get('/categories/del', 'AdminController@categories_del');

    Route::get('/packageprice', 'AdminController@packageprice');
    Route::post('/packageprice/save', 'AdminController@packageprice_save');

    Route::get('/setting', 'AdminController@setting');
    Route::post('/setting/save_homepageimage', 'AdminController@setting_save_homepageimage');
    Route::post('/setting/save_contactpageimage', 'AdminController@setting_save_contactpageimage');

    Route::get('/customers', 'AdminController@customers');
    Route::get('/customers/table_getall', 'AdminController@customers_table_getall');
    Route::get('/customers/setactive', 'AdminController@customers_setactive');
    Route::get('/customers/profile', 'AdminController@customers_profile');
    Route::post('/customers/saveprofile', 'AdminController@customers_saveprofile');

    Route::get('/business', 'AdminController@business');
    Route::get('/business/table_getall', 'AdminController@business_table_getall');
    Route::get('/business/setactive', 'AdminController@business_setactive');
    Route::get('/business/profile', 'AdminController@business_profile');
    Route::post('/business/saveprofile', 'AdminController@business_saveprofile');
    Route::get('/business/business', 'AdminController@business_business');
    Route::post('/business/savebusiness', 'AdminController@business_savebusiness');

    Route::get('/review', 'AdminController@review');
    Route::get('/review/table_getall', 'AdminController@review_table_getall');
    Route::get('/review/delreview', 'AdminController@review_delreview');
    Route::get('/review/getreview', 'AdminController@review_getreview');
    Route::post('/review/savereview', 'AdminController@review_savereview');

    Route::get('/contact', 'AdminController@contact');
    Route::get('/contact/table_getall', 'AdminController@contact_table_getall');

    Route::get('/professionalheader', 'AdminController@professionalheader');
    Route::get('/professionalheader/table_getall', 'AdminController@professionalheader_table_getall');

    Route::get('/profile', 'AdminController@profile');
    Route::post('/saveprofile', 'AdminController@saveprofile');
    Route::post('/resetprofile', 'AdminController@resetprofile');
    
});

Route::prefix('business')->group(function (){
    Route::get('/', 'BusinessController@index');
    Route::get('/dashboard', 'BusinessController@dashboard');
    Route::get('/business', 'BusinessController@business');
    Route::get('/professionalheader', 'BusinessController@professionalheader');
    Route::post('/saveprofessionalheader', 'BusinessController@saveprofessionalheader');
    Route::get('/packages', 'BusinessController@package');
    Route::get('/packages/{name}', 'BusinessController@setpackage');
    Route::get('/projects/{status}', 'BusinessController@projects');
    Route::get('/projectedit/{id}', 'BusinessController@projectedit');
    Route::get('/projectdel/{id}', 'BusinessController@projectdel');
    Route::get('/projectpending/{id}', 'BusinessController@projectpending');
    Route::get('/cancelpackages', 'BusinessController@package');
    Route::get('/advertising', 'BusinessController@advertising');
    Route::get('/weeklyemail', 'BusinessController@weeklyemail');
    Route::post('/savebusiness', 'BusinessController@savebusiness');
    Route::get('/info/{id}', 'MainHomeController@getBusiness');
    Route::get('/profile', 'BusinessController@profile');
    Route::post('/saveprofile', 'BusinessController@saveprofile');
    Route::post('/resetprofile', 'BusinessController@resetprofile');
    Route::post('/saveproject', 'BusinessController@saveproject');
    Route::post('/makeconversation', 'MainHomeController@makeconversation');
    Route::get('/message', 'BusinessController@message');
    Route::get('/message/{conv_id}', 'BusinessController@messagedetail');
    Route::post('/sendmessage', 'BusinessController@sendmessage');
    Route::get('/checkcouponcode', 'BusinessController@checkcouponcode');
});

Route::prefix('customer')->group(function (){
    Route::get('/', 'CustomerController@index');
    Route::get('/dashboard', 'CustomerController@dashboard');
    Route::get('/projects/{status}', 'CustomerController@projects');
    Route::get('/projectaccept/{status}', 'CustomerController@projectaccept');
    Route::post('/projectcomplete', 'CustomerController@projectcomplete');
    Route::get('/cancelpackages', 'CustomerController@package');
    Route::get('/profile', 'CustomerController@profile');
    Route::post('/saveprofile', 'CustomerController@saveprofile');
    Route::post('/resetprofile', 'CustomerController@resetprofile');
    Route::get('/message', 'CustomerController@message');
    Route::get('/message/{conv_id}', 'CustomerController@messagedetail');
    Route::post('/sendmessage', 'CustomerController@sendmessage');
    Route::get('/postcontact', 'MainHomeController@postcontact');
});

Route::prefix('category')->group(function (){
    Route::get('/', 'MainHomeController@displayCategory');
    Route::get('search', 'MainHomeController@searchCategroy');
});

Route::prefix('check')->group(function (){
    Route::get('/login', 'MainHomeController@check_login');
    Route::get('/register', 'MainHomeController@check_register');
});

Route::prefix('navinfo')->group(function (){
    Route::get('/customer', 'MainHomeController@getnavinfo_customer');
    Route::get('/business', 'MainHomeController@getnavinfo_business');
});