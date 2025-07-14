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
            <form action="{{route('member.edit')}}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf

                <div class="flex items-start gap-4 mt-4">
                    <label class="w-48 text-sm font-medium">Membership Type</label>
                    <div class="w-full flex gap-6 items-center">
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="radio" name="membership_type" value="nominal" {{ old('membership_type') == 'nominal' ? 'checked' : '' }} class="form-radio text-primary">
                            Nominal Membership
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm">
                            <input type="radio" name="membership_type" value="regular" {{ old('membership_type') == 'regular' ? 'checked' : '' }} class="form-radio text-primary">
                            Regular Membership
                        </label>
                        @error('membership_type')
                            <span class="text-red-500 text-xs block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>

                <!-- Advisor / Staff -->
                <div class="flex items-start gap-4 mt-4">
                    <label for="advisor_staff" class="w-48 text-sm font-medium">Advisor / Staff</label>
                    <div class="w-full">
                        <input type="text" name="advisor_staff" id="advisor_staff"
                            placeholder="Search associate / user code or name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('advisor_staff') }}">
                        @error('advisor_staff')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Groups -->
                <div class="flex items-start gap-4 mt-4">
                    <label for="group" class="w-48 text-sm font-medium">Groups</label>
                    <div class="w-full">
                        <select name="group" id="group"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select group</option>
                            <!-- Add group options here -->
                            <option value="group1" {{ old('group') == 'group1' ? 'selected' : '' }}>Group 1</option>
                            <option value="group2" {{ old('group') == 'group2' ? 'selected' : '' }}>Group 2</option>
                        </select>
                        @error('group')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="branch" class="w-48 text-sm font-medium">Branch<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="branch" id="branchDropdown"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Branch</option>
                        </select>
                        @error('branch')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="enrollment_date" class="w-48 text-sm font-medium">Enrollment Date<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <div
                            class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                            <input name="enrollment_date" id="date2" class="border-none" placeholder="Select Date"
                                class="w-full text-sm border px-3 py-2" autocomplete="off" />
                            <i
                                class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                        </div>
                        @error('enrollment_date')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                    <h3 class="h2">Member's Info</h3>
                </div> <br>
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
                    <label for="first_name" class="w-48 text-sm font-medium">First Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="first_name" id="first_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter IFSC code" value="">
                        @error('first_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="middle_name" class="w-48 text-sm font-medium mt-2">Middle Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input name="middle_name" id="middle_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter address line 1">
                        @error('middle_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="lastname" class="w-48 text-sm font-medium">Last Name </label>
                    <div class="w-full">
                        <input type="text" name="lastname" id="lastname"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter address line 2" value="">
                        @error('lastname')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="dob" class="w-48 text-sm font-medium">Date of Birth<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <div
                            class="relative bg-secondary/5 py-3 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl">
                            <input name="dob" id="date" class="border-none" placeholder="Select Date"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                autocomplete="off" />
                            <i
                                class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>
                        </div>
                        @error('dob')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <label for="qualification" class="w-48 text-sm font-medium">Qualification<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="qualification" id="qualification"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter qualification" value="{{ old('qualification') }}">
                        @error('qualification')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="occupation" class="w-48 text-sm font-medium">Occupation<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="occupation" id="occupation"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter occupation" value="">
                        @error('occupation')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Monthly Income -->
                <div class="flex items-start gap-4">
                    <label for="monthly_income" class="w-48 text-sm font-medium">Monthly Income<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="monthly_income" id="monthly_income"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter monthly income" value="{{ old('monthly_income') }}">
                        @error('monthly_income')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Old Member No (if any) -->
                <div class="flex items-start gap-4">
                    <label for="old_member_no" class="w-48 text-sm font-medium">Old Member No</label>
                    <div class="w-full">
                        <input type="text" name="old_member_no" id="old_member_no"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter old member no (if any)" value="{{ old('old_member_no') }}">
                        @error('old_member_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Father Name -->
                <div class="flex items-start gap-4">
                    <label for="father_name" class="w-48 text-sm font-medium">Father Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="father_name" id="father_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter father name" value="{{ old('father_name') }}">
                        @error('father_name')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Mother Name -->
                <div class="flex items-start gap-4">
                    <label for="mother_name" class="w-48 text-sm font-medium">Mother Name<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="mother_name" id="mother_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter mother name" value="{{ old('mother_name') }}">
                        @error('mother_name')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="spouse" class="w-48 text-sm font-medium">Husband/ Wife Name</label>
                    <div class="w-full">
                        <input type="text" name="spouse" id="spouse"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Spouse" value="">
                        @error('spouse')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="spouse_dob" class="w-48 text-sm font-medium">Husband/ Wife DOB</label>
                    <div class="w-full">
                        <input type="date" name="spouse_dob" id="spouse_dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter DOB" value="{{ old('spouse_dob') }}">
                        @error('spouse_dob')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>




                <div class="flex items-start gap-4">
                    <label for="mariatal_status" class="w-48 text-sm font-medium">Marital Status</label>
                    <div class="w-full">
                        <select name="mariatal_status" id="mariatal_status"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Mariatal Status</option>
                        </select>
                        @error('mariatal_status')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="member_religion" class="w-48 text-sm font-medium">Member Religion</label>
                    <div class="w-full">
                        <select name="member_religion" id="member_religion"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Member Religion</option>
                        </select>
                        @error('member_religion')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="folio_no" class="w-48 text-sm font-medium">Folio No<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="text" name="folio_no" id="folio_no"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Folio No" value="{{ old('folio_no') }}">
                        @error('folio_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>
                <!-- Member's KYC -->
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                    <h3 class="h2">Member's KYC</h3>
                </div>
                <div class="flex items-start gap-4">
                    <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No.</label>
                    <div class="w-full">
                        <input type="text" name="aadhaar_no" id="aadhaar_no" placeholder="Enter Aadhaar No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('gst_no') }}">
                        @error('aadhaar_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <label for="voter_no" class="w-48 text-sm font-medium">Voter ID No.</label>
                    <div class="w-full">
                        <input type="text" name="voter_no" id="voter_no" placeholder="Enter Voter ID No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('gst_no') }}">
                        @error('voter_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="pan_no" class="w-48 text-sm font-medium">PAN No.</label>
                    <div class="w-full">
                        <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('pan_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="ration_no" class="w-48 text-sm font-medium">Ration Card No.</label>
                    <div class="w-full">
                        <input type="text" name="ration_no" id="ration_no" placeholder="Enter Ration Card No"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('ration_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="meter_no" class="w-48 text-sm font-medium">Meter No.</label>
                    <div class="w-full">
                        <input type="text" name="meter_no" id="meter_no" placeholder="Enter Meter No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('meter_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="ci_no" class="w-48 text-sm font-medium">CI No.</label>
                    <div class="w-full">
                        <input type="text" name="ci_no" id="ci_no" placeholder="Enter CI No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('ci_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="ci_relation" class="w-48 text-sm font-medium">CI Relation.</label>
                    <div class="w-full">
                        <input type="text" name="ci_relation" id="ci_relation" placeholder="Enter CI Relation."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('ci_relation')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="dl_no" class="w-48 text-sm font-medium">DL No.</label>
                    <div class="w-full">
                        <input type="text" name="dl_no" id="dl_no" placeholder="Enter DL No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('dl_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="passport_no" class="w-48 text-sm font-medium">Passport No</label>
                    <div class="w-full">
                        <input type="text" name="passport_no" id="passport_no"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Passport No" value="{{ old('passport_no') }}">
                        @error('passport_no')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Nominee Info -->
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                    <h3 class="h2">Nominee Info</h3>
                </div>
               <br>

                <div class="flex items-start gap-4">
                    <label for="nomine_name" class="w-48 text-sm font-medium">Nominee Name</label>
                    <div class="w-full">
                        <input type="text" name="nomine_name" id="nomine_name" placeholder="Enter Nominee Name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_name')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_relation" class="w-48 text-sm font-medium">Nominee Relation</label>
                    <div class="w-full">
                        <input type="text" name="nomine_relation" id="nomine_relation" placeholder="Enter Nominee Relation"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_relation')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_mobile" class="w-48 text-sm font-medium">Nominee Mobile No.</label>
                    <div class="w-full">
                        <input type="text" name="nomine_mobile" id="nomine_mobile" placeholder="Enter Nominee Mobile"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_mobile')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="gender" class="w-48 text-sm font-medium">Gender<span class="text-red-500">*</span></label>
                    <div class="w-full">
                        <select name="gender" id="gender"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nominee_dob" class="w-48 text-sm font-medium">Nominee DOB<span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="nominee_dob" id="nominee_dob"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Nominee DOB" value="{{ old('nominee_dob') }}">
                        @error('nominee_dob')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_aadhar" class="w-48 text-sm font-medium">Nominee Aadhar No.</label>
                    <div class="w-full">
                        <input type="text" name="nomine_aadhar" id="nomine_aadhar" placeholder="Enter Nominee Aadhar No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_aadhar')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_voter" class="w-48 text-sm font-medium">Nominee Voter ID No.</label>
                    <div class="w-full">
                        <input type="text" name="nomine_voter" id="nomine_voter" placeholder="Enter Nominee Voter ID No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_voter')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_pan" class="w-48 text-sm font-medium">Nominee Pan No.</label>
                    <div class="w-full">
                        <input type="text" name="nomine_pan" id="nomine_pan" placeholder="Enter Nominee Pan No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('pan_no') }}">
                        @error('nomine_pan')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nominee_ration_card" class="w-48 text-sm font-medium">Nominee Ration Card No.</label>
                    <div class="w-full">
                        <input type="text" name="nominee_ration_card" id="nominee_ration_card"
                            placeholder="Enter Nominee Ration Card No."
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('nominee_ration_card') }}">
                        @error('nominee_ration_card')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <label for="nomine_address" class="w-48 text-sm font-medium">Nominee Address</label>
                    <div class="w-full">
                        <input type="text" name="nomine_address" id="nomine_address" placeholder="Enter Nominee Address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="">
                        @error('nomine_address')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div> 
                <br>
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                    <h3 class="h2">Extra Settings</h3>
                </div> 
                <br>
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

                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        Save Member
                    </button>
                    <button class="btn-outline" type="reset" onclick="window.location.href='{{ route('member.index') }}'">
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