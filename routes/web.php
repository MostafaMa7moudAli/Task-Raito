<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(ProductController::class)->group(function ()
{
    Route::get('/', "index")->name('products.index');
    Route::post('products/search', "search")->name('products.search');
    Route::get('product/create', "create")->name('product.create');
    Route::post('product/store', "store")->name('product.store');
    Route::get('product/edit/{id}', "edit")->name('product.edit');
    Route::post('product/update/{id}', "update")->name('product.update');
    Route::get('product/delete/{id}', "delete")->name('product.delete');
    Route::post('product/destroy/{id}', "destroy")->name('product.destroy');
});

Route::controller(CustomerController::class)->group(function ()
{
    Route::get('customers', "index")->name('customers.index');
    Route::post('customers/search', "search")->name('customers.search');
    Route::get('customer/create', "create")->name('customer.create');
    Route::post('customer/store', "store")->name('customer.store');
    Route::get('customer/edit/{id}', "edit")->name('customer.edit');
    Route::post('customer/update/{id}', "update")->name('customer.update');
    Route::get('customer/delete/{id}', "delete")->name('customer.delete');
    Route::post('customer/destroy/{id}', "destroy")->name('customer.destroy');
});

Route::controller(InvoiceController::class)->group(function ()
{
    Route::get('invoices', "index")->name('invoices.index');
    Route::post('invoices/search', "search")->name('invoices.search');
    Route::post('invoice/store', "store")->name('invoice.store');
    Route::get('invoice/details/{id}', "details")->name('invoice.details');
    Route::post('invoice/update', "update")->name('invoice.update');
    Route::post('storeInvoiceProduct', "storeInvoiceProduct")->name('invoice.storeInvoiceProduct');
    Route::post('destroyInvoiceProduct', "destroyInvoiceProduct")->name('invoice.destroyInvoiceProduct');
    Route::post('invoice/destroy', "destroy")->name('invoice.destroy');
    Route::get('invoice_number', 'getNew_invoiceNumber');
    Route::get('productPrice/{id}', 'productPrice');
});
