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
</style>
<div class="main-inner">
    <div class="text-xl font-semibold text-gray-800">
        <h3 class="h2">Add New Promoter</h3>
        <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
            <!-- <li><a href="{{ url('/dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li> -->
            <li><a href="{{ url('/manage-branch') }}" class="text-blue-600 hover:underline">Promoters</a></li>
            <li class="text-gray-500">New</li>
        </ol>
        <hr class="my-2 border-gray-300" />
    </div>
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
        <form id="companyForm" action="{{route('add.promotor')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6 max-w-screen-md mx-auto">
            @csrf
            <div class="flex items-start gap-4">
                <label for="branch" class="w-48 text-sm font-medium">Branch<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <select name="branch" id="branchDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <!-- <option value="">Select Branch</option> -->
                    </select>
                    @error('branch')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="enrollment_date" id="date2" class="border-none" placeholder="Select Date" class="w-full text-sm border px-3 py-2" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('enrollment_date')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Section Heading: Centered -->
            <div class="col-span-2">
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Promoter Info</h3>
            </div>

            <!-- Example Field -->
            <div class="flex items-start gap-4">
                <label for="title" class="w-48 text-sm font-medium">Title<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="flex gap-4">
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="MD" {{ old('title') == 'MD' ? 'checked' : '' }}>
                            <span>MD</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mr" {{ old('title') == 'Mr' ? 'checked' : '' }}>
                            <span>Mr</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Ms" {{ old('title') == 'Ms' ? 'checked' : '' }}>
                            <span>Ms</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="title" value="Mrs" {{ old('title') == 'Mrs' ? 'checked' : '' }}>
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
                            <input type="radio" name="gender" value="Male" {{ old('title') == 'Male' ? 'checked' : '' }}>
                            <span>Male</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Female" {{ old('title') == 'Female' ? 'checked' : '' }}>
                            <span>Female</span>
                        </label>
                        <label class="flex items-center space-x-1">
                            <input type="radio" name="gender" value="Other" {{ old('title') == 'Other' ? 'checked' : '' }}>
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
                    <input type="text" name="first_name" id="first_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter IFSC code" value="">
                    @error('first_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="middle_name" class="w-48 text-sm font-medium mt-2">Middle Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input name="middle_name" id="middle_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 1">
                    @error('middle_name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="lastname" class="w-48 text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="lastname" id="lastname" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter address line 2" value="">
                    @error('lastname')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dob" class="w-48 text-sm font-medium">Date of Birth<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <div class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                        <input name="dob" id="date" class="border-none" placeholder="Select Date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" autocomplete="off" />
                        <i
                            class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                    </div>
                    @error('dob')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="occupation" class="w-48 text-sm font-medium">Occupation<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="occupation" id="occupation" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter occupation" value="">
                    @error('occupation')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="father_name" class="w-48 text-sm font-medium">Father Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="father_name" id="father_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter father name" value="">
                    @error('father_name')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mother_name" class="w-48 text-sm font-medium">Mother Name<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mother_name" id="mother_name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter mother name" value="">
                    @error('mother_name')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mariatal_status" class="w-48 text-sm font-medium">Marital Status</label>
                <div class="w-full">
                    <select name="mariatal_status" id="mariatal_status" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <!-- <option value="">Select Mariatal Status</option> -->
                    </select>
                    @error('mariatal_status')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="member_religion" class="w-48 text-sm font-medium">Member Religion</label>
                <div class="w-full">
                    <select name="member_religion" id="member_religion" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                        <!-- <option value="">Select Member Religion</option> -->
                    </select>
                    @error('member_religion')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="spouse" class="w-48 text-sm font-medium">Husband/ Wife Name</label>
                <div class="w-full">
                    <input type="text" name="spouse" id="spouse" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter Spouse" value="">
                    @error('spouse')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="landline_no" class="w-48 text-sm font-medium">Landline No.</label>
                <div class="w-full">
                    <input type="text" name="landline_no" id="landline_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter branch landline no" value="">
                    @error('landline_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="email" class="w-48 text-sm font-medium">Email</label>
                <div class="w-full">
                    <input type="text" name="email" id="email" placeholder="Enter Email" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    @error('email')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="mobile_no" class="w-48 text-sm font-medium">Mobile No.<span class="text-red-500">*</span></label>
                <div class="w-full">
                    <input type="text" name="mobile_no" id="mobile_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" placeholder="Enter mobile no" value="{{ old('mobile_no') }}">
                    @error('mobile_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- Repeat above structure for all fields -->

            <!-- Section Heading -->
            <div class="col-span-2">
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Promoter's KYC</h3>
            </div>

            <!-- Another Field Example -->
            <div class="flex items-start gap-4">
                <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No.</label>
                <div class="w-full">
                    <input type="text" name="aadhaar_no" id="aadhaar_no" placeholder="Enter Aadhaar No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('gst_no') }}">
                    @error('aadhaar_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex items-start gap-4">
                <label for="voter_no" class="w-48 text-sm font-medium">Voter ID No.</label>
                <div class="w-full">
                    <input type="text" name="voter_no" id="voter_no" placeholder="Enter Voter ID No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('gst_no') }}">
                    @error('voter_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                <div class="w-full">
                    <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('pan_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ration_no" class="w-48 text-sm font-medium">Ration Card No.</label>
                <div class="w-full">
                    <input type="text" name="ration_no" id="ration_no" placeholder="Enter Ration Card No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('ration_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="meter_no" class="w-48 text-sm font-medium">Meter No.</label>
                <div class="w-full">
                    <input type="text" name="meter_no" id="meter_no" placeholder="Enter Meter No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('meter_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ci_no" class="w-48 text-sm font-medium">CI No.</label>
                <div class="w-full">
                    <input type="text" name="ci_no" id="ci_no" placeholder="Enter CI No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('ci_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ci_relation" class="w-48 text-sm font-medium">CI Relation.</label>
                <div class="w-full">
                    <input type="text" name="ci_relation" id="ci_relation" placeholder="Enter CI Relation." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('ci_relation')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="dl_no" class="w-48 text-sm font-medium">DL No.</label>
                <div class="w-full">
                    <input type="text" name="dl_no" id="dl_no" placeholder="Enter DL No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('dl_no')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Section Heading -->
            <div class="col-span-2">
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Nominee Info</h3>
            </div>
            <div class="flex items-start gap-4">
                <label for="nomine_name" class="w-48 text-sm font-medium">Nominee Name</label>
                <div class="w-full">
                    <input type="text" name="nomine_name" id="nomine_name" placeholder="Enter Nominee Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_name')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_relation" class="w-48 text-sm font-medium">Nominee Relation</label>
                <div class="w-full">
                    <input type="text" name="nomine_relation" id="nomine_relation" placeholder="Enter Nominee Relation" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_relation')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_mobile" class="w-48 text-sm font-medium">Nominee Mobile No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_mobile" id="nomine_mobile" placeholder="Enter Nominee Mobile" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_mobile')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_aadhar" class="w-48 text-sm font-medium">Nominee Aadhar No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_aadhar" id="nomine_aadhar" placeholder="Enter Nominee Aadhar No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_aadhar')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_voter" class="w-48 text-sm font-medium">Nominee Voter ID No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_voter" id="nomine_voter" placeholder="Enter Nominee Voter ID No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_voter')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_pan" class="w-48 text-sm font-medium">Nominee Pan No.</label>
                <div class="w-full">
                    <input type="text" name="nomine_pan" id="nomine_pan" placeholder="Enter Nominee Pan No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('pan_no') }}">
                    @error('nomine_pan')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="nomine_address" class="w-48 text-sm font-medium">Nominee Address</label>
                <div class="w-full">
                    <input type="text" name="nomine_address" id="nomine_address" placeholder="Enter Nominee Address" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="">
                    @error('nomine_address')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex items-start gap-4">
                <label for="ration_no" class="w-48 text-sm font-medium">Nominee Address</label>
                <div class="w-full">
                    <input type="text" name="nomine_address" id="nomine_address" placeholder="Enter Ration Card No" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3" value="{{ old('ration_no') }}">
                    @error('nomine_address')
                    <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-span-2">
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-2">Extra Settings</h3>
            </div>
            <div class="flex items-start gap-4">
                <label for="sms" class="w-48 text-sm font-medium">SMS</label>
                <label class="switch">
                    <input type="hidden" name="sms" value="0">
                    <input type="checkbox" name="sms" id="sms" value="1" {{ old('sms') ? 'checked' : '' }}>
                    <div class="slider round">
                        <span class="switch-on">ON</span>
                        <span class="switch-off">OFF</span>
                    </div>
                </label>
            </div>
            <!-- Buttons -->
            <div class="col-span-2 flex gap-4 justify-center mt-6">
                <button class="btn-primary" type="submit">Save Promotor</button>
                <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('ManagePromotor') }}'">Back</button>
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">Reset</button>
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
        const oldBranchId = $('#oldState').val();
        $.ajax({
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function(response) {
                $('#branchDropdown').append('<option value="">Select Branch</option>');
                $.each(response, function(key, branch) {
                    let selected = (branch.id == oldBranchId) ? 'selected' : '';
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
        const oldMariatal = $('#oldMariatalStatus').val();
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function(response) {
                $('#mariatal_status').append('<option value="">Select Marital Status</option>');
                $.each(response, function(index, status) {
                    let selected = (status.id == oldMariatal) ? 'selected' : '';
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
        const oldReligion = $('#oldReligion').val();
        $.ajax({
            url: "{{ url('/get-religion-statuses') }}",
            type: 'GET',
            success: function(response) {
                $('#member_religion').append('<option value="">Select Member Religion</option>');
                $.each(response, function(index, religion) {
                    let selected = (religion.id == oldReligion) ? 'selected' : '';
                    $('#member_religion').append(`<option value="${religion.id}" ${selected}>${religion.name}</option>`);
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>