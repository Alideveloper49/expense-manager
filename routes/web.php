<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\IncomeCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\ExpenseReportController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
        Route::redirect('/', '/admin/expenses');

        // Permissions
        Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
        Route::resource('permissions', PermissionsController::class);

        // Roles
        Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
        Route::resource('roles', RolesController::class);

        // Users
        Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
        Route::resource('users', UsersController::class);

        // Expense Categories
        Route::delete('expense-categories/destroy', [ExpenseCategoryController::class, 'massDestroy'])->name('expense-categories.massDestroy');
        Route::resource('expense-categories', ExpenseCategoryController::class);

        // Income Categories
        Route::delete('income-categories/destroy', [IncomeCategoryController::class, 'massDestroy'])->name('income-categories.massDestroy');
        Route::resource('income-categories', IncomeCategoryController::class);

        // Expenses
        Route::delete('expenses/destroy', [ExpenseController::class, 'massDestroy'])->name('expenses.massDestroy');
        Route::resource('expenses', ExpenseController::class);

        // Incomes
        Route::delete('incomes/destroy', [IncomeController::class, 'massDestroy'])->name('incomes.massDestroy');
        Route::resource('incomes', IncomeController::class);

        // Expense Reports
        Route::delete('expense-reports/destroy', [ExpenseReportController::class, 'massDestroy'])->name('expense-reports.massDestroy');
        Route::resource('expense-reports', ExpenseReportController::class);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
