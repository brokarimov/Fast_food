<?php

use App\Livewire\CategoryComponent;
use App\Livewire\DepartmentComponent;
use App\Livewire\EmployeeComponent;
use App\Livewire\FoodComponent;
use App\Livewire\OrderAdminComponent;
use App\Livewire\UserComponent;
use App\Livewire\UserPageComponent;
use Illuminate\Support\Facades\Route;


Route::get('/category', CategoryComponent::class);
Route::get('/food', FoodComponent::class);
Route::get('/department', DepartmentComponent::class);
Route::get('/users', UserComponent::class);
Route::get('/employee', EmployeeComponent::class);
Route::get('/', UserPageComponent::class);
Route::get('/order', OrderAdminComponent::class);

