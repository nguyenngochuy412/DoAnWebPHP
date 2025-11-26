<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/{slug}', [PetController::class, 'show'])->name('pets.show');
Route::get('/search', [PetController::class, 'search'])->name('pets.search');

