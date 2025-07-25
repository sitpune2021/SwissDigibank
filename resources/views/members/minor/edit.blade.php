<!-- @extends('layout.main')

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

    @if (session('success'))
    <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    @endif
    <div class="box mb-4 xxxl:mb-6">
            <form action="{{route('minor.edit')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf

            <div class="flex items-start gap-4">
                <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="enrollment_date" id="date2" class="border-none" placeholder="Select Date" class="w-full text-sm border px-3 py-2" value="{{$promoter->enrollment_date}}" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('enrollment_date')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        
            <div class="flex items-start gap-4">
                <label for="title" class="w-48 text-sm font-medium">Title<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="flex gap-4">
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="MD" {{ old('title', $promoter->title) == 'MD' ? 'checked' : '' }}>
                            <span>MD</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mr" {{ old('title', $promoter->title) == 'Mr' ? 'checked' : '' }}>
                            <span>Mr</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Ms" {{ old('title', $promoter->title) == 'Ms' ? 'checked' : '' }}>
                            <span>Ms</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mrs" {{ old('title', $promoter->title) == 'Mrs' ? 'checked' : '' }}>
                            <span>Mrs</span>
                        </label>
                    </div>
                    @error('title')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="flex gap-4">
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Male" {{ old('title', $promoter->gender) == 'Male' ? 'checked' : '' }}>
                            <span>Male</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Female" {{ old('title', $promoter->gender) == 'Female' ? 'checked' : '' }}>
                            <span>Female</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Other" {{ old('title', $promoter->gender) == 'Other' ? 'checked' : '' }}>
                            <span>Other</span>
                        </label>
                    </div>
                    @error('gender')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="first_name" class="w-48 text-sm font-medium">First Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="first_name" id="first_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter IFSC code" value="{{$promoter->first_name}}">
                    @error('first_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="lastname" class="w-48 text-sm font-medium">Last Name </label>
                <div class="w-full">
                    <input type="text" name="lastname" id="lastname" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 2" value="{{$promoter->last_name}}">
                    @error('lastname')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dob" class="w-48 text-sm font-medium">Date of Birth<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="dob" id="date" class="border-none" placeholder="Select Date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{$promoter->date_of_birth}}" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('dob')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="father_name" class="w-48 text-sm font-medium">Father Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="father_name" id="father_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter father name" value="{{$promoter->father_name}}">
                    @error('father_name')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No.</label>
                <div class="w-full">
                    <input type="text" name="aadhaar_no" id="aadhaar_no" placeholder="Enter Aadhaar No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{$promoter->aadhaar_no}}">
                    @error('aadhaar_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="address" class="w-48 text-sm font-medium">Address</label>
                <div class="w-full">
                    <input type="text" name="address" id="nomine_address" placeholder="Enter Address" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ $promoter->nominee_address }}">
                    @error('address')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div> <br>
        
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">
                    Save Promotor
                </button>
                <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('manage.promotor') }}'">
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
    setTimeout(function() {
        var successAlert = document.getElementById('success-alert');
        var errorAlert = document.getElementById('error-alert');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 5000);
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var selectedBranchId = "{{ $promoter->branch }}";

        $.ajax({
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function(response) {
                $.each(response, function(key, branch) {
                    let selected = (branch.id == selectedBranchId) ? 'selected' : '';
                    $('#branchDropdown').append(`<option value="${branch.id}" ${selected}>${branch.branch_name}</option>`);
                });
            },
            error: function() {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var selectedMaritalStatusId = "{{ $promoter->mariatal_status }}";
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    let selected = (status.id == selectedMaritalStatusId) ? 'selected' : '';
                    $('#mariatal_status').append(`<option value="${status.id}" ${selected}>${status.status}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        var selectedReligionStatusId = "{{ $promoter->member_religion }}";
        $.ajax({
            url: "{{ url('/get-religion-statuses') }}",
            type: 'GET',
            success: function(response) {
                $.each(response, function(index, status) {
                    $('#member_religion').append(`<option value="${status.id}">${status.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script> -->