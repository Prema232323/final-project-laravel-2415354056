<?php

use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SubscriptionController;

Route::apiResource("customers", CustomerController::class)->names("api.customers");

Route::patch(
    "customers/{customer}/activate",
    [CustomerController::class, "activate"]
);

Route::patch(
    "customers/{customer}/deactivate",
    [CustomerController::class, "deactivate"]
);

Route::patch(
    "services/{service}/activate",
    [ServiceController::class, "activate"]
);

Route::patch(
    "services/{service}/deactivate",
    [ServiceController::class, "deactivate"]
);

Route::apiResource("services", ServiceController::class)->names("api.services");

Route::apiResource("subscriptions", SubscriptionController::class)->names("api.subscriptions");

Route::patch(
    "subscriptions/{subscription}/activate",
    [SubscriptionController::class, "activate"]
);

Route::patch(
    "subscriptions/{subscription}/deactivate",
    [SubscriptionController::class, "deactivate"]
);

Route::patch(
    "subscriptions/{subscription}/trial",
    [SubscriptionController::class, "trial"]
);

Route::patch(
    "subscriptions/{subscription}/isolir",
    [SubscriptionController::class, "isolir"]
);

Route::patch(
    "subscriptions/{subscription}/dismantle",
    [SubscriptionController::class, "dismantle"]
);