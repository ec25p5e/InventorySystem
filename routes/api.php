<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api_custom.throttle:FAST_COL_ACCESS,1400,60'])->group(function () {
    Route::post('/loadProductColInfo', [ApiController::class, 'loadProductColInfo'])->name('api.loadProductColInfo');
});




Route::post('/deleteProductAttribute', [ApiController::class, 'deleteProductAttribute'])->name('api.deleteProductAttribute');
Route::post('/updateUserRoles', [ApiController::class, 'updateUserRoles'])->name('api.updateUserRoles');
Route::post('/processProductBarcode', [ApiController::class, 'processProductBarcode'])->name('api.processBarCode');
Route::post('/deleteProduct', [ApiController::class, 'deleteProduct'])->name('api.deleteProduct');


$middlewareName = 'api_custom.throttle:FAST_COL_ACCESS,1400,60';

$routes = collect(Route::getRoutes())->filter(function ($route) use ($middlewareName) {
    return collect($route->middleware())->contains($middlewareName);
})->map(function ($route) {
    return $route->uri();
})->values();

