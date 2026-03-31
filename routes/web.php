<?php

use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route("filament.admin.auth.login");
});

Route::get("/register-visitor", [VisitorController::class, "create"])->name('visitor.create');
Route::post("/register-visitor", [VisitorController::class, "store"])->name('visitor.store');
