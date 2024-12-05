<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryComponent extends Component
{
    public $models;
    public $name;
    public $activeForm = false;
    public $editFormCategory = false;
    public $nameEdit;

    protected $rules = [
        'name' => 'required|max:255',
    ];
    public function updated($propertyName)
    {   
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->models = Category::orderBy('sort', 'asc')->get();
    }
    public function render()
    {
        return view('livewire.category-component')->layout('components.layouts.admin');
    }

    public function open()
    {
        $this->activeForm = true;
    }
    public function close()
    {
        $this->activeForm = false;
    }

    public function save()
    {
        $validatedDate = $this->validate();

        Category::create($validatedDate);
        $this->name = '';
        $this->mount();
        $this->activeForm = false;
    }

    public function delete(Category $model)
    {
        $model->delete();
        $this->mount(); 
    }

    public function editForm(Category $model)
    {
        $this->editFormCategory = $model->id;
        $this->nameEdit = $model->name;
    }

    public function update(Category $model)
    {

        if (!empty($this->nameEdit)) {
            $model->update([
                'name' => $this->nameEdit,
            ]);
        }
        $this->editFormCategory = false;
        $this->mount();
    }
    public function updateCategoryOrder($categories)
    {
        foreach ($categories as $category) {
            Category::whereId($category['value'])->update(['sort' => $category['order']]);
        }
        $this->mount();
    }

}
