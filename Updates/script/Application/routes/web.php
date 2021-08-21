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
// Email verfication route
Auth::routes(['verify' => true]);
// Check if website alredy install
Route::group(['middleware' => 'IsInstalled'], function () {
    // Install routes
    Route::get('/install/install', [App\Http\Controllers\Install\InstallController::class, 'index'])->name('install/install');
    Route::get('/install/step1', [App\Http\Controllers\Install\InstallController::class, 'step1'])->name('install/step1');
    Route::post('/install/step1/set_database', [App\Http\Controllers\Install\InstallController::class, 'set_database'])->name('install/step1/set_database');
    Route::get('/install/step2', [App\Http\Controllers\Install\InstallController::class, 'step2'])->name('install/step2');
    Route::post('/install/step2/import_database', [App\Http\Controllers\Install\InstallController::class, 'import_database'])->name('install/step2/import_database');
    Route::get('/install/step3', [App\Http\Controllers\Install\InstallController::class, 'step3'])->name('install/step3');
    Route::post('/install/step3/set_siteinfo', [App\Http\Controllers\Install\InstallController::class, 'set_siteinfo'])->name('install/step3/set_siteinfo');
    Route::get('/install/step4', [App\Http\Controllers\Install\InstallController::class, 'step4'])->name('install/step4');
    Route::post('/install/step4/set_admininfo', [App\Http\Controllers\Install\InstallController::class, 'set_admininfo'])->name('install/step4/set_admininfo');
});

// Check if website is installed
Route::group(['middleware' => 'check.installation'], function () {
    // If auth is admin
    Route::group(['middleware' => 'adminredirect'], function () {
        // Check if email verifed
        Route::group(['middleware' => 'verified'], function () {
            // Home route
            Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('app.home');
            // Upload routes
            Route::post('upload', [App\Http\Controllers\Frontend\UploadController::class, 'index']);
            Route::delete('uploads/delete/{filename}', [App\Http\Controllers\Frontend\UploadController::class, 'deleteUploads']);
            // Transfer routes
            Route::post('transfer/generate/link', [App\Http\Controllers\Frontend\TransferController::class, 'link'])->name('generate.link');
            Route::post('transfer/files/send', [App\Http\Controllers\Frontend\TransferController::class, 'send'])->name('transfer.files');
            // Download routes
            Route::get('download/{transfer_id}', [App\Http\Controllers\Frontend\DownloadController::class, 'index'])->name('download.page');
            Route::get('download/{transfer_id}/password', [App\Http\Controllers\Frontend\DownloadController::class, 'password'])->name('download.password');
            Route::post('download/{transfer_id}/password/store', [App\Http\Controllers\Frontend\DownloadController::class, 'password_store'])->name('store.password');
            Route::get('download/request/{id}/{file_name}', [App\Http\Controllers\Frontend\DownloadController::class, 'request_download'])->middleware('only.ajax');
            Route::get('download/{id}/{file_name}', [App\Http\Controllers\Frontend\DownloadController::class, 'download'])->name('download.file');
            // View pages route
            Route::get('page/{slug}', [App\Http\Controllers\Frontend\PagesController::class, 'index'])->name('view.page');
            Route::post('page/contact/send', [App\Http\Controllers\Frontend\PagesController::class, 'sendMessage'])->name('send.message');
        });
    });
    // Login routes
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    // Logout route
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    // Register routes
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    // Password rest and confirm routes
    Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('password/confirm', [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']);
    // Email verify routes
    Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');

    // Route group when user login
    Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
        // If auth is admin
        Route::group(['middleware' => 'adminredirect'], function () {
            // Check if email verifed
            Route::group(['middleware' => 'verified'], function () {
                // Dashboard route
                Route::get('/dashboard', [App\Http\Controllers\Frontend\User\DashboardController::class, 'index'])->name('user.dashboard');
                // Payment routes
                Route::get('/payments', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'index'])->name('payments.page');
                Route::get('/payments/transaction/view/{id}', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'view_transaction'])->name('view.user.transaction');
                Route::post('/payments/create', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'payment_create'])->name('create.payment');
                Route::post('/payments/charge', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'charge'])->name('new.payment');
                Route::get('/payments/success', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'payment_success'])->name('payment.success');
                Route::get('/payments/error', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'payment_error'])->name('payment.error');
                Route::get('/payments/cancel/{id}', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'cancel_payment'])->middleware('only.ajax');
                // View transfer route
                Route::get('/transfers/view/{transfer_id}', [App\Http\Controllers\Frontend\User\TransfersController::class, 'index'])->name('view.transfer');
                // Settings route
                Route::get('/settings', [App\Http\Controllers\Frontend\User\SettingsController::class, 'index'])->name('user.settings');
                Route::post('/settings/update/info', [App\Http\Controllers\Frontend\User\SettingsController::class, 'updateInfo'])->name('update.info');
                Route::post('/settings/update/password', [App\Http\Controllers\Frontend\User\SettingsController::class, 'updatePassword'])->name('update.password');
                Route::get('/settings/cache/delete', [App\Http\Controllers\Frontend\User\SettingsController::class, 'deleteCache'])->name('delete.cache');
            });
        });
    });

    // Route group when user login
    Route::group(['middleware' => 'auth'], function () {
        // If auth is admin
        Route::group(['middleware' => 'adminredirect'], function () {
            // Check if email verifed
            Route::group(['middleware' => 'verified'], function () {
                // Checkout
                Route::get('/checkout/{generate_id}', [App\Http\Controllers\Frontend\User\PaymentsController::class, 'checkout'])->name('checkout');
            });
        });
    });

    // Route group for admin
    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        // Route group for admin middleware
        Route::group(['middleware' => 'admin'], function () {
            // Dashboard route
            Route::get('/', [App\Http\Controllers\Backend\DashboardController::class, 'redirectAdmin'])->name('admin');
            Route::get('/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/dashboard/charts/users', [App\Http\Controllers\Backend\DashboardController::class, 'getDailyUsersData']);
            Route::get('/dashboard/charts/transfers', [App\Http\Controllers\Backend\DashboardController::class, 'getDailyTransfersData']);
            // Users routes
            Route::get('/users', [App\Http\Controllers\Backend\UsersController::class, 'index'])->name('users');
            Route::post('/users/add/store', [App\Http\Controllers\Backend\UsersController::class, 'add_user_store'])->name('add.user.store');
            Route::get('/users/edit/{id}', [App\Http\Controllers\Backend\UsersController::class, 'edit_user'])->name('edit.user');
            Route::post('/users/edit/{id}/store', [App\Http\Controllers\Backend\UsersController::class, 'edit_user_store'])->name('edit.user.store');
            // Transfers routes
            Route::get('/transfers', [App\Http\Controllers\Backend\TransfersController::class, 'index'])->name('transfers');
            Route::get('/trasnfers/view/{transfer_id}', [App\Http\Controllers\Backend\TransfersController::class, 'view_transfer'])->name('admin.view.transfer');
            Route::get('/trasnfers/cancel/{transfer_id}', [App\Http\Controllers\Backend\TransfersController::class, 'cancel_transfer'])->name('cancel.transfer');
            Route::get('/transfers/download/{id}/{file_name}', [App\Http\Controllers\Backend\TransfersController::class, 'download_file'])->name('admin.download.file');
            // Transactions routes
            Route::get('/transactions', [App\Http\Controllers\Backend\TransactionsController::class, 'index'])->name('transactions');
            Route::get('/transactions/view/{id}', [App\Http\Controllers\Backend\TransactionsController::class, 'view_transaction'])->name('view.transaction');
            // Prices routes
            Route::get('/prices', [App\Http\Controllers\Backend\PricesController::class, 'index'])->name('prices');
            Route::get('/prices/add', [App\Http\Controllers\Backend\PricesController::class, 'add_price'])->name('add.price');
            Route::post('/prices/add/store', [App\Http\Controllers\Backend\PricesController::class, 'add_price_store'])->name('add.price.store');
            Route::get('/prices/edit/{id}', [App\Http\Controllers\Backend\PricesController::class, 'edit_price'])->name('edit.price');
            Route::post('/prices/edit/{id}/store', [App\Http\Controllers\Backend\PricesController::class, 'edit_price_store'])->name('edit.price.store');
            Route::get('/prices/{id}/delete', [App\Http\Controllers\Backend\PricesController::class, 'delete_price'])->name('delete.price');
            // Messages route
            Route::get('/messages', [App\Http\Controllers\Backend\MessagesController::class, 'index'])->name('messages');
            Route::get('/messages/view/{id}', [App\Http\Controllers\Backend\MessagesController::class, 'view_message'])->name('view.message');
            Route::get('/messages/delete/{id}', [App\Http\Controllers\Backend\MessagesController::class, 'delete_message'])->name('delete.message');
            // Pages routes
            Route::get('/pages', [App\Http\Controllers\Backend\PagesController::class, 'index'])->name('pages');
            Route::get('/pages/add', [App\Http\Controllers\Backend\PagesController::class, 'add_page'])->name('add.page');
            Route::post('/pages/add/store', [App\Http\Controllers\Backend\PagesController::class, 'add_page_store'])->name('add.page.store');
            Route::get('/pages/edit/{id}', [App\Http\Controllers\Backend\PagesController::class, 'edit_page'])->name('edit.page');
            Route::post('/pages/edit/{id}/store', [App\Http\Controllers\Backend\PagesController::class, 'edit_page_store'])->name('edit.page.store');
            Route::get('/pages/{id}/delete', [App\Http\Controllers\Backend\PagesController::class, 'delete_page'])->name('delete.page');
            // Settings routes
            Route::get('/settings/information', [App\Http\Controllers\Backend\SettingsController::class, 'information']);
            Route::post('/settings/information/store', [App\Http\Controllers\Backend\SettingsController::class, 'information_store'])->name('information.store');
            Route::post('/settings/information/identity/store', [App\Http\Controllers\Backend\SettingsController::class, 'identity_store'])->name('identity.store');
            Route::get('/settings/payments', [App\Http\Controllers\Backend\SettingsController::class, 'payments']);
            Route::post('/settings/payments/paypal/store', [App\Http\Controllers\Backend\SettingsController::class, 'paypal_payments_store'])->name('paypal.store');
            Route::post('/settings/payments/stripe/store', [App\Http\Controllers\Backend\SettingsController::class, 'stripe_payments_store'])->name('stripe.store');
            Route::get('/settings/captcha', [App\Http\Controllers\Backend\SettingsController::class, 'captcha']);
            Route::post('/settings/captcha/store', [App\Http\Controllers\Backend\SettingsController::class, 'captcha_store'])->name('captcha.store');
            Route::get('/settings/seo', [App\Http\Controllers\Backend\SettingsController::class, 'seo']);
            Route::post('/settings/seo/store', [App\Http\Controllers\Backend\SettingsController::class, 'seo_store'])->name('seo.store');
            Route::get('/settings/smtp', [App\Http\Controllers\Backend\SettingsController::class, 'smtp']);
            Route::post('/settings/smtp/store', [App\Http\Controllers\Backend\SettingsController::class, 'smtp_store'])->name('smtp.store');
            Route::get('/settings/amazon', [App\Http\Controllers\Backend\SettingsController::class, 'amazon']);
            Route::post('/settings/amazon/store', [App\Http\Controllers\Backend\SettingsController::class, 'amazon_store'])->name('amazon.store');
            // Admin settings routes
            Route::get('/account/settings', [App\Http\Controllers\Backend\Account\SettingsController::class, 'index']);
            Route::post('/account/settings/info/store', [App\Http\Controllers\Backend\Account\SettingsController::class, 'admin_update_info'])->name('admin.update.info');
            Route::post('/account/settings/password/store', [App\Http\Controllers\Backend\Account\SettingsController::class, 'admin_update_password'])->name('admin.update.password');
        });
    });

});
