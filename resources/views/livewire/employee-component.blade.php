<div>
    <h1>Employee</h1>
    @if ($showEmployee == null)
        @if ($editFormEmployee == null)
            <button type="button" class="btn btn-outline-primary" wire:click="{{$activeForm ? 'close' : 'open'}}">
                {{$activeForm ? 'Close' : 'Create'}}
            </button>
            @if ($activeForm)
                <form wire:submit.prevent="save">
                    <div class="row mt-2">
                        <div class="col-4">
                            <label for="">Name</label>
                            <select class="form-control" wire:model="user_id">
                                <option value="">Select user name</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Department</label>
                            <select class="form-control" wire:model="department_id">
                                <option value="">Select department</option>
                                @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Salary type</label>
                            <select class="form-control" wire:model="salary_type">
                                <option value="">Select salary type</option>
                                <option value="fixed">Fixed</option>
                                <option value="hourly">Hourly</option>
                            </select>
                            @error('salary_type')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Salary amount</label>
                            <input type="text" wire:model.blur="salary" class="form-control" placeholder="Salary amount">
                            @error('salary')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Bonus</label>
                            <input type="text" wire:model.blur="bonus" class="form-control" placeholder="Bonus">
                            @error('bonus')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Monthly time</label>
                            <input type="text" wire:model.blur="monthly_time" class="form-control" placeholder="Monthly time">
                            @error('monthly_time')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-2">Create</button>
                        </div>
                        <div class="col-4">
                            <label for="">Daily start time</label><br>
                            <input type="time" wire:model.blur="day_start" class="form-control">
                            @error('day_start')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                            <label for="">Daily end time</label><br>
                            <input type="time" wire:model.blur="day_end" class="form-control">
                            @error('day_end')
                                <span class="text-danger">{{$message}}</span><br>
                            @enderror
                        </div>
                    </div>
                </form>
            @endif
            @if (!$activeForm)
                @if ($editFormEmployee == null)
                    <table class="table table-striped table-bordered mt-2">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Salary</th>
                                <th>Image</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emplyees as $emplyee)
                                <tr>
                                    <td>{{$emplyee->id}}</td>
                                    <td>
                                        {{$emplyee->user->name}}
                                    </td>
                                    <td>
                                        {{$emplyee->department->name}}
                                    </td>
                                    <td>
                                        ${{$emplyee->salary}}
                                    </td>
                                    <td><img src="{{ asset('storage/' . $emplyee->user->image) }}" alt="" width="100px">
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <button class="btn btn-primary" wire:click="show({{$emplyee->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                    <path
                                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-danger" wire:click="delete({{$emplyee->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-warning" wire:click="editForm({{$emplyee->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-pen" viewBox="0 0 16 16">
                                                    <path
                                                        d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        @endif

        @if ($editFormEmployee)
            <form wire:submit.prevent="update({{$editFormEmployee}})">
                <div class="row mt-2">
                    <div class="col-4">
                        <label for="">Name</label>
                        <select class="form-control" wire:model="user_idEdit" value="{{$user_idEdit}}">
                            <option value="">Select user name</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>

                        <label for="">Department</label>
                        <select class="form-control" wire:model="department_idEdit" value="{{$department_idEdit}}">
                            <option value="">Select department</option>
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>

                        <label for="">Salary type</label>
                        <select class="form-control" wire:model="salary_typeEdit" value="{{$salary_typeEdit}}">
                            <option value="">Select salary type</option>
                            <option value="fixed">Fixed</option>
                            <option value="hourly">Hourly</option>
                        </select>

                        <label for="">Salary amount</label>
                        <input type="text" wire:model.blur="salaryEdit" class="form-control" placeholder="Salary amount"
                            value="{{$salaryEdit}}">

                        <label for="">Bonus</label>
                        <input type="text" wire:model.blur="bonusEdit" class="form-control" placeholder="Bonus"
                            value="{{$bonusEdit}}">

                        <label for="">Monthly time</label>
                        <input type="text" wire:model.blur="monthly_timeEdit" class="form-control" placeholder="Monthly time"
                            value="{{$monthly_timeEdit}}">

                        <button type="update" class="btn btn-primary mt-2">Update</button>
                    </div>
                    <div class="col-4">
                        <label for="">Daily start time</label><br>
                        <input type="time" wire:model.blur="day_startEdit" class="form-control" value="{{$day_startEdit}}">

                        <label for="">Daily end time</label><br>
                        <input type="time" wire:model.blur="day_endEdit" class="form-control" value="{{$day_endEdit}}">

                    </div>
                </div>
            </form>
        @endif
    @else
        <button type="button" class="btn btn-outline-primary" wire:click="closeShow">
            Close
        </button>
        <div class="row">
            <div class="col-6">
                <table class="table table-bordered table-striped mt-2" style="border: 2px solid black;">
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Id</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->id}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Name</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->user->name}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Department</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->department->name}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Salary type</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->salary_type}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Salary</label></td>
                        <td style="border: 2px solid black;">${{$showEmployee->salary}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Bonus</label></td>
                        <td style="border: 2px solid black;">${{$showEmployee->bonus}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Monthly time</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->monthly_time}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Start work</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->day_start}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">End work</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->day_end}}</td>

                    </tr>
                    <tr style="border: 2px solid black;">
                        <td style="border: 2px solid black;"><label for="">Daily work hours</label></td>
                        <td style="border: 2px solid black;">{{$showEmployee->daily_time}}</td>

                    </tr>
                </table>
            </div>
        </div>



    @endif



</div>