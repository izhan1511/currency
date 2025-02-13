<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ReceiverController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'can:access.admin.panel'])->group(function () {
    // admins
    Route::get('/admin', [AdminController::class, 'adminPanelPage'])->name('admin.panel.page');
    Route::get('/admin/admins', [AdminController::class, 'adminsPage'])->name('admins.page');

    // transactions
    Route::get('/admin/transactions', [TransactionController::class, 'transactionsPage'])->name('transactions.page');
    Route::get('/admin/transactions/payment-intent/{paymentIntent}', [TransactionController::class, 'paymentIntentPage'])->name('payment.intent.page');

    // transactions
    Route::get('/admin/posts', [PostController::class, 'postsPage'])->name('posts.page');

    // banks
    Route::get('/admin/banks', [BankController::class, 'index'])->name('banks.page');
    Route::post('/admin/banks/store', [BankController::class, 'store'])->name('banks.store');
    Route::put('/admin/banks/update/{bank}', [BankController::class, 'update'])->name('banks.update');
    Route::delete('/admin/banks/delete/{bank}', [BankController::class, 'delete'])->name('banks.delete');

    // currencies
    Route::get('/admin/currencies', [CurrencyController::class, 'currenciesPage'])->name('currencies.page');
    Route::post('/admin/currencies/store', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::put('/admin/currencies/update/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/admin/currencies/delete/{currency}', [CurrencyController::class, 'delete'])->name('currencies.delete');
    Route::put('/admin/currencies/update-rates', [CurrencyController::class, 'updateRates'])->name('currencies.update.rates');
    Route::get('/admin/currencies/{column}/{type}', [CurrencyController::class, 'currenciesPageSort'])->name('currencies.page.sort');

    // countries
    Route::get('/admin/countries', [CountriesController::class, 'countriesPage'])->name('countries.page');
    Route::post('/admin/countries/store', [CountriesController::class, 'store'])->name('countries.store');
    Route::put('/admin/countries/update/{country}', [CountriesController::class, 'update'])->name('countries.update');


    // users
    Route::get('/admin/users', [UsersController::class, 'usersPage'])->name('users.page');
    Route::get('/admin/users/{user}', [UsersController::class, 'singleUserPage'])->name('single.user.page');

    // receivers
    Route::get('/admin/receivers', [ReceiverController::class, 'receiversPage'])->name('receivers.page');
    Route::get('/admin/receivers/{receiver}', [ReceiverController::class, 'singleReceiverPage'])->name('single.receiver.page');
});
