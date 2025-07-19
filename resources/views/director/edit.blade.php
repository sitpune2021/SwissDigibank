@extends('layout.main')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 30px;
            text-align: center;
            line-height: 30px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(30px);
        }

        .slider .switch-on,
        .slider .switch-off {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slider .switch-on {
            left: 0;
        }

        .slider .switch-off {
            right: 0;
        }
    </style>
    <div class="main-inner">
        <!-- <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="h2">Edit Director</h3>
        </div> -->
            <a href="" class="btn-warning" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-eye text-base md:text-lg" style="font-size: 14px;"></i>
            View Transaction
        </a>
        @if (session('success'))
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> {{ session('success') }}
                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
            </div>
        @endif

        @if (session('error'))
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> {{ session('error') }}
                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
            </div>
        @endif

        <div class="box mb-4 xxxl:mb-6">
            <form action="{{route('edit.director')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf

                <!-- Designation -->
                <div class="flex items-start gap-4">
                    <label for="designation" class="w-48 text-sm font-medium">Designation<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="designation" id="designation"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter designation" value="">
                        @error('designation')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            <div class="flex items-start gap-4">
    <label for="name" class="w-48 text-sm font-medium">Member</label>
    <div class="w-full">
        <input type="text" name="name" id="name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            placeholder="Enter address line 2" value="">
        @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>
</div>


                <div class="flex items-start gap-4">
                    <label for="name" class="w-48 text-sm font-medium">Director Name *<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="name" id="name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter IFSC code" value="">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="din_no" class="w-48 text-sm font-medium">DIN No.</label>
                    <div class="w-full">
                        <input type="text" name="din_no" id="din_no" placeholder="Enter din_no."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('din_no') }}">
                        @error('din_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="appointment_date" class="w-48 text-sm font-medium">Appointment Date :*<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <div
                            class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                            <input name="appointment_date" id="date2" class="border-none" placeholder="Select Date"
                                class="w-full text-sm border px-3 py-2" autocomplete="off" />
                            <i
                                class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                        </div>
                        @error('appointment_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="resignation" class="w-48 text-sm font-medium">Resignation Date :<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <div
                            class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                            <input name="resignation_date" id="date2" class="border-none" placeholder="Select Date"
                                class="w-full text-sm border px-3 py-2" autocomplete="off" />
                            <i
                                class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                        </div>
                        @error('resignation_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ----------------------------------------------------------------------------------------- -->
                <br>
                <br>
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Save Promotor
                    </button>
                    <button class="btn-outline" type="reset"
                        onclick="window.location.href='{{ route(`ManagePromotor`) }}'">
                        Back
                    </button>
                    <button class="btn-outline" type="reset">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    setTimeout(function () {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function (response) {
                $.each(response, function (key, branch) {
                    $('#branchDropdown').append(`<option value="${branch.id}">${branch.branch_name}</option>`);
                });
            },
            error: function () {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function (response) {
                $.each(response, function (index, status) {
                    $('#mariatal_status').append(`<option value="${status.id}">${status.status}</option>`);
                });
            },
            error: function () {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ url('/get-religion-statuses') }}",
            type: 'GET',
            success: function (response) {
                $.each(response, function (index, status) {
                    $('#member_religion').append(`<option value="${status.id}">${status.name}</option>`);
                });
            },
            error: function () {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>