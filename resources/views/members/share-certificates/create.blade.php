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
        <div class="main-inner">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
                <h3 class="h2">Add Share Certificate</h3>
            </div>
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
                <form action="{{ route('share_certificates.create') }}" method="POST"
                    class="grid grid-cols-2 gap-4 xxxl:gap-6">
                    @csrf
                    <div class="flex items-start gap-4">
                        <label for="dob" class="w-48 text-sm font-medium">Enrollment Date :<span
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
                        <label for="nominal_value" class="w-48 text-sm font-medium">Father's Name:<span
                                class="text-red-500">*</span></label>
                        <div class="w-full">
                            <input type="text" name="nominal_value" id="nominal_value"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Nominal Value" value="">
                            @error('nominal_value')
                                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <label for="name" class="w-48 text-sm font-medium">Name:</label>
                        <div class="w-full">
                            <input type="text" name="name" id="name"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter name" value="">
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <label for="dob" class="w-48 text-sm font-medium">Date Of Birth :<span
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
                        <label for="gender" class="w-48 text-sm font-medium">Gender:<span
                                class="text-red-500">*</span></label>
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
                        <label for="aadhaar_no" class="w-48 text-sm font-medium">Aadhaar No:<span
                                class="text-red-500">*</span></label>
                        <div class="w-full">
                            <input type="text" name="aadhaar_no" id="aadhaar_no"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Aadhaar number" value="">
                            @error('aadhaar_no')
                                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <label for="address" class="w-48 text-sm font-medium">Address:<span
                                class="text-red-500">*</span></label>
                        <div class="w-full">
                            <input type="text" name="address" id="address"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter address" value="">
                            @error('address')
                                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <button class="btn-primary" type="submit">
                            Save ShareCertificates
                        </button>
                        <button class="btn-outline" type="reset"
                            onclick="window.location.href='{{ route('share_certificates.index') }}'">
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

