@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            Attendance Records -{{ $selectedDate }}
        </h3>
    </div>
    <div class="box flex items-center justify-center gap-5">
        <label for="" class="font-semibold">
            Attendance Date
        </label>
        <input type="text" id="attendanceDate" name="date"
            class="datepicker-field w-64 text-sm bg-secondary/5 border rounded-10 px-3 py-2"
            value="{{ $selectedDate }}">

    </div>
    <div class="pb-4 overflow-x-auto box mt-4 lg:pb-6">
        <table class="w-full whitespace-nowrap select-all-table" id="">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3">
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                        <div class="flex items-center gap-1 uppercase">
                            EMPLOYEE NAME
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            DESIGNATION
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            IN TIME
                        </div>
                    </th>


                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            OUT TIME
                        </div>
                    </th>

                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            WORKING TIME
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            STATUS
                        </div>
                    </th>


                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            CALENDAR
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            CREATED BY
                        </div>
                    </th>
                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                        <div class="flex items-center gap-1 uppercase">
                            ACTIONS
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                @php
                $attendance = $attendances[$employee->id] ?? null;

                $inHour = $attendance?->in_time ? \Carbon\Carbon::parse($attendance->in_time)->format('H') : '';
                $inMinute = $attendance?->in_time ? \Carbon\Carbon::parse($attendance->in_time)->format('i') : '';

                $outHour = $attendance?->out_time ? \Carbon\Carbon::parse($attendance->out_time)->format('H') : '';
                $outMinute = $attendance?->out_time ? \Carbon\Carbon::parse($attendance->out_time)->format('i') : '';

                $status = $attendance?->status ?? '';
                @endphp

                <tr class="border-b">
                    <form action="{{ route('attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <input type="hidden" name="attendance_date" value="{{ $selectedDate }}">

                        <td class="px-6">{{ $employee->name }}</td>
                        <td class="px-6">{{ $employee->designation }}</td>

                        {{-- In Time --}}
                        @php
                        if ($attendance && $attendance->in_time) {
                        // Existing attendance → use stored time
                        $inHour = \Carbon\Carbon::parse($attendance->in_time)->format('H');
                        $inMinute = \Carbon\Carbon::parse($attendance->in_time)->format('i');
                        } else {
                        // No attendance → use current time
                        $inHour = now()->format('H');
                        $inMinute = now()->format('i');
                        }
                        @endphp
                        <td class="px-4">
                            <select name="in_hour"
                                class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @for ($h = 8; $h <= 20; $h++) <option value="{{ str_pad($h,2,'0',STR_PAD_LEFT) }}"
                                    @if($inHour==str_pad($h,2,'0',STR_PAD_LEFT)) selected @endif>
                                    {{ str_pad($h,2,'0',STR_PAD_LEFT) }}
                                    </option>
                                    @endfor
                            </select> :
                            <select name="in_minute"
                                class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @for ($m = 0; $m <= 59; $m++) <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}"
                                    @if($inMinute==str_pad($m,2,'0',STR_PAD_LEFT)) selected @endif>
                                    {{ str_pad($m,2,'0',STR_PAD_LEFT) }}
                                    </option>
                                    @endfor
                            </select>
                        </td>

                        {{-- Out Time --}}
                        @php
                        if ($attendance && $attendance->out_time) {
                        // Existing attendance → stored out time
                        $outHour = \Carbon\Carbon::parse($attendance->out_time)->format('H');
                        $outMinute = \Carbon\Carbon::parse($attendance->out_time)->format('i');
                        } else {
                        // No attendance → current time
                        $outHour = now()->format('H');
                        $outMinute = now()->format('i');
                        }
                        @endphp
                        <td class="px-4">
                            <select name="out_hour"
                                class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @for ($h = 8; $h <= 20; $h++) <option value="{{ str_pad($h,2,'0',STR_PAD_LEFT) }}"
                                    @if($outHour==str_pad($h,2,'0',STR_PAD_LEFT)) selected @endif>
                                    {{ str_pad($h,2,'0',STR_PAD_LEFT) }}
                                    </option>
                                    @endfor
                            </select> :
                            <select name="out_minute"
                                class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @for ($m = 0; $m <= 59; $m++) <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}"
                                    @if($outMinute==str_pad($m,2,'0',STR_PAD_LEFT)) selected @endif>
                                    {{ str_pad($m,2,'0',STR_PAD_LEFT) }}
                                    </option>
                                    @endfor
                            </select>
                        </td>

                        {{-- WORKING TIME --}}
                        @php
                        $attendance = $attendances[$employee->id] ?? null;

                        $workingMinutes = $attendance?->working_minutes ?? 0;

                        $hours = floor($workingMinutes / 60);
                        $minutes = $workingMinutes % 60;

                        $workingTimeFormatted = $workingMinutes
                        ? sprintf('%02d H :%02d M', $hours, $minutes)
                        : '';
                        @endphp
                        <td class="px-4">
                            {{ $workingTimeFormatted ?: '-' }}
                        </td>



                        {{-- Status --}}
                        <td class="px-4">
                            <select name="status"
                                class=" text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <option value="">Select Status</option>
                                @foreach(['Absent','Full Day','Half Day','Leave','Holiday'] as $s)
                                <option value="{{ $s }}" @if($status==$s) selected @endif>{{ $s }}</option>
                                @endforeach
                            </select>

                        </td>
                        {{-- CALENDAR --}}
                        <td class="px-6">
                            <a  href="{{ route('hr-management.attendance.calender',  base64_encode($employee->id)) }}"class="btn-primary p-1">
                                <i class="las la-calendar"></i>
                            </a>
                        </td>
                        {{-- CREATED BY --}}
                        <td class="px-4">
                            @php
                            $attendance = $attendances[$employee->id] ?? null;
                            @endphp
                            {{ $attendance?->creator?->fname ?? '-' }} {{ $attendance?->creator?->lname }}
                        </td>
                        {{--Action--}}
                        <td class="px-4 py-3"> <button type="submit"
                                class="btn-primary uppercase rounded-10 px-4 py-2 text-sm">Save</button></td>
                        <td>

                        </td>
                    </form>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>


    @if ($errors->has('status'))
    <div class="fixed inset-0 flex items-center justify-center bg-opacity-40 z-50">
        <div class="bg-white rounded-xl shadow-lg w-64 max-w-sm p-6 relative">

            <!-- ❌ Remove / Close button -->
            <div class="text-end ">
                <button onclick="this.closest('.fixed').remove()"
                    class="absolute top-2  text-error  rounded-10 right-2 text-2xl font-bold">
                    &times;
                </button>
            </div>

            <h2 class="text-lg uppercase font-semibold text-red-600 mb-2">
                {{ $errors->first('status') }}
            </h2>

            <p class="text-gray-700 mb-4">
                {{-- {{ $errors->first('status') }} --}}
            </p>

            <div class="text-right">
                <button onclick="this.closest('.fixed').remove()"
                    class="px-6 py-1 uppercase btn-primary rounded-lg transition">
                    OK
                </button>
            </div>

        </div>
    </div>
    @endif



</div>
</div>
<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
        const picker = new Datepicker(dateInput, {
            autohide: true,
            format: 'dd-mm-yyyy',
            maxDate: new Date(),
        });
 
        if (!dateInput.value) {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
            dateInput.value = formattedDate;
        }
 
        const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
        if (calendarIcon) {
            calendarIcon.addEventListener('click', () => picker.show());
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<script>
    document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById('attendanceDate');

    const picker = new Datepicker(dateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxDate: new Date(),
    });

    // Reload page when date changes
    dateInput.addEventListener('changeDate', function (e) {
        const selectedDate = e.target.value;
        if(selectedDate) {
            // Reload page with GET parameter
            const url = new URL(window.location.href);
            url.searchParams.set('date', selectedDate);
            window.location.href = url.toString();
        }
    });
});
</script>


@endsection