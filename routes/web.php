<?php
# Backend Controllers

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\BackendFileController;
use App\Http\Controllers\Backend\BackendRoleController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendOrderController;
use App\Http\Controllers\Backend\BackendHelperController;
use App\Http\Controllers\Backend\BackendPluginController;
use App\Http\Controllers\Backend\BackendContactController;
use App\Http\Controllers\Backend\BackendProductController;
use App\Http\Controllers\Backend\BackendProfileController;
use App\Http\Controllers\Backend\BackendSettingController;
use App\Http\Controllers\Backend\BackendSiteMapController;
use App\Http\Controllers\Backend\BackendCategoryController;
use App\Http\Controllers\Backend\BackendCustomerController;
use App\Http\Controllers\Backend\BackendTrafficsController;
use App\Http\Controllers\Backend\BackendUserRoleController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Backend\BackendRedirectionController;
use App\Http\Controllers\Backend\BackendNotificationsController;

# Frontend Controllers

Route::view('/', 'deleted.layouts.guest');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::prefix('admin')->middleware(['auth:web,customer', 'ActiveAccount'])->group(function () {
        Route::get('/payments/verify/{payment?}', [BackendHelperController::class, 'payment_verify'])->name('verify-payment');
    });
    Route::get('orders/export/', [BackendOrderController::class, 'export'])->name('export');
    Route::get('orders/export_xml/', [BackendOrderController::class, 'xml'])->name('export_xml');
    Route::post('/uploadXml', [BackendOrderController::class, 'uploadFileXml'])->name('uploadXml.file');

    Route::prefix('admin')->middleware(['auth:web,customer', 'ActiveAccount'])->name('admin.')->group(function () {

        Route::get('/home', [BackendAdminController::class, 'index'])->name('index');
        Route::middleware('auth')->group(function () {
            Route::resource('files', BackendFileController::class);
            Route::get('users/{user}/access', [BackendUserController::class, 'access'])->name('users.access');
            Route::resource('users', BackendUserController::class);
            Route::resource('customers', BackendCustomerController::class);
            Route::resource('categories', BackendCategoryController::class);
            Route::resource('products', BackendProductController::class);
            Route::resource('orders', BackendOrderController::class);
            Route::get('customer_orders', [BackendOrderController::class, 'customer_orders'])->name('customer_orders');
            Route::resource('roles', BackendRoleController::class);
            Route::get('user-roles/{user}', [BackendUserRoleController::class, 'index'])->name('users.roles.index');
            Route::put('user-roles/{user}', [BackendUserRoleController::class, 'update'])->name('users.roles.update');
            Route::get('customer-roles/{customer}', [BackendUserRoleController::class, 'indexCustomer'])->name('customers.roles.index');
            Route::put('customer-roles/{customer}', [BackendUserRoleController::class, 'updateCustomer'])->name('customers.roles.update');
            Route::resource('redirections', BackendRedirectionController::class);
            Route::get('traffics', [BackendTrafficsController::class, 'index'])->name('traffics.index');
            Route::get('traffics/logs', [BackendTrafficsController::class, 'logs'])->name('traffics.logs');
            Route::get('error-reports', [BackendTrafficsController::class, 'error_reports'])->name('traffics.error-reports');
            Route::get('error-reports/{report}', [BackendTrafficsController::class, 'error_report'])->name('traffics.error-report');
            Route::get('del/{param}', [BackendAdminController::class, 'helper']);
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [BackendSettingController::class, 'index'])->name('index');
                Route::put('/update', [BackendSettingController::class, 'update'])->name('update');
            });
        });

        Route::prefix('upload')->name('upload.')->group(function () {
            Route::post('/image', [BackendHelperController::class, 'upload_image'])->name('image');
            Route::post('/file', [BackendHelperController::class, 'upload_file'])->name('file');
            Route::post('/remove-file', [BackendHelperController::class, 'remove_files'])->name('remove-file');
        });

        Route::prefix('plugins')->name('plugins.')->group(function () {
            Route::get('/', [BackendPluginController::class, 'index'])->name('index');
            Route::get('/create', [BackendPluginController::class, 'create'])->name('create');
            Route::post('/create', [BackendPluginController::class, 'store'])->name('store');
            Route::post('/{plugin}/activate', [BackendPluginController::class, 'activate'])->name('activate');
            Route::post('/{plugin}/deactivate', [BackendPluginController::class, 'deactivate'])->name('deactivate');
            Route::post('/{plugin}/delete', [BackendPluginController::class, 'delete'])->name('delete');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [BackendProfileController::class, 'index'])->name('index');
            Route::get('/edit', [BackendProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [BackendProfileController::class, 'update'])->name('update');
            Route::put('/update-password', [BackendProfileController::class, 'update_password'])->name('update-password');
            Route::put('/update-email', [BackendProfileController::class, 'update_email'])->name('update-email');
        });

        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [BackendNotificationsController::class, 'index'])->name('index');
            Route::get('/ajax', [BackendNotificationsController::class, 'ajax'])->name('ajax');
            Route::post('/see', [BackendNotificationsController::class, 'see'])->name('see');
            Route::get('/create', [BackendNotificationsController::class, 'create'])->name('create');
            Route::post('/create', [BackendNotificationsController::class, 'store'])->name('store');
        });
    });

    Route::get('/login/google/redirect', [LoginController::class, 'redirect_google']);
    Route::get('/login/google/callback', [LoginController::class, 'callback_google']);
    Route::get('/login/facebook/redirect', [LoginController::class, 'redirect_facebook']);
    Route::get('/login/facebook/callback', [LoginController::class, 'callback_facebook']);


    Route::get('blocked', [BackendHelperController::class, 'blocked_user'])->name('blocked');
    Route::get('robots.txt', [BackendHelperController::class, 'robots']);
    Route::get('manifest.json', [BackendHelperController::class, 'manifest'])->name('manifest');
    Route::get('sitemap.xml', [BackendSiteMapController::class, 'sitemap']);
    Route::get('sitemaps/links', [BackendSiteMapController::class, 'custom_links']);
    Route::get('sitemaps/{name}/{page}/sitemap.xml', [BackendSiteMapController::class, 'viewer']);
});
