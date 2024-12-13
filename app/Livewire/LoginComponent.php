<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginComponent extends Component
{
    public $email, $password;
    public function submit()
    {
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            if (!Attendance::where('user_id', auth()->user()->id)->where('date', today()->format('Y-m-d'))->exists()) {
                Attendance::create([
                    'employee_id' => auth()->user()->employee->id,
                    'user_id' => auth()->user()->id,
                    'date' => today()->format('Y-m-d'),
                    'start_time' => now(),
                ]);
            }
            if (auth()->check() && auth()->user()->role == 'waiter' || auth()->user()->role == 'chef') {
                return redirect()->intended('/order');
            } else {
                return redirect()->intended('/category');
            }
        }
    }
    public function render()
    {
        return view('livewire.login-component');
    }
    public function logout()
    {
        $user = Attendance::where('user_id', auth()->user()->id)->where('date', today()->format('Y-m-d'))->first();
        if ($user) {
            $startTime = Carbon::parse($user->start_time);
            $endTime = Carbon::parse(now());
            $difTime = $startTime->diffInHours($endTime);
            $user->update([
                'end_time' => now(),
                'time' => $difTime,
            ]);
        }
        Auth::logout();
        return redirect('/login');
    }
}
