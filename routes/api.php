<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

// Route bawaan yang dibuat saat install:api
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Route untuk Checklist
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/checklist', [ChecklistController::class, 'index']);
    Route::post('/checklist', [ChecklistController::class, 'store']);
    Route::delete('/checklist/{id}', [ChecklistController::class, 'destroy']);

    // Route untuk Checklist Item
    Route::get('/checklist/{checklistId}/item', [ChecklistItemController::class, 'index']);
    Route::post('/checklist/{checklistId}/item', [ChecklistItemController::class, 'store']);
    Route::get('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'show']);
    Route::put('/checklist/{checklistId}/item/{itemId}/status', [ChecklistItemController::class, 'updateStatus']);
    Route::delete('/checklist/{checklistId}/item/{itemId}', [ChecklistItemController::class, 'destroy']);
    Route::put('/checklist/{checklistId}/item/rename/{itemId}', [ChecklistItemController::class, 'rename']);
});
