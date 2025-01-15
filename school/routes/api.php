<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('schools', SchoolController::class);
Route::get('schools', [SchoolController::class, 'index']);         
Route::post('schools', [SchoolController::class, 'store']);        
Route::get('schools/{id}', [SchoolController::class, 'show']);     
Route::put('schools/{id}', [SchoolController::class, 'update']);  
Route::delete('schools/{id}', [SchoolController::class, 'destroy']);
Route::get('schools/{school_id}/students', [SchoolController::class, 'getStudentsBySchool']);

// check health of services
// Route::get('/health', function () {
//     return response()->json(['status' => 'healthy'], 200);
// });
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'service' => 'school',
        'timestamp' => now()
    ]);
});