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
            <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if (isset($method) && $method == 'PUT')
                    @method('PUT')
                @endif

                {{-- @if ($method == 'PUT')
                    @method('PUT')
                @endif --}}
                @foreach ($sections as $sectionName => $fields)
                    {{-- Section Heading --}}
                    @if ($sectionName)
                        <div class="col-span-2">
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
                                {{ str_replace('_', ' ', $sectionName) }}
                            </h3>
                        </div>
                    @endif
                    @foreach ($fields as $field)
                        @php
                            $name = $field['name'];
                            $type = $field['type'] ?? 'text';
                            $label = $field['label'];
                            $id = $field['id'] ?? $field['name'];
                            $required = $field['required'] ?? false;
                            $value = old($name, $minor[$name] ?? ($field['default'] ?? ''));
                        @endphp
                        <div class="col-span-4 md:col-span-1">
                            <label for="{{ $id }}" class="md:text-lg font-medium block mb-4">
                                {{ $label }} @if ($required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            @if ($type === 'select')
                                <select name="{{ $name }}" id="{{ $id }}"
                                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10  px-3 md:px-6 py-2 md:py-3"
                                    {{ isset($show) ? 'readonly' : '' }}>
                                    <option value="">-- Select {{ $label }} --</option>

                                    @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                        @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'selected' : '' }}>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    @elseif(!empty($field['options']))
                                        @foreach ($field['options'] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'selected' : '' }}>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                                

                            @elseif ($type === 'radio')
                                <div class="flex gap-2">
                                    @foreach ($field['options'] as $optionValue => $optionLabel)
                                        <label class="flex items-center space-x-4 class=ml-2">
                                            <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'checked' : '' }}
                                                {{ isset($show) ? 'readonly' : '' }}>
                                            <span>{{ $optionLabel }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif ($type === 'checkbox')
                                <label class="switch">
                                    <input type="checkbox" name="{{ $name }}" id="{{ $id }}"
                                        value="1" {{ $value ? 'checked' : '' }} {{ isset($show) ? 'readonly' : '' }}>
                                    <div class="slider round">
                                        <span class="switch-on">ON</span>
                                        <span class="switch-off">OFF</span>
                                    </div>
                                </label>
                            @else
                                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                    value="{{ $value }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter {{ strtolower($label) }}" {{ isset($show) ? 'readonly' : '' }} />
                            @endif

                            @error($name)
                                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                @endforeach
                {{-- member  --}}
                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    @if (isset($method))
                        <button class="btn-primary" type="submit">
                            {{ $method === 'PUT' ? 'Update' : 'Save' }} Minor
                        </button>
                    @endif
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection



{{-- @extends('layout.main')

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
            <form action="{{route('minor.create')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf

<!-- Enrollment Date -->
<div class="flex items-start gap-4 mb-4">
    <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date *</label>
    <div class="w-full">
        <input type="date" name="enrollment_date" id="enrollment_date"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('enrollment_date') }}">
        @error('enrollment_date')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Title -->
<div class="flex items-start gap-4 mb-4">
    <label for="title" class="w-48 text-sm font-medium">Title *</label>
    <div class="w-full">
        <select name="title" id="title"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
            <option value="">Select Title</option>
            <option value="Md." {{ old('title') == 'Md.' ? 'selected' : '' }}>Md.</option>
            <option value="Mr." {{ old('title') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
            <option value="Ms." {{ old('title') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
            <option value="Mrs." {{ old('title') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
        </select>
        @error('title')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Gender -->
<div class="flex items-start gap-4 mb-4">
    <label for="gender" class="w-48 text-sm font-medium">Gender *</label>
    <div class="w-full">
        <select name="gender" id="gender"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
            <option value="">Select Gender</option>
            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('gender')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- First Name -->
<div class="flex items-start gap-4 mb-4">
    <label for="first_name" class="w-48 text-sm font-medium">First Name *</label>
    <div class="w-full">
        <input type="text" name="first_name" id="first_name" placeholder="Enter First Name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('first_name') }}">
        @error('first_name')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Last Name -->
<div class="flex items-start gap-4 mb-4">
    <label for="last_name" class="w-48 text-sm font-medium">Last Name</label>
    <div class="w-full">
        <input type="text" name="last_name" id="last_name" placeholder="Enter Last Name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('last_name') }}">
        @error('last_name')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Date of Birth -->
<div class="flex items-start gap-4 mb-4">
    <label for="dob" class="w-48 text-sm font-medium">Date of Birth *</label>
    <div class="w-full">
        <input type="date" name="dob" id="dob"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('dob') }}">
        @error('dob')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Father Name -->
<div class="flex items-start gap-4 mb-4">
    <label for="father_name" class="w-48 text-sm font-medium">Father Name *</label>
    <div class="w-full">
        <input type="text" name="father_name" id="father_name" placeholder="Enter Father's Name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('father_name') }}">
        @error('father_name')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Aadhaar No. -->
<div class="flex items-start gap-4 mb-4">
    <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No.</label>
    <div class="w-full">
        <input type="text" name="aadhaar_no" id="aadhaar_no" placeholder="Enter Aadhaar Number"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
            value="{{ old('aadhaar_no') }}">
        @error('aadhaar_no')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- Address -->
<div class="flex items-start gap-4 mb-4">
    <label for="address" class="w-48 text-sm font-medium">Address *</label>
    <div class="w-full">
        <textarea name="address" id="address" rows="3" placeholder="Enter Address"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">{{ old('address') }}</textarea>
        @error('address')
            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
        @enderror
    </div>
</div>

<!-- ------------------------------------------------------------------ -->
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Save Minor
                    </button>
                    <button class="btn-outline" type="reset"
                        onclick="window.location.href='{{ route(`minor.index`) }}'">
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
       // var selectedBranchId = "{{ $promoter->branch }}";

        $.ajax({
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function (response) {
                $.each(response, function (key, branch) {
                    let selected = (branch.id == selectedBranchId) ? 'selected' : '';
                    $('#branchDropdown').append(`<option value="${branch.id}" ${selected}>${branch.branch_name}</option>`);
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
        var selectedMaritalStatusId = "{{ $promoter->mariatal_status }}";
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function (response) {
                $.each(response, function (index, status) {
                    let selected = (status.id == selectedMaritalStatusId) ? 'selected' : '';
                    $('#mariatal_status').append(`<option value="${status.id}" ${selected}>${status.status}</option>`);
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
        var selectedReligionStatusId = "{{ $promoter->member_religion }}";
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
