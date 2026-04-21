<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public & Verification Routes
$routes->get('/', 'Home::index');
$routes->get('verify-id/(:segment)', 'Home::verify_id/$1');

// Registration & Auth
$routes->get('register', 'Register::index');
$routes->post('register/save', 'Register::save');
$routes->get('login', 'Auth::index');
$routes->post('auth/process', 'Auth::process');
$routes->get('logout', 'Auth::logout');

// Admin Dashboards
$routes->group('admin', ['filter' => 'isAdmin'], function($routes) {
    $routes->get('dashboard', 'Admin::index');
    $routes->get('residents', 'Admin::residents');
    $routes->get('residents/view/(:num)', 'Admin::view_resident/$1');
    $routes->get('residents/edit/(:num)', 'Admin::edit_resident/$1');
    $routes->post('residents/save/(:num)', 'Admin::save_resident/$1');
    $routes->get('residents/delete/(:num)', 'Admin::delete_resident/$1');
    $routes->get('applications', 'Admin::applications');
    $routes->get('cert-approvals', 'Admin::cert_approvals');
    $routes->post('cert-approvals/process/(:num)', 'Admin::process_cert_approval/$1');
    $routes->get('categories', 'Admin::categories');
    $routes->post('categories/save', 'Admin::save_category');
    $routes->get('categories/delete/(:num)', 'Admin::delete_category/$1');
    
    // Complaints / Grievances / Schemes
    $routes->get('projects', 'Admin::projects');
    $routes->post('projects/save', 'Admin::save_project');
    $routes->post('projects/update-progress', 'Admin::update_project_status');
    $routes->get('transparency', 'Admin::transparency_vault');
    $routes->post('transparency/save', 'Admin::save_audit_file');
    $routes->get('transparency/delete/(:num)', 'Admin::delete_audit_file/$1');
    $routes->get('assets', 'Admin::assets');
    $routes->post('assets/save', 'Admin::save_asset');
    $routes->post('assets/update-status', 'Admin::update_asset_status');
    $routes->get('complaints', 'Admin::complaints');
    $routes->post('complaints/process/(:num)', 'Admin::process_complaint/$1');
    $routes->get('scheme-applications', 'Admin::scheme_applications');
    $routes->post('scheme-applications/process/(:num)', 'Admin::process_scheme_application/$1');
    $routes->get('transactions', 'Admin::transactions');
    $routes->post('transactions/add', 'Admin::add_transaction');
    $routes->get('taxes', 'Admin::tax_collection');
    $routes->post('taxes/demand', 'Admin::demand_tax');
    $routes->get('register-docs', 'Admin::register_docs');
    $routes->post('register-docs/save', 'Admin::save_register_doc');
    $routes->match(['get', 'post'], 'register-docs/export', 'Admin::export_register');
    $routes->get('register-docs/certificate/(:num)', 'Admin::view_certificate/$1');
    $routes->post('register-docs/issue/(:num)', 'Admin::issue_certificate/$1');
    $routes->get('register-docs/get/(:num)', 'Admin::get_register_record/$1');
    $routes->post('register-docs/update/(:num)', 'Admin::update_register_doc/$1');
    $routes->get('projects', 'Admin::projects');
    $routes->get('grievances', 'Admin::grievances');
    $routes->get('permissions', 'Admin::permissions');
    $routes->post('update-status', 'Admin::update_status');
    $routes->get('schemes', 'Admin::schemes');
    $routes->post('schemes/save', 'Admin::save_scheme');
    $routes->get('schemes/delete/(:num)', 'Admin::delete_scheme/$1');
    $routes->get('meetings', 'Admin::meetings');
    $routes->post('meetings/save', 'Admin::save_meeting');
    $routes->get('meetings/delete/(:num)', 'Admin::delete_meeting/$1');
    $routes->get('assets', 'Admin::assets');
    $routes->get('village-map', 'Admin::village_map');
    $routes->get('staff', 'Admin::staff');
    $routes->post('staff/add', 'Admin::add_staff');
    $routes->post('staff/edit/(:num)', 'Admin::edit_staff/$1');
    $routes->get('staff/delete/(:num)', 'Admin::delete_staff/$1');
    $routes->get('elearning', 'Admin::elearning');
    $routes->post('elearning/save', 'Admin::save_elearning');
    $routes->post('elearning/update/(:num)', 'Admin::update_elearning/$1');
    $routes->get('elearning/delete/(:num)', 'Admin::delete_elearning/$1');
    $routes->get('accounts', 'Admin::accounts');
    $routes->get('notices', 'Admin::notices');
    $routes->post('notices/save', 'Admin::save_notice');
    $routes->get('notices/delete/(:num)', 'Admin::delete_notice/$1');
    $routes->get('marketplace', 'Admin::manage_marketplace');
    $routes->post('marketplace/save', 'Admin::save_marketplace_product');
    $routes->get('marketplace/approve/(:num)', 'Admin::approve_product/$1');
    $routes->match(['get', 'post'], 'marketplace/reject/(:num)', 'Admin::reject_product/$1');

    // Utility Moderation
    $routes->get('utilities', 'Admin::manage_utilities');
    $routes->post('utilities/update/(:num)/(:any)', 'Admin::update_utility_status/$1/$2');
    $routes->get('agriculture', 'Admin::agriculture');
    $routes->post('agriculture/mandi/save', 'Admin::save_mandi_rate');
    $routes->post('agriculture/inventory/save', 'Admin::save_equipment');
    $routes->get('agriculture/inventory/delete/(:num)', 'Admin::delete_equipment/$1');
    $routes->post('agriculture/booking/update/(:num)/(:any)', 'Admin::update_booking_status/$1/$2');
    $routes->get('emergency', 'Admin::emergency');
    $routes->post('emergency/alert/save', 'Admin::save_emergency_alert');
    $routes->get('emergency/alert/delete/(:num)', 'Admin::delete_alert/$1');
    $routes->post('emergency/directory/save', 'Admin::save_health_directory');
    $routes->get('emergency/directory/delete/(:num)', 'Admin::delete_health_directory/$1');

    // Direct Democracy & Proceedings
    $routes->get('proceedings', 'Admin::proceedings');
    $routes->post('proceedings/save', 'Admin::save_proceeding');
    $routes->get('proceedings/delete/(:num)', 'Admin::delete_proceeding/$1');
    $routes->get('democracy', 'Admin::democracy');
    $routes->post('democracy/poll/save', 'Admin::save_poll');
    $routes->get('democracy/poll/delete/(:num)', 'Admin::delete_poll/$1');
    $routes->post('democracy/suggestion/update', 'Admin::update_suggestion');
});

// User Dashboards
$routes->group('user', ['filter' => 'isUser'], function($routes) {
    $routes->get('dashboard', 'User::index');
    $routes->get('grievances', 'User::grievances');
    $routes->post('submit-grievance', 'User::submit_grievance');
    $routes->get('pay-taxes', 'User::taxes');
    $routes->get('projects', 'User::projects');
    $routes->get('transparency', 'User::transparency_vault');
    $routes->get('assets', 'User::assets');
    $routes->post('taxes/pay/(:num)', 'User::pay_tax/$1');
    $routes->get('permissions', 'User::permissions');
    $routes->get('schemes', 'User::schemes');
    $routes->post('schemes/apply/(:num)', 'User::apply_scheme/$1');
    $routes->get('certificates', 'User::certificates');
    $routes->get('certificate/view/(:num)', 'User::view_certificate/$1');
    $routes->get('my-documents', 'User::my_documents');
    $routes->get('payment-history', 'User::payments');
    $routes->get('profile', 'User::profile');
    $routes->post('submit-application', 'User::submit_application');
    $routes->post('submit-permission', 'User::submit_permission');
    $routes->get('notices', 'User::notices');
    $routes->get('marketplace', 'User::marketplace');
    $routes->get('my-products', 'User::my_products');
    $routes->post('marketplace/save', 'User::save_product');
    $routes->get('marketplace/delete/(:num)', 'User::delete_product/$1');
    
    // Utilities & Agriculture & Emergency
    $routes->get('utilities', 'User::utilities');
    $routes->post('utilities/save', 'User::save_utility_request');
    $routes->get('agriculture', 'User::agriculture');
    $routes->post('agriculture/book', 'User::book_equipment');
    $routes->get('emergency', 'User::emergency');

    // Direct Democracy
    $routes->get('proceedings', 'User::proceedings');
    $routes->get('staff-directory', 'User::staff_directory');
    $routes->get('elearning', 'User::elearning');
    $routes->get('village-map', 'User::village_map');
    $routes->get('democracy', 'User::democracy');
    $routes->post('democracy/suggestion/save', 'User::submit_suggestion');
    $routes->post('democracy/poll/vote/(:num)', 'User::vote_poll/$1');
});

// AI Assistant Routes
$routes->get('ai-assistant', 'AiAssistant::index');
$routes->match(['GET', 'POST'], 'ai-assistant/neural-hub', 'AiAssistant::v3_neural_engine');

