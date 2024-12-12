<div>
    <h1>Attendance</h1>
    <input type="date" class="form-control" wire:model="date" wire:change="getDate">
    <h3 class="mt-2 text-primary">
        {{ $date ? \Carbon\Carbon::parse($date)->isoFormat('MMMM YYYY') : \Carbon\Carbon::today()->isoFormat('MMMM YYYY') }}
    </h3>
    <div class="table-responsive">
        <table class="table table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    @foreach ($dates as $date)
                        <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->user->name }}</td>
                                @foreach ($dates as $date)
                                                <td>
                                                    @php
                                                        $attendance = $attendances->where('employee_id', $employee->id)->where('date', $date)->first();
                                                    @endphp
                                                    @if ($attendance)
                                                                    @php
                                                                        $tooltipContent = "Start: " . e($attendance->start_time) . " | End: " . e($attendance->end_time) . " | Work hours: " . e($attendance->time);
                                                                    @endphp
                                                                    <button type="button"
                                                                        class="{{$attendance->time < $employee->daily_time ? 'btn btn-danger' : 'btn btn-success'}}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#attendanceModal-{{ $employee->id }}-{{ \Carbon\Carbon::parse($date)->format('Ymd') }}"
                                                                        data-employee-id="{{ $employee->id }}" data-date="{{ $date }}"
                                                                        data-start-time="{{ $attendance->start_time }}" data-end-time="{{ $attendance->end_time }}"
                                                                        data-work-hours="{{ $attendance->time }}" data-bs-toggle="tooltip"
                                                                        title="Start: {{ $attendance->start_time }} | End: {{ $attendance->end_time }} | Work Hours: {{ $attendance->time }}">
                                                                        {{ $attendance->time - $employee->daily_time }}
                                                                    </button>

                                                    @endif
                                                </td>
                                @endforeach
                            </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @foreach ($employees as $employee)
        @foreach ($dates as $date)
            @php
                $attendance = $attendances->where('employee_id', $employee->id)->where('date', $date)->first();
            @endphp
            @if ($attendance)
                <div class="modal fade" id="attendanceModal-{{ $employee->id }}-{{ \Carbon\Carbon::parse($date)->format('Ymd') }}"
                    tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="attendanceModalLabel">Attendance Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Employee ID:</strong> <span id="modal-employee-id"></span></p>
                                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                                <p><strong>Start Time:</strong> <span id="modal-start-time"></span></p>
                                <p><strong>End Time:</strong> <span id="modal-end-time"></span></p>
                                <p><strong>Work Hours:</strong> <span id="modal-work-hours"></span></p>
                                <label for="">Start work</label>
                                <input type="time" class="form-control" wire:model="start_time">
                                <label for="">End work</label>
                                <input type="time" class="form-control" wire:model="end_time">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                                    wire:click="update({{ $employee->id }}, '{{ $attendance->date }}')">Update</button>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });


        const modal = document.querySelectorAll('.modal');
        modal.forEach(function (modalEl) {
            modalEl.addEventListener('show.bs.modal', function (event) {
                const triggerElement = event.relatedTarget;
                const employeeId = triggerElement.getAttribute('data-employee-id');
                const date = triggerElement.getAttribute('data-date');
                const startTime = triggerElement.getAttribute('data-start-time');
                const endTime = triggerElement.getAttribute('data-end-time');
                const workHours = triggerElement.getAttribute('data-work-hours');


                modalEl.querySelector('#modal-employee-id').textContent = employeeId;
                modalEl.querySelector('#modal-date').textContent = date;
                modalEl.querySelector('#modal-start-time').textContent = startTime;
                modalEl.querySelector('#modal-end-time').textContent = endTime;
                modalEl.querySelector('#modal-work-hours').textContent = workHours;
            });
        });
    });
</script>