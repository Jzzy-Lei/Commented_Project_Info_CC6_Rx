<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
use App\Http\Controllers\ImageController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $projects = Project::all();
    return view('dashboard', compact('projects'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
Route::delete('/project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

Route::get('/project/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
Route::put('/project/{project}', [ProjectController::class, 'update'])->name('project.update');
Route::get('/portfolio/{project}', [ProjectController::class, 'portfolio'])->name('portfolio');
Route::delete('/images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');



require __DIR__.'/auth.php';
