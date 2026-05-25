<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('customers', App\Http\Controllers\CustomerController::class);
Route::resource('services', App\Http\Controllers\ServiceController::class);
Route::resource('subscriptions', App\Http\Controllers\SubscriptionController::class);

Route::patch(
    "/customers/{id}/activate",
    [App\Http\Controllers\CustomerController::class, "activate"]
)->name("customers.activate");

Route::patch(
    "/customers/{id}/deactivate",
    [App\Http\Controllers\CustomerController::class, "deactivate"]
)->name("customers.deactivate");

Route::patch(
    "/services/{id}/activate",
    [App\Http\Controllers\ServiceController::class, "activate"]
)->name("services.activate");

Route::patch(
    "/services/{id}/deactivate",
    [App\Http\Controllers\ServiceController::class, "deactivate"]
)->name("services.deactivate");

Route::patch(
    "/subscriptions/{id}/activate",
    [App\Http\Controllers\SubscriptionController::class, "activate"]
)->name("subscriptions.activate");

Route::patch(
    "/subscriptions/{id}/deactivate",
    [App\Http\Controllers\SubscriptionController::class, "deactivate"]
)->name("subscriptions.deactivate");

Route::patch(
    "/subscriptions/{id}/trial",
    [App\Http\Controllers\SubscriptionController::class, "trial"]
)->name("subscriptions.trial");

Route::patch(
    "/subscriptions/{id}/isolir",
    [App\Http\Controllers\SubscriptionController::class, "isolir"]
)->name("subscriptions.isolir");

Route::patch(
    "/subscriptions/{id}/dismantle",
    [App\Http\Controllers\SubscriptionController::class, "dismantle"]
)->name("subscriptions.dismantle");