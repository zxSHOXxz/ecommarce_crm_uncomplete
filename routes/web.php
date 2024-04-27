<?php
# Backend Controllers

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BackendFileController;
use App\Http\Controllers\Backend\BackendRoleController;
use App\Http\Controllers\Backend\BackendUserController;
use App\Http\Controllers\Backend\BackendAdminController;
use App\Http\Controllers\Backend\BackendOrderController;
use App\Http\Controllers\Backend\BackendHelperController;
use App\Http\Controllers\Backend\BackendProductController;
use App\Http\Controllers\Backend\BackendProfileController;
use App\Http\Controllers\Backend\BackendSettingController;
use App\Http\Controllers\Backend\BackendCategoryController;
use App\Http\Controllers\Backend\BackendCustomerController;
use App\Http\Controllers\Backend\BackendUserRoleController;
use App\Http\Controllers\ExcelExportController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\InvoiceController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

# Frontend Controllers

Route::get('/', [BackendHelperController::class, 'guest'])->name('guest');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    // Route::prefix('admin')->middleware(['auth:web,customer', 'ActiveAccount'])->group(function () {
    //     Route::get('/payments/verify/{payment?}', [BackendHelperController::class, 'payment_verify'])->name('verify-payment');
    // });

    Route::post('products/import/', [ExcelImportController::class, 'import'])->name('import');
    Route::get('products/export/', [ExcelExportController::class, 'export'])->name('export');
    Route::get('products/xml_export/', [ExcelExportController::class, 'product_xml_export'])->name('xml_export');
    Route::post('products/importFromXml', [ExcelImportController::class, 'importProductsFromXml'])->name('importProductsFromXml');

    Route::prefix('admin')->middleware(['auth:web,customer', 'ActiveAccount', 'verified'])->name('admin.')->group(function () {
        Route::get('/home', [BackendAdminController::class, 'index'])->name('index');
        Route::middleware('auth')->group(function () {
            Route::resource('files', BackendFileController::class);
            Route::get('users/{user}/access', [BackendUserController::class, 'access'])->name('users.access');
            Route::resource('users', BackendUserController::class);
            Route::resource('customers', BackendCustomerController::class);
            Route::resource('categories', BackendCategoryController::class);
            Route::resource('products', BackendProductController::class);
            Route::resource('orders', BackendOrderController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::get('invoice/{id}', [InvoiceController::class, 'createPdfInvoice'])->name('invoice.pdf');
            Route::get('customer_orders', [BackendOrderController::class, 'customer_orders'])->name('customer_orders');
            Route::get('show_customer_order/{id}', [BackendOrderController::class, 'show_customer_order'])->name('show_customer_order');
            Route::resource('roles', BackendRoleController::class);
            Route::get('user-roles/{user}', [BackendUserRoleController::class, 'index'])->name('users.roles.index');
            Route::put('user-roles/{user}', [BackendUserRoleController::class, 'update'])->name('users.roles.update');
            Route::get('customer-roles/{customer}', [BackendUserRoleController::class, 'indexCustomer'])->name('customers.roles.index');
            Route::put('customer-roles/{customer}', [BackendUserRoleController::class, 'updateCustomer'])->name('customers.roles.update');
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

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [BackendProfileController::class, 'index'])->name('index');
            Route::get('/edit', [BackendProfileController::class, 'edit'])->name('edit');
            Route::put('/update', [BackendProfileController::class, 'update'])->name('update');
            Route::put('/update-password', [BackendProfileController::class, 'update_password'])->name('update-password');
            Route::put('/update-email', [BackendProfileController::class, 'update_email'])->name('update-email');
        });

        // Route::prefix('notifications')->name('notifications.')->group(function () {
        //     Route::get('/', [BackendNotificationsController::class, 'index'])->name('index');
        //     Route::get('/ajax', [BackendNotificationsController::class, 'ajax'])->name('ajax');
        //     Route::post('/see', [BackendNotificationsController::class, 'see'])->name('see');
        //     Route::get('/create', [BackendNotificationsController::class, 'create'])->name('create');
        //     Route::post('/create', [BackendNotificationsController::class, 'store'])->name('store');
        // });
    });
    Route::get('blocked', [BackendHelperController::class, 'blocked_user'])->name('blocked');
});
