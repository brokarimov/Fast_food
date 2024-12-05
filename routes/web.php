<?php

use App\Livewire\CategoryComponent;
use App\Livewire\FoodComponent;
use App\Livewire\UserPageComponent;
use Illuminate\Support\Facades\Route;


Route::get('/category', CategoryComponent::class);
Route::get('/food', FoodComponent::class);
Route::get('/', UserPageComponent::class);

