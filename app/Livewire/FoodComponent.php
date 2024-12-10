<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Food;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class FoodComponent extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $price, $category_id, $image;
    public $nameEdit, $priceEdit, $category_idEdit, $imageEdit;
    public $searchName, $searchCategory_id, $searchPrice;
    public $activeForm = false;
    public $editFormFood = null;
    protected $rules = [
        'name' => 'required|string|max:255|min:3',
        'price' => 'required|string|max:500',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|file|mimes:png,jpg,jpeg',
    ];

    protected $paginationTheme = 'bootstrap';
    public function updated($propertyname)
    {
        $this->validateOnly($propertyname);

    }
    public function mount()
    {
        $this->models = Food::orderBy('id', 'desc')->paginate(10);
    }
    public function render()
    {
        $query = Food::with('categories');


        if ($this->searchName) {
            $query->where('name', 'LIKE', "{$this->searchName}%");
        }
        if ($this->searchPrice) {
            $query->where('price', 'LIKE', "{$this->searchPrice}%");
        }
        if ($this->searchCategory_id) {
            $query->where('category_id', $this->searchCategory_id);
        }


        $foods = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.food-component', [
            'models' => $foods,
            'categories' => Category::all(),
        ])->layout('components.layouts.admin');
    }
    public function searchColumps()
    {
        $this->models = Food::where('name', 'LIKE', "{$this->searchName}%")
            ->where('price', 'LIKE', "{$this->searchPrice}%")
            ->where('category_id', 'LIKE', "{$this->searchCategory_id}%")
            ->orderBy('id', 'desc')->paginate(10);
    }

    public function open()
    {
        $this->activeForm = true;
    }

    public function close()
    {
        $this->reset(['name', 'price', 'category_id', 'image']);
        $this->activeForm = false;
    }

    public function save()
    {

        $validateData = $this->validate();

        if ($this->image) {

            $extension = $this->image->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;


            $path = $this->image->storeAs('image_upload', $filename, 'public');


            $validateData['image'] = $path;
        }

        // dd($validateData);
        Food::create($validateData);

        $this->close();
    }


    public function delete(Food $model)
    {
        $model->delete();
    }

    public function editForm(Food $model)
    {
        $this->editFormFood = $model->id;
        $this->nameEdit = $model->name;
        $this->priceEdit = $model->price;
        $this->category_idEdit = $model->category_id;
    }

    public function update(Food $model)
    {
        if ($this->imageEdit) {

            $extension = $this->imageEdit->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;


            $path = $this->imageEdit->storeAs('image_upload', $filename, 'public');


            $this->imageEdit = $path;
        }
        $model->update([
            'name' => $this->nameEdit,
            'price' => $this->priceEdit,
            'category_id' => $this->category_idEdit,
            'image' => $this->imageEdit,
        ]);

        $this->reset(['nameEdit', 'priceEdit', 'imageEdit', 'category_idEdit', 'editFormFood']);
    }

   
}
