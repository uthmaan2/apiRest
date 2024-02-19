<?php

use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Recuperer la liste des articles
Route::get('posts', [ApiPostController::class, 'index']);


//Inscrire un utilisateur
Route::post('/register', [UserController::class, 'register']);

//Connecter un utilisateur
Route::post('/login', [UserController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    //Ajouter un post  / POST / PUT / PATCH
    Route::post('posts/create', [ApiPostController::class, 'store']);

    //Modifier un post
    Route::put('posts/edit/{post}', [ApiPostController::class, 'update']);

    //Supprimer un post
    Route::delete('posts/{post}', [ApiPostController::class, 'delete']);

    //Retourner l'utilisateur actuellement connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
