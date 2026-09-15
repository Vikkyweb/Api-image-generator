<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V2\PostControllerV2;
use App\Http\Controllers\ImageGenerationController;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get('hello', function(){
//     return ["message" => "Hello World"];
// });

// // Route::get('posts', [PostController::class, 'index'])->name('posts.index');
// // Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
// // Route::post('posts', [PostController::class, 'store'])->name('posts.store');

// // Route::apiResource('posts', PostController::class);


Route::middleware(['auth:sanctum', 'throttle:api'])->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::prefix('v1')->group(function(){
        Route::apiResource('posts', PostController::class);
        Route::apiResource('image-generations', ImageGenerationController::class)->only(['index','create']);
    });
});
// // Versioning API
// Route::prefix('v1')->group(function(){
//     Route::apiResource('posts', PostController::class);
// });

// Route::prefix('v2')->group(function(){
//     Route::apiResource('posts', PostControllerV2::class);
// });


require __DIR__.'/auth.php';