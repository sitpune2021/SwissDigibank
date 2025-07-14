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
        <a href="" class="btn-warning" style="padding: 4px 8px; font-size: 12px;">
            <i class="las la-eye text-base md:text-lg" style="font-size: 14px;"></i>
            View Member
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
            <form action="{{route('member.show')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                <!-- -------------------------------------------------------------------------------------- -->
                <div class="flex items-start gap-4">
                    <label for="membership" class="w-48 text-sm font-medium">Membership Type:<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="membership" id="membership"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Membership Type" value="{{ old('membership') }}">
                        @error('membership')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ------------------------------------------------------------------------------------->
                <div class="flex items-start gap-4">
                    <label for="create" class="w-48 text-sm font-medium">Create on <span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="create" id="create"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter create on" value="{{ old('create') }}">
                        @error('create')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-------------------------------------------------------------------------->
                <div class="flex items-start gap-4">
                    <label for="create" class="w-48 text-sm font-medium">Created by:<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="create" id="create"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter create by" value="{{ old('create') }}">
                        @error('create')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ------------------------------------------------------- -->
                <div class="flex items-start gap-4">
                    <label for="member" class="w-48 text-sm font-medium">Status<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="member" id="member"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Status name" value="{{ old('member') }}">
                        @error('member')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!------------------------------------------------------------------------------------- -->

                <div class="flex items-start gap-4">
                    <label for="branch" class="w-48 text-sm font-medium">Branch:</label>
                    <span class="text-red-500">*</span>

                    <div class="w-full">
                        <input type="text" name="branch" id="branch"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter branch name" value="">
                        @error('branch')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ------------------------------------------------------------------------------------------------ -->

                <div class="flex items-start gap-4">
                    <label for="Advisor/ Staff" class="w-48 text-sm font-medium">Advisor/ Staff:<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="Advisor/ Staff" id="Advisor/ Staff"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Advisor/ Staff" value="{{ old('Advisor/ Staff') }}">
                        @error('Advisor/ Staff')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ------------------------------------------------------------------------------------------------ -->
                <div class="flex items-start gap-4">
                    <label for="Old Member No" class="w-48 text-sm font-medium">Old Member No :<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="Old Member No" id="Old Member No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Old Member No" value="">
                        @error('Old Member No')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <!-- ------------------------------------------------------------------------------------------------ -->
                <!-- Enrollment Date -->
                <div class="flex items-start gap-4">
                    <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="enrollment_date" id="enrollment_date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('enrollment_date') }}">
                        @error('enrollment_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Name -->
                <div class="flex items-start gap-4">
                    <label for="name" class="w-48 text-sm font-medium">Name<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="name" id="name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter full name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- DOB -->
                <div class="flex items-start gap-4">
                    <label for="dob" class="w-48 text-sm font-medium">DOB<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="dob" id="dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('dob') }}">
                        @error('dob')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Age -->
                <div class="flex items-start gap-4">
                    <label for="age" class="w-48 text-sm font-medium">Age<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="number" name="age" id="age"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter age" value="{{ old('age') }}">
                        @error('age')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Senior Citizen -->
                <div class="flex items-start gap-4">
                    <label for="senior_citizen" class="w-48 text-sm font-medium">Senior Citizen<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="senior_citizen" id="senior_citizen"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('senior_citizen') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('senior_citizen') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('senior_citizen')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Gender -->
                <div class="flex items-start gap-4">
                    <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="gender" id="gender"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Folio No. -->
                <div class="flex items-start gap-4">
                    <label for="folio_no" class="w-48 text-sm font-medium">Folio No.<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="folio_no" id="folio_no"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Folio Number" value="{{ old('folio_no') }}">
                        @error('folio_no')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Father Name -->
                <div class="flex items-start gap-4">
                    <label for="father_name" class="w-48 text-sm font-medium">Father Name</label>
                    <div class="w-full">
                        <input type="text" name="father_name" id="father_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Father's Name" value="{{ old('father_name') }}">
                    </div>
                </div>

                <!-- Mother Name -->
                <div class="flex items-start gap-4">
                    <label for="mother_name" class="w-48 text-sm font-medium">Mother Name</label>
                    <div class="w-full">
                        <input type="text" name="mother_name" id="mother_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Mother's Name" value="{{ old('mother_name') }}">
                    </div>
                </div>

                <!-- Marital Status -->
                <div class="flex items-start gap-4">
                    <label for="marital_status" class="w-48 text-sm font-medium">Marital Status</label>
                    <div class="w-full">
                        <select name="marital_status" id="marital_status"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married
                            </option>
                            <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced
                            </option>
                            <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Religion -->
                <div class="flex items-start gap-4">
                    <label for="religion" class="w-48 text-sm font-medium">Religion</label>
                    <div class="w-full">
                        <input type="text" name="religion" id="religion"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Religion" value="{{ old('religion') }}">
                    </div>
                </div>

                <!-- Qualification -->
                <div class="flex items-start gap-4">
                    <label for="qualification" class="w-48 text-sm font-medium">Qualification<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="qualification" id="qualification"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Qualification" value="{{ old('qualification') }}">
                        @error('qualification')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Husband/Wife Name -->
                <div class="flex items-start gap-4">
                    <label for="spouse_name" class="w-48 text-sm font-medium">Husband/Wife Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="spouse_name" id="spouse_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Spouse Name" value="{{ old('spouse_name') }}">
                        @error('spouse_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Husband/Wife D.O.B -->
                <div class="flex items-start gap-4">
                    <label for="spouse_dob" class="w-48 text-sm font-medium">Husband/Wife D.O.B<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="spouse_dob" id="spouse_dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('spouse_dob') }}">
                        @error('spouse_dob')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Occupation -->
                <div class="flex items-start gap-4">
                    <label for="occupation" class="w-48 text-sm font-medium">Occupation<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="occupation" id="occupation"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Occupation" value="{{ old('occupation') }}">
                        @error('occupation')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Monthly Income -->
                <div class="flex items-start gap-4">
                    <label for="monthly_income" class="w-48 text-sm font-medium">Monthly Income<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="number" name="monthly_income" id="monthly_income"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Monthly Income" value="{{ old('monthly_income') }}">
                        @error('monthly_income')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Collection Time -->
                <div class="flex items-start gap-4">
                    <label for="collection_time" class="w-48 text-sm font-medium">Collection Time<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="time" name="collection_time" id="collection_time"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('collection_time') }}">
                        @error('collection_time')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Form 15G/15H Uploaded -->
                <div class="flex items-start gap-4">
                    <label for="form_15g_15h" class="w-48 text-sm font-medium">Form 15G/15H Uploaded<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="form_15g_15h" id="form_15g_15h"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('form_15g_15h') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('form_15g_15h') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                        @error('form_15g_15h')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Save Director
                    </button>
                    <button class="btn-outline" type="reset"
                        onclick="window.location.href='{{ route('manage.promotor') }}'">
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
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</script> --}}