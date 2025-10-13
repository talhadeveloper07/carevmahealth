@extends('employee.layouts.app')
@section('employee_content')

    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Top Section -->
        <div class='row d-flex justify-content-center mt-5 align-items-center mb-5'>

            <div class="col-md-10">
                <div class="custom-card-body-2">
                    <div class="d-flex align-items-start row">
                        <div class="col-4">
                            <h5 class="custom-page-title mb-0 text-white">Welcome, {{ $employee->first_name }}</h5>
                            <div class="text-nowrap">

                                @if(!$hasShiftToday)
                                    <p class="mb-2" style="font-size:12px;">You have no shift today</p>
                                @elseif(!$attendanceToday || !$attendanceToday->clock_in)
                                    <p class="mb-2" style="font-size:12px;">You can start your shift by clocking in</p>
                                @elseif($attendanceToday && $attendanceToday->clock_in && !$attendanceToday->clock_out)
                                    <p class="mb-2" style="font-size:12px;">Your shift is in progress</p>
                                @elseif($attendanceToday && $attendanceToday->clock_out)
                                    <p class="mb-2" style="font-size:12px;">You closed your shift</p>
                                @endif
                            </div>


                            <!-- Buttons -->
                            <div class="d-flex gap-3 justify-content-start mt-5">
                                @if(!$attendanceToday || !$attendanceToday->clock_in)
                                    <!-- Clock In -->
                                    <form method="POST" action="{{ route('attendance.clockIn') }}">
                                        @csrf
                                        <button class="btn cstm-btn-link text-white">Clock In</button>
                                    </form>
                                @elseif(!$attendanceToday->clock_out)
                                    <!-- Clock Out -->
                                    <form id="clockOutForm" method="POST" action="{{ route('attendance.clockOut') }}">
                                        @csrf
                                        <button type="button" class="btn cstm-btn-link text-white" data-bs-toggle="modal"
                                            data-bs-target="#clockOutModal">
                                            Clock Out
                                        </button>
                                    </form>
                                @elseif($attendanceToday && $attendanceToday->clock_out)
                                    <p class="worked-today">⏱ Worked Today:
                                        {{ floor($attendanceToday->total_minutes / 60) }}h
                                        {{ $attendanceToday->total_minutes % 60 }}m
                                    </p>

                                    @if($attendanceToday->overtime > 0)
                                        <p class="text-danger">🔥 Overtime:
                                            {{ floor($attendanceToday->overtime / 60) }}h
                                            {{ $attendanceToday->overtime % 60 }}m
                                        </p>
                                    @endif
                                @endif

                                <!-- Break Buttons -->
                                @if($attendanceToday && $attendanceToday->clock_in && !$attendanceToday->clock_out)
                                    @if(!$attendanceToday->breaks->whereNull('end_time')->count())
                                        <!-- Start Break -->
                                        <button class="btn options-btn" style="color:white;" data-bs-toggle="modal"
                                            data-bs-target="#breakModal">Break</button>
                                    @else
                                        <!-- End Break -->
                                        <form method="POST" action="{{ route('attendance.endBreak') }}">
                                            @csrf
                                            <button class="btn options-btn" style="color:white;">End Break</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if($attendanceToday && $attendanceToday->clock_in && !$attendanceToday->clock_out)
                                <div class="work-div">
                                    <h2 class="text-white" id="workTimer">00:00:00</h2>
                                </div>

                                <div id="breakSection" style="display:none;" class="mt-4">
                                    <h2 class="text-danger mb-0" style="font-size:12px;" id="breakTimer">00:00:00</h2>
                                </div>
                            @endif

                        </div>

                        <div class="col-4 text-end text-sm-left">
                            <div class="pb-0 px-0 px-md-4">
                                @if(auth()->user()->employee->gender == 'male')
                                    <img src="/assets/img/illustrations/card-advance-sale.png" height="140" alt="work" />
                                @else
                                    <img src="/assets/img/illustrations/girl-with-laptop.png" height="140" alt="work" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Break Modal -->
            <div class="modal fade" id="breakModal" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('attendance.startBreak') }}" class="modal-content">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Break Notes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="notes" class="form-control" placeholder="Reason for break..."
                                required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Start Break</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Clockout Modal -->
            <div class="modal fade" id="clockOutModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Clock Out</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">Are you sure you want to clock out?</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn btn-danger"
                                onclick="document.getElementById('clockOutForm').submit();">Yes, Clock Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let clockIn = @json($attendanceToday?->clock_in);
                let clockOut = @json($attendanceToday?->clock_out);
                let activeBreak = @json($attendanceToday?->breaks->whereNull('end_time')->first());
                let allBreaks = @json($attendanceToday?->breaks);

                let workTimerEl = document.getElementById("workTimer");
                let breakTimerEl = document.getElementById("breakTimer");
                let breakSection = document.getElementById("breakSection");

                let workInterval, breakInterval;

                function formatTime(seconds) {
                    let h = String(Math.floor(seconds / 3600)).padStart(2, "0");
                    let m = String(Math.floor((seconds % 3600) / 60)).padStart(2, "0");
                    let s = String(seconds % 60).padStart(2, "0");
                    return `${h}:${m}:${s}`;
                }

                // Calculate total break seconds (finished ones)
                function calculateBreakSeconds(breaks) {
                    let total = 0;
                    breaks.forEach(b => {
                        if (b.end_time) {
                            total += (new Date(b.end_time) - new Date(b.start_time)) / 1000;
                        }
                    });
                    return total;
                }

                function startWorkTimer() {
                    clearInterval(workInterval);
                    workInterval = setInterval(() => {
                        let now = new Date();
                        let diff = (new Date(now) - new Date(clockIn)) / 1000;

                        // subtract total finished breaks
                        diff -= calculateBreakSeconds(allBreaks);

                        // if currently on break, subtract active break time too
                        if (activeBreak) {
                            diff -= (new Date() - new Date(activeBreak.start_time)) / 1000;
                        }

                        if (diff < 0) diff = 0;
                        workTimerEl.textContent = formatTime(Math.floor(diff));
                    }, 1000);
                }

                function startBreakTimer() {
                    if (!activeBreak) return;
                    breakSection.style.display = "block";
                    clearInterval(breakInterval);

                    breakInterval = setInterval(() => {
                        let diff = (new Date() - new Date(activeBreak.start_time)) / 1000;
                        breakTimerEl.textContent = formatTime(Math.floor(diff));
                    }, 1000);
                }

                // ---- Init ----
                if (clockIn && !clockOut) {
                    if (activeBreak) {
                        // 🟡 Only run break timer when on break
                        startBreakTimer();
                    } else {
                        // 🟢 Run work timer only when not on break
                        startWorkTimer();
                    }
                }

            });
        </script>

@endsection