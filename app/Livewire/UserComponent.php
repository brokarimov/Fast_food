<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserComponent extends Component
{
    use WithFileUploads;
    public $users, $name, $email, $password, $role, $image;
    public $nameEdit, $emailEdit, $roleEdit, $imageEdit;
    public $activeForm = false;
    public $editFormUser = false;
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|string|min:8|max:255',
        'role' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg', 
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function mount()
    {
        $this->users = User::all();
    }
    public function render()
    {
        return view('livewire.user-component')->layout('components.layouts.admin');
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
        // dd($validatedDate);
        if ($this->image) {

            $extension = $this->image->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;


            $path = $this->image->storeAs('image_upload', $filename, 'public');


            $validatedDate['image'] = $path;
        }
        User::create($validatedDate);
        $this->name = '';
        $this->mount();
        $this->activeForm = false;
    }
    public function delete(User $user)
    {
        $user->delete();
        $this->mount();
    }
    public function editForm(User $user)
    {
        $this->editFormUser= $user->id;
        $this->nameEdit = $user->name;
        $this->emailEdit = $user->email;
        $this->roleEdit = $user->role;
    }
    public function update(User $user)
    {
        if ($this->imageEdit) {

            $extension = $this->imageEdit->getClientOriginalExtension();
            $filename = date('Y-m-d') . '_' . time() . '.' . $extension;


            $path = $this->imageEdit->storeAs('image_upload', $filename, 'public');


            $this->imageEdit = $path;
        }
        $user->update([
            'name' => $this->nameEdit,
            'email' => $this->emailEdit,
            'role' => $this->roleEdit,
            'image' => $this->imageEdit,
        ]);
        $this->mount();
        $this->reset(['nameEdit', 'emailEdit', 'roleEdit', 'imageEdit', 'editFormUser']);
    }
}
