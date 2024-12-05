<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Food;
use Livewire\Component;

class UserPageComponent extends Component
{
    public $models;
    public $categories;
    public $categoriesSort;
    public $selectedCategoryId = null;
    public function mount()
    {
        $this->models = Food::all();
        $this->categories = Category::orderBy('sort', 'asc')->get();
        $this->categoriesSort = Category::orderBy('sort', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.user-page-component')->layout('components.layouts.user');
    }

    public function categoryFilter($categoryId)
    {
        if ($categoryId != '') {
            $this->models = Food::where('category_id', $categoryId)->get();
            $this->categories = Category::where('id', $categoryId)->get();
            $this->selectedCategoryId = $categoryId;
        } else {
            $this->categories = Category::orderBy('sort', 'asc')->get();
            $this->models = Food::all();
            $this->selectedCategoryId = null;
        }

    }
}
