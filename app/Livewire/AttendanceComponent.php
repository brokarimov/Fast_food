<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceComponent extends Component
{
    public $employees, $attendances;
    public $date;
    public $dates = [];
    public $start_time, $end_time;

    public function mount()
    {
        $this->employees = Employee::all();
        $this->attendances = Attendance::all();
        $this->getDate();
    }
    public function render()
    {
        return view('livewire.attendance-component')->layout('components.layouts.admin');
    }
    public function getDate()
    {
        if (!$this->date) {
            $startOfMonth = Carbon::parse(today())->startOfMonth();
            $endOfMonth = Carbon::parse(today())->endOfMonth();
        }

        $startOfMonth = Carbon::parse($this->date)->startOfMonth();
        $endOfMonth = Carbon::parse($this->date)->endOfMonth();

        $this->dates = [];
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $this->dates[] = $date->format('Y-m-d');
        }

    }
    public function update(int $employeeID, $attendanceId)
    {
        $user = Attendance::where('employee_id', $employeeID)->where('date', $attendanceId)->first();
        
        if (!empty($this->start_time) && !empty($this->end_time)) {
            $user->update([
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
            ]);
        } elseif (!empty($this->start_time)) {
            $user->update([
                'start_time' => $this->start_time,

            ]);
        } elseif (!empty($this->end_time)) {
            $user->update([
                'start_time' => $this->start_time,
            ]);
        }
        $this->mount();
        $this->reset('start_time', 'end_time');
    }

}
