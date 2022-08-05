<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjectController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//these routes do not need authentication.
Route::post('register', [StudentController::class, 'register']);
Route::post('login', [StudentController::class, 'login']);

//these routes are protected routes by Sanctum middleware.
//checks that there is an authorized Sanctum token with the request.
//if no token it will return an error unauthenticated.
Route::group(['middleware' => ['auth:sanctum']], function(){

    //student controller routes
    Route::get('logout', [StudentController::class, 'logout']);
    Route::get('profile', [StudentController::class, 'profile']);
    
    //project controller routes
    Route::post('create-project', [ProjectController::class, 'createProject']);
    Route::get('list-project', [ProjectController::class, 'listProject']);
    Route::get('single-project/{id}', [ProjectController::class, 'singleProject']);
    Route::delete('delete-project/{id}', [ProjectController::class, 'deleteProject']);

});



//api-2
Route::get('list-students', [StudentController::class, 'listStudents']);
Route::get('list-single-student/{id}', [StudentController::class, 'getSingleStudent']);
Route::post('add-student', [StudentController::class, 'createStudent']);
Route::put('update-student/{id}', [StudentController::class, 'updateStudent']);
Route::delete('delete-student/{id}', [StudentController::class, 'deleteStudent']);

