@extends('layout.main')

@section('content')

    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        /* Fallback for browsers without accent-color support */
        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
            /* Modern browser support */
        }
    </style>

    <div class="main-inner">

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                        Add New Notice
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen md-4">
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">


                {{-- <form
                    action="{{ isset($notice) ? route('notice-boards.update', $notice->id) : route('notice-boards.store') }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($notice))
                    @method('PUT')
                    @endif

                    <!-- Branch Dropdown -->
                    <select name="branch_id" class="...">
                        <option value="">Select branch</option>
                        @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ isset($notice) && $notice->branch_id == $branch->id ?
                            'selected' : '' }}>
                            {{ $branch->branch_name }}
                        </option>
                        @endforeach
                    </select>

                    <!-- Notice Title -->
                    <input type="text" name="notice_title" value="{{ $notice->notice_title ?? old('notice_title') }}" ...>

                    <!-- Notice Body -->
                    <textarea name="notice_body">{{ $notice->notice_body ?? old('notice_body') }}</textarea>

                    <!-- Image Upload -->
                    <input type="file" name="images">
                    @if(isset($notice) && $notice->images)
                    <img src="{{ asset($notice->images) }}" class="w-32 mt-2" alt="Notice Image">
                    @endif

                    <!-- Start Date -->
                    <input type="text" name="start_date" class="datepicker-field"
                        value="{{ isset($notice) ? \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') : old('start_date') }}">

                    <!-- End Date -->
                    <input type="text" name="end_date" class="datepicker-future"
                        value="{{ isset($notice) ? \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') : old('end_date') }}">

                    <!-- App Type -->
                    <input type="radio" name="app_type" value="Admin App" {{ (isset($notice) && $notice->app_type == 'Admin
                    App') ? 'checked' : (!isset($notice) ? 'checked' : '') }}> Admin App
                    <input type="radio" name="app_type" value="Agent App" {{ isset($notice) && $notice->app_type == 'Agent
                    App' ? 'checked' : '' }}> Agent App
                    <input type="radio" name="app_type" value="Both App" {{ isset($notice) && $notice->app_type == 'Both
                    App' ? 'checked' : '' }}> Both App

                    <button type="submit" class="btn-primary">
                        {{ isset($notice) ? 'Update Notice' : 'Add Notice' }}
                    </button>
                </form> --}}

                <form id=""
                    action="{{ isset($notice) ? route('notice-boards.update', $notice->id) : route('notice-boards.store') }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($notice))
                        @method('PUT')
                    @endif

                    <!-- branch -->
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">Company Branch <span
                                class="text-red-500">*</span></label>
                        <select id="branch_id" name="branch_id"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Select branch</option>

                            @foreach($branches as $branch)
                                                <option value="{{ $branch->id }}" {{ isset($notice) && $notice->branch_id == $branch->id ?
                                'selected' : '' }}>
                                                    {{ $branch->branch_name }}
                                                </option>
                            @endforeach

                        </select>

                    </div>
                    @error('branch_id')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!--  Notice Title * -->
                    <div class="w-full mt-4 ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                Notice Title
                            </label>
                            <span class="text-error">*</span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="text" name="notice_title" id="notice_title"
                                class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3 "
                                value="{{ $notice->notice_title ?? old('notice_title') }}"
                                placeholder=" Enter Notice Title">
                        </div>
                    </div>
                    @error('notice_title')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Notice Body  -->
                    <div class="w-full mt-4 ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                Notice Body
                            </label>
                            <span class="text-error">*</span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <textarea name="notice_body" id="notice_body"
                                class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3 "
                                placeholder=" Enter Notice Message">{{ $notice->notice_body ?? old('notice_body') }}</textarea>
                        </div>
                    </div>
                    @error('notice_body')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <!--  Upload Image/ File -->
                    <div class="w-full mt-4 ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                Upload Image/ File
                            </label>

                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="file" name="images" id="images"
                                class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3">
                            @if(isset($notice) && $notice->images)
                                <img src="{{ asset($notice->images) }}"
                                    class="w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3"
                                    alt="Notice Image">
                            @endif
                        </div>
                    </div>
                    <!--   Start Date  -->
                    <div class="w-full mt-4 ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                Start Date
                            </label>
                            <span class="text-error">*</span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="text" name="start_date" id=""
                                class="datepicker-field w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3 "
                                placeholder="DD/MM/YYYY"
                                value="{{ isset($notice) ? \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') : old('start_date') }}">
                        </div>
                    </div>
                    @error('notice_body')
                        <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <!--  End Date  -->
                    <div class="w-full mt-4 ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                End Date
                            </label>
                            <span class="text-error">*</span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <input type="text" name="end_date" id=""
                                class="datepicker-future w-full border rounded-10 px-3 py-3  text-sm bg-secondary/5  dark:bg-bg3 "
                                placeholder="DD/MM/YYYY"
                                value="{{ isset($notice) ? \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') : old('end_date') }}">
                        </div>
                    </div>

                    <!--  App Type   -->
                    {{-- <div class="w-full mt-4  ">
                        <div class="mb-2">
                            <label id="" class="font-medium text-gray-700 uppercase">
                                App Type
                            </label>
                            <span class="text-error">*</span>
                        </div>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex gap-2 items-center">
                                <input type="radio" name="app_type" id="" value="Admin App" value="Admin App" {{
                                    (isset($notice) && $notice->app_type == 'Admin
                                App') ? 'checked' : (!isset($notice) ? 'checked' : '') }} checked>
                                <p> Admin App </p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <input type="radio" name="app_type" value="Agent App" {{ isset($notice) && $notice->app_type
                                == 'Agent
                                App' ? 'checked' : '' }} id="" >
                                <p> Agent App </p>
                            </div>
                            <div class="flex gap-2 items-center">
                                <input type="radio" name="app_type" value="Both App" {{ isset($notice) && $notice->app_type
                                == 'Both
                                App' ? 'checked' : '' }} id="">
                                <p> Both App </p>
                            </div>
                        </div>
                    </div> --}}
                    @php
                        $selectedAppType = $notice->app_type ?? old('app_type', 'Admin App');
                    @endphp

                    <div class="w-full mt-4">
                        <div class="mb-2">
                            <label class="font-medium text-gray-700 uppercase">
                                App Type
                            </label>
                            <span class="text-error">*</span>
                        </div>

                        <div class="flex flex-wrap gap-6">
                            <label class="flex gap-2 items-center cursor-pointer">
                                <input type="radio" name="app_type" value="Admin App" {{ $selectedAppType === 'Admin App' ? 'checked' : '' }}>
                                <span>Admin App</span>
                            </label>

                            <label class="flex gap-2 items-center cursor-pointer">
                                <input type="radio" name="app_type" value="Agent App" {{ $selectedAppType === 'Agent App' ? 'checked' : '' }}>
                                <span>Agent App</span>
                            </label>

                            <label class="flex gap-2 items-center cursor-pointer">
                                <input type="radio" name="app_type" value="Both App" {{ $selectedAppType === 'Both App' ? 'checked' : '' }}>
                                <span>Both App</span>
                            </label>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="flex justify-center mt-8 gap-4 pt-6">
                        <button type="submit" class="btn-primary uppercase">
                            {{ isset($notice) ? 'Update Notice' : 'Add Notice' }}
                        </button>
                        <a href="{{ route('notice-boards.index') }}" class="btn-outline uppercase">Back</a>
                    </div>

                </form>
            </div>



        </div>
    </div>
    </div>


    <!-- Datepicker CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->

    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.datepicker-field').forEach(function (dateInput) {
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


    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();

            document.querySelectorAll('.datepicker-future').forEach(function (input) {
                new Datepicker(input, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    startDate: today, // disable past dates
                });

                // ✅ DO NOT override edit value
                if (!input.value) {
                    const dd = String(today.getDate()).padStart(2, '0');
                    const mm = String(today.getMonth() + 1).padStart(2, '0');
                    const yyyy = today.getFullYear();
                    input.value = dd + '-' + mm + '-' + yyyy;
                }
            });
        });
    </script>



@endsection