<?php
use Core\Router;
use Middleware\EnsureAuth;
use Controllers\Admin\UsersController;
use Controllers\Admin\IngredientsController;

$mw = [EnsureAuth::class, 'handle'];

// Users
Router::get('/admin/users',             $mw, [UsersController::class, 'index']);
Router::get('/admin/users/create',      $mw, [UsersController::class, 'create']);
Router::post('/admin/users',            $mw, [UsersController::class, 'store']);
Router::get('/admin/users/{id}/edit',   $mw, [UsersController::class, 'edit']);
Router::post('/admin/users/{id}/update',$mw, [UsersController::class, 'update']);
Router::post('/admin/users/{id}/delete',$mw, [UsersController::class, 'destroy']);

// Ingredients
Router::get('/admin/ingredients',               $mw, [IngredientsController::class, 'index']);
Router::get('/admin/ingredients/create',        $mw, [IngredientsController::class, 'create']);
Router::post('/admin/ingredients',              $mw, [IngredientsController::class, 'store']);
Router::get('/admin/ingredients/{id}/edit',     $mw, [IngredientsController::class, 'edit']);
Router::post('/admin/ingredients/{id}/update',  $mw, [IngredientsController::class, 'update']);
Router::post('/admin/ingredients/{id}/delete',  $mw, [IngredientsController::class, 'destroy']);
