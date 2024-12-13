<style>
    .zebra-lines {
        background: repeating-linear-gradient(45deg, #4d4b4b, #4d4b4b 5px, #ffffff 5px, #ffffff 10px);
    }
</style>

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
                    @php
                    $attendance = $attendances->where('employee_id', $employee->id)->where('date', $date)->first();
                    @endphp
                    <td class="{{ $attendance && $attendance->start_time > $employee->day_start ? 'zebra-lines' : '' }}"
                        onclick="this.querySelector('button').click()">
                        @if ($attendance)
                        @php
                        $tooltipContent = "Start: " . e($attendance->start_time) . " | End: " . e($attendance->end_time) . " | Work hours: " . e($attendance->time);
                        $countOfWorkedHours = $attendance->time - $employee->daily_time;
                        @endphp
                        <button type="button"
                            class="{{ $attendance->time < $employee->daily_time ? 'btn btn-danger' : 'btn btn-success' }}"
                            data-bs-toggle="modal"
                            data-bs-target="#attendanceModal-{{ $employee->id }}-{{ \Carbon\Carbon::parse($date)->format('Ymd') }}"
                            title="{{ $tooltipContent }}">
                            {!! $countOfWorkedHours == 0
                            ? '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                            </svg>'
                            : round($countOfWorkedHours) !!}
                        </button>
                        @else
                        <button type="button"
                            style="visibility: hidden; position: absolute;"
                            class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#attendanceModal-{{ $employee->id }}-{{ \Carbon\Carbon::parse($date)->format('Ymd') }}"
                            title="No attendance record available">
                            <span></span>
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
                    <p><strong>Employee ID:</strong> <span>{{ $employee->id }}</span></p>
                    <p><strong>Date:</strong> <span>{{ $date }}</span></p>
                    <div class="d-flex">
                        <p><strong>Work starts:</strong> <span>{{ \Carbon\Carbon::parse($employee->day_start)->format('H:i') }}</span></p>
                        <p class="mx-2"><strong>Work ends:</strong> <span>{{ \Carbon\Carbon::parse($employee->day_end)->format('H:i') }}</span></p>
                    </div>

                    @if ($attendance && \Carbon\Carbon::parse($attendance->start_time)->gt(\Carbon\Carbon::parse($employee->day_start)))
                    @php
                    $startTime = \Carbon\Carbon::parse($attendance->start_time);
                    $dayStart = \Carbon\Carbon::parse($employee->day_start);
                    $minutesLate = $startTime->diffInMinutes($dayStart);
                    @endphp
                    <p><strong>Late:</strong> <span>{{ round($minutesLate) }} minutes</span></p>
                    @endif
                    <div class="d-flex">
                        <p><strong>Started work:</strong> <span>{{ \Carbon\Carbon::parse($attendance->start_time)->format('H:i') }}</span></p>
                        <p class="mx-2"><strong>Ended work:</strong> <span>{{ \Carbon\Carbon::parse($attendance->end_time)->format('H:i') }}</span></p>
                    </div>
                    <p><strong>Agreed Work Hours:</strong> <span>{{ $employee->daily_time }}</span></p>
                    @php
                    $hours = floor($attendance->time);
                    $minutes = round(($attendance->time - $hours) * 60);
                    $timeFormatted = sprintf('%02d:%02d', $hours, $minutes);
                    @endphp
                    <p><strong>Work Hours:</strong> <span>{{ $timeFormatted }}</span></p>
                    <label for="start_time">Start work</label>
                    <input type="time" class="form-control" wire:model="start_time">
                    <label for="end_time">End work</label>
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
    @else
    <div class="modal fade" id="attendanceModal-{{ $employee->id }}-{{ \Carbon\Carbon::parse($date)->format('Ymd') }}"
        tabindex="-1" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Employee ID:</strong> <span>{{ $employee->id }}</span></p>
                    <p><strong>Date:</strong> <span>{{ $date }}</span></p>
                    <div class="d-flex">
                        <p><strong>Work starts:</strong> <span>{{ \Carbon\Carbon::parse($employee->day_start)->format('H:i') }}</span></p>
                        <p class="mx-2"><strong>Work ends:</strong> <span>{{ \Carbon\Carbon::parse($employee->day_end)->format('H:i') }}</span></p>
                    </div>

                    <div class="d-flex">
                        <p><strong>Started work:</strong> <span></span></p>
                        <p class="mx-2"><strong>Ended work:</strong> <span></span></p>
                    </div>
                    <p><strong>Agreed Work Hours:</strong> <span>{{ $employee->daily_time }}</span></p>

                    <p><strong>Work Hours:</strong> <span></span></p>
                    <label for="start_time">Start work</label>
                    <input type="time" class="form-control" wire:model="start_time">
                    <label for="end_time">End work</label>
                    <input type="time" class="form-control" wire:model="end_time">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                        wire:click="attendaceCreate({{ $employee->id }}, '{{ $date }}')">Update</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>