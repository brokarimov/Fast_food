<?php

namespace App\Livewire;

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class EmployeeComponent extends Component
{
    public $emplyees, $users, $departments;
    public $user_id, $department_id, $salary_type, $salary, $bonus, $monthly_time, $day_start, $day_end, $daily_time;
    public $user_idEdit, $department_idEdit, $salary_typeEdit, $salaryEdit, $bonusEdit, $monthly_timeEdit, $day_startEdit, $day_endEdit, $daily_timeEdit;
    public $searchName, $searchCategory_id, $searchPrice;
    public $activeForm = false;
    public $editFormEmployee = null;
    public $showEmployee = null;
    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'department_id' => 'required|exists:departments,id',
        'salary_type' => 'required|string',
        'salary' => 'required|numeric',
        'bonus' => 'nullable|numeric',
        'monthly_time' => 'required|integer',
        'day_start' => 'required',
        'day_end' => 'required',
    ];
    public function updated($propertyname)
    {
        $this->validateOnly($propertyname);

    }
    public function mount()
    {
        $this->emplyees = Employee::all();
        $this->users = User::all();
        $this->departments = Department::all();
    }
    public function render()
    {
        return view('livewire.employee-component')->layout('components.layouts.admin');
    }
    public function open()
    {
        $this->activeForm = true;
    }

    public function close()
    {
        $this->reset(['user_id', 'department_id', 'salary_type', 'salary', 'bonus', 'monthly_time', 'day_start', 'day_end', 'daily_time']);
        $this->activeForm = false;
    }
    public function save()
    {

        $validatedData = $this->validate();

        $startTime = Carbon::parse($validatedData['day_start']);
        $endTime = Carbon::parse($validatedData['day_end']);
        $dailyTime = $startTime->diffInHours($endTime);

        $validatedData['daily_time'] = $dailyTime;

        Employee::create($validatedData);

        $this->close();
        $this->mount();
    }
    public function delete(Employee $model)
    {
        $model->delete();
        $this->mount();
    }

    public function editForm(Employee $model)
    {
        $this->editFormEmployee = $model->id;
        $this->user_idEdit = $model->user->id;
        $this->department_idEdit = $model->department->id;
        $this->salary_typeEdit = $model->salary_type;
        $this->salaryEdit = $model->salary;
        $this->bonusEdit = $model->bonus;
        $this->monthly_timeEdit = $model->monthly_time;
        $this->day_startEdit = $model->day_start;
        $this->day_endEdit = $model->day_end;
        $this->mount();

    }

    public function update(Employee $model)
    {
        $startTime = Carbon::parse($this->day_startEdit);
        $endTime = Carbon::parse($this->day_endEdit);
        $dailyTime = $startTime->diffInHours($endTime);

        $this->daily_timeEdit = $dailyTime;

        $model->update([
            'user_id' => $this->user_idEdit,
            'department_id' => $this->department_idEdit,
            'salary_type' => $this->salary_typeEdit,
            'salary' => $this->salaryEdit,
            'bonus' => $this->bonusEdit,
            'monthly_time' => $this->monthly_timeEdit,
            'day_start' => $this->day_startEdit,
            'day_end' => $this->day_endEdit,
            'daily_time' => $this->daily_timeEdit,
        ]);
        
        $this->mount();
        $this->reset(['user_idEdit', 'department_idEdit', 'salary_typeEdit', 'salaryEdit', 'bonusEdit', 'monthly_timeEdit', 'day_startEdit', 'day_endEdit', 'daily_timeEdit']);
        $this->editFormEmployee = null;
    }

    public function show(Employee $model)
    {
        $this->showEmployee = $model;
    }
    public function closeShow()
    {
        $this->showEmployee = null;
        $this->mount();
    }
}
