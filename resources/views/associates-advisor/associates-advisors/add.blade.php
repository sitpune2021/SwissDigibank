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

@section('content')


<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-center flex-col  gap-2">
            <h4 class="text-xl uppercase font-semibold">
                New Associate/ Advisor
            </h4>

        </div>
    </div>
    @php
    $isEdit = isset($associate);
    @endphp

    <div class="col-span-12 box lg:col-span-12">

        <form action="{{ $isEdit ? route('associate.update', $associate->id) : route('associate.store') }}"
            method="POST">

            @csrf
            @if($isEdit)
            @method('PUT')
            @endif

            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <div class="col-span-2 md:col-span-1">
                    <label for="scheme_name" class="md:text-lg uppercase font-medium block mb-4">
                        Associate Employee Profile (if any)
                    </label>

                    <select name="employee_id" id="employee_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                        <option value=""> Select Employee Profile of this New Associate</option>

                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-span-2 md:col-span-1"></div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block uppercase mb-4">
                        Associate Rank
                    </label>
                    <select name="rank" id="rank"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                        <option value=""> Select Rank</option>
                        <option value="1">Satic data</option>
                    </select>
                    <p class="text-primary mt-2 text-sm">
                        (select this if you want commission payout for agent)
                    </p>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium uppercase block mb-4">
                        Associate Supervisor
                    </label>
                    <select name="supervisor_id" id="supervisor_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                        <option value=""> Select Supervisor</option>
                        <option value="2">shekhar - static record</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="anuual_interest_rate" class="md:text-lg font-medium block mb-4 uppercase">
                        Enrollment Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="enrollment_date" name="enrollment_date"
                        value="{{ $isEdit && $associate->enrollment_date ? \Carbon\Carbon::parse($associate->enrollment_date)->format('d/m/Y') : '' }}"
                        class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                        placeholder="DD/MM/YYYY">
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        First Name
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="first_name" name="first_name"
                                value="{{ $isEdit ? $associate->first_name : '' }}"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter First Name">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Last Name
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="last_name" name="last_name"
                                value="{{ old('last_name', $associate->last_name ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Last Name">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Login User Name <span class="text-red-500">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="username" name="username"
                                value="{{ old('username', $associate->username ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark;border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter User Name">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Email
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $associate->email ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark;border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Email Address">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Mobile No <span class="text-red-500">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" name="mobile" id="mobile" value="+91" disabled
                                class="w-20 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <input type="number" id="mobile" name="mobile"
                                value="{{ old('mobile', $associate->mobile ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark;border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Mobile No">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Date of Birth
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="date" name="dob"
                                value="{{ $isEdit && $associate->dob ? \Carbon\Carbon::parse($associate->dob)->format('d/m/Y') : '' }}"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="DD/MM/YYYY">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="father_name" class="md:text-lg font-medium block mb-4 uppercase">
                        Father Name
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="father_name" name="father_name"
                                value="{{ old('father_name', $associate->father_name ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Father Name">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="husband_wife_name" class="md:text-lg font-medium block mb-4 uppercase">
                        Husband/ Wife Name
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="husband_wife_name" name="husband_wife_name"
                                value="{{ old('husband_wife_name', $associate->husband_wife_name ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Husband/ Wife Name">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="pan" class="md:text-lg font-medium block mb-4 uppercase">
                        PAN No
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="pan" name="pan" value="{{ old('pan', $associate->pan ?? '') }}"
                                style="text-transform: uppercase"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter PAN Number">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="aadhaar" class="md:text-lg font-medium block mb-4 uppercase">
                        Aadhaar No
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="number" id="aadhaar" name="aadhaar"
                                value="{{ old('aadhaar', $associate->aadhaar ?? '') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Aadhaar Number">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="address" class="md:text-lg font-medium block mb-4 uppercase">
                        Address
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <textarea id="address" name="address"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter Address">{{ old('address', $associate->address ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Back Date Entry Days
                        <span class="text-error">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="number" id="back_date_days" name="back_date_days"
                                value="{{ $isEdit ? $associate->back_date_days : '' }}"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Permissions / Roles
                        {{-- <span class="text-error">*</span> --}}
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="number" id="role" name="role" value="{{ $isEdit ? $associate->role : '' }}"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Select Role">
                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Branch
                        <span class="text-error">*</span>
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            {{-- {{ dd($employees) }} --}}
                            <select name="branch_id" id="branch_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                                <option value="">Select Branch</option>

                                @forelse($branches as $branch)
                                    <option value="{{ $branch->id }}" 
                                        {{ old('branch_id', $associate->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->branch_name }}
                                    </option>
                                @empty
                                    <option value="">No branches available</option>
                                @endforelse

                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Access Type
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="access_type" value="admin" {{ isset($associate) &&
                                $associate->access_type === 'admin' ? 'checked' : '' }}>
                            <span>Admin App</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="access_type" value="agent" {{ isset($associate) &&
                                $associate->access_type === 'agent' ? 'checked' : '' }}>
                            <span>Agent App</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="access_type" value="both" {{ isset($associate) &&
                                $associate->access_type === 'both' ? 'checked' : '' }}>
                            <span>Both App</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Login on Holidays
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="login_holiday" value="yes" {{ $isEdit && $associate->login_holiday
                            == 'yes' ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="login_holiday" value="no" {{ $isEdit && $associate->login_holiday
                            == 'no' ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Searchable Accounts
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="searchable_accounts" value="yes" {{ $isEdit &&
                                $associate->searchable_accounts == 'yes' ? 'checked' : '' }}>
                            <span>Yes - All</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="searchable_accounts" value="no" {{ $isEdit &&
                                $associate->searchable_accounts == 'no' ? 'checked' : '' }}>
                            <span>No - Only Assigned</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1 mb-6">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Active
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="active" value="yes" {{ isset($associate) && $associate->active ===
                            'yes' ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="active" value="no" {{ isset($associate) && $associate->active ===
                            'no' ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                </div>

            </div>

            <hr>
            <div class="mt-5">
                <P class="text-center text-xl uppercase font-semibold">
                    Nominee Info
                </P>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6 ">
                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Nominee Name
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <input type="text" id="nominee_name" name="nominee_name"
                                value="{{ $isEdit ? $associate->nominee_name : '' }}"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter Nominee Name ">
                        </div>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Nominee Relation
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <select id="nominee_relation" name="nominee_relation"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                                
                                <option value="">Select Relation</option>

                                <option value="father" {{ $isEdit && $associate->nominee_relation == 'father' ? 'selected' : '' }}>Father</option>
                                <option value="mother" {{ $isEdit && $associate->nominee_relation == 'mother' ? 'selected' : '' }}>Mother</option>
                                <option value="husband" {{ $isEdit && $associate->nominee_relation == 'husband' ? 'selected' : '' }}>Husband</option>
                                <option value="wife" {{ $isEdit && $associate->nominee_relation == 'wife' ? 'selected' : '' }}>Wife</option>
                                <option value="son" {{ $isEdit && $associate->nominee_relation == 'son' ? 'selected' : '' }}>Son</option>
                                <option value="daughter" {{ $isEdit && $associate->nominee_relation == 'daughter' ? 'selected' : '' }}>Daughter</option>
                                <option value="brother" {{ $isEdit && $associate->nominee_relation == 'brother' ? 'selected' : '' }}>Brother</option>
                                <option value="sister" {{ $isEdit && $associate->nominee_relation == 'sister' ? 'selected' : '' }}>Sister</option>
                                <option value="grandfather" {{ $isEdit && $associate->nominee_relation == 'grandfather' ? 'selected' : '' }}>Grandfather</option>
                                <option value="grandmother" {{ $isEdit && $associate->nominee_relation == 'grandmother' ? 'selected' : '' }}>Grandmother</option>
                                <option value="grandson" {{ $isEdit && $associate->nominee_relation == 'grandson' ? 'selected' : '' }}>Grandson</option>
                                <option value="granddaughter" {{ $isEdit && $associate->nominee_relation == 'granddaughter' ? 'selected' : '' }}>Granddaughter</option>
                                <option value="uncle" {{ $isEdit && $associate->nominee_relation == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                <option value="aunt" {{ $isEdit && $associate->nominee_relation == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                <option value="nephew" {{ $isEdit && $associate->nominee_relation == 'nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="niece" {{ $isEdit && $associate->nominee_relation == 'niece' ? 'selected' : '' }}>Niece</option>
                                <option value="father_in_law" {{ $isEdit && $associate->nominee_relation == 'father_in_law' ? 'selected' : '' }}>Father-in-law</option>
                                <option value="mother_in_law" {{ $isEdit && $associate->nominee_relation == 'mother_in_law' ? 'selected' : '' }}>Mother-in-law</option>
                                <option value="brother_in_law" {{ $isEdit && $associate->nominee_relation == 'brother_in_law' ? 'selected' : '' }}>Brother-in-law</option>
                                <option value="sister_in_law" {{ $isEdit && $associate->nominee_relation == 'sister_in_law' ? 'selected' : '' }}>Sister-in-law</option>
                                <option value="legal_heir" {{ $isEdit && $associate->nominee_relation == 'legal_heir' ? 'selected' : '' }}>Legal Heir</option>
                                <option value="guardian" {{ $isEdit && $associate->nominee_relation == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                <option value="other" {{ $isEdit && $associate->nominee_relation == 'other' ? 'selected' : '' }}>Other</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1 ">
                    <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4 uppercase">
                        Nominee Address
                    </label>
                    <div class="col-sm-7">
                        <div class="flex items-center gap-2">
                            <textarea id="nominee_address" name="nominee_address"
                                class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                placeholder="Enter Nominee Address">{{ $isEdit ? $associate->nominee_address : '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button class="btn-primary uppercase justify-center" type="submit">
                    {{ $isEdit ? 'UPDATE ASSOCIATE / ADVISOR' : 'ADD ASSOCIATE / ADVISOR' }}
                </button>

                <button class="btn-outline uppercase justify-center" type="reset">
                    <a href="{{ route('associates-advisor.associates-advisors.index') }}">BACK</a>
                </button>
                <!-- <button class="btn-warning uppercase justify-center" type="reset">
                        <a href="">RESET</a>
                    </button> -->
            </div>

        </form>

    </div>
</div>


<!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');
            const today = new Date();

            datepickers.forEach(function (dateInput) {
                // Initialize the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: today,
                });

                // Format today's date as dd-mm-yyyy
                const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate; // Set today's date by default

                // Optional: If there’s a calendar icon nearby, open picker on click
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
</script>

@endsection