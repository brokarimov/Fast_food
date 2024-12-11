<?php

namespace App\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentComponent extends Component
{
    public $departments, $name, $nameEdit;
    public $activeForm = false;
    public $editFormDepartment = false;

    protected $rules = [
        'name' => 'required|max:255',
    ];
    public function updated($propertyName)
    {   
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->departments = Department::all();
    }
    public function render()
    {
        return view('livewire.department-component')->layout('components.layouts.admin');
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

        Department::create($validatedDate);
        $this->name = '';
        $this->mount();
        $this->activeForm = false;
    }
    public function delete(Department $department)
    {
        $department->delete();
        $this->mount(); 
    }
    public function editForm(Department $department): void
    {
        $this->editFormDepartment = $department->id;
        $this->nameEdit = $department->name;
    }

    public function update(Department $department): void
    {

        if (!empty($this->nameEdit)) {
            $department->update([
                'name' => $this->nameEdit,
            ]);
        }
        $this->editFormDepartment = false;
        $this->mount();
    }
}
