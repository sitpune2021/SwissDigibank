@extends('layout.main')
@section('page-title', isset($employee) ? (!empty($show) ? 'VIEW ' . $employee->name . ' EMPLOYEE' : 'EDIT ' .
    $employee->name . ' EMPLOYEE') : 'ADD EMPLOYEE')
@section('content')
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;

        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
        }
    </style>

    <div class="main-inner">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">

            <!-- <h3 class="h2">NEW EMPLOYEE</h3> -->

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
            <form id="companyForm"
                action="{{ isset($employee) ? ($show ?? false ? '#' : route('employee.update', base64_encode($employee->id))) : route('employee.store') }}"
                method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if (isset($employee) && empty($show))
                    @method('PUT')
                @endif
                @php $isView = !empty($show); @endphp
                <div class="col-span-2 md:col-span-1">
                    <label for="member" class="md:text-lg font-medium block mb-4 uppercase">Link Customer Profile
                        <input type="hidden" id="selectedMemberId"
                            value="{{ isset($employee) ? $employee->member_id : '' }}">
                        @if (isset($isView) && $isView)
                            {{-- View Mode: Just display the customer name --}}
                            <input type="text" value="{{ $employee->members->member_info_first_name ?? 'N/A' }}"
                                @if ($isView) disabled @endif
                                class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @else
                            <select name="member" id="memberDropdown"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                @if ($isView) disabled @endif>
                                <option value="">Select Customer</option>
                                <!-- Dynamic options here -->
                            </select>

                            @error('member')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        @endif

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="branch" class="md:text-lg font-medium block mb-4 uppercase">Branch<span
                            class="text-red-500">*</span></label>
                    <input type="hidden" id="selectedBranchId" value="{{ isset($employee) ? $employee->branch_id : '' }}">
                    @if (isset($isView) && $isView)
                        {{-- View Mode: Just display the member name --}}
                        <input type="text" value="{{ $employee->branches->branch_name ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="branch" id="branchDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            @if ($isView) disabled @endif>
                            <option value="">Select</option>
                            <!-- Dynamic options here -->
                        </select>

                        @error('branch')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="col-span-2 md:col-span-1">

                    <!-- <label for="joining_date" class="md:text-lg font-medium block mb-4">Joining Date<span

                                    class="text-red-500">*</span></label>

                            <div class="relative">

                                <input name="joining_date" id="date2" type="text" placeholder="DD/MM/YYYY"
                                    value="{{ old('joining_date', $employee->joining_date ?? '') }}"
                                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" autocomplete="off" @if ($isView) disabled @endif>
                                <i

                                    class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>

                            </div>

                            @error('joining_date')
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror -->

                    <x-datepicker-disabled label="JOINING DATE" name="joining_date" value="{{ old('joining_date') }}"
                        inputId="joining_date" />


                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="name" class="md:text-lg font-medium block mb-4 uppercase">Designation</span></label>

                    <input type="text" name="designation" id="designation"
                        placeholder="Enter Designation like 'Executive'"
                        value="{{ old('designation', $employee->designation ?? '') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        @if ($isView) disabled @endif>

                    @error('designation')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="name" class="md:text-lg font-medium block mb-4 uppercase">Name</span><span
                            class="text-red-500">*</span></label>

                    <input type="text" name="name" id="name" placeholder="Enter Name"
                        value="{{ old('name', $employee->name ?? '') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        @if ($isView) disabled @endif>

                    @error('name')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="gender" class="block mb-4 font-medium md:text-lg uppercase">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-4 mt-4">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="gender" value="male"
                                {{ old('gender', $employee->gender ?? '') == 'male' ? 'checked' : '' }}
                                @if ($isView) disabled @endif>
                            <span> Male</span>
                        </label>

                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="gender" value="female"
                                {{ old('gender', $employee->gender ?? '') == 'female' ? 'checked' : '' }}
                                @if ($isView) disabled @endif>
                            <span>Female</span>
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="gender" value="other"
                                {{ old('gender', $employee->gender ?? '') == 'other' ? 'checked' : '' }}
                                @if ($isView) disabled @endif>
                            <span>Other</span>
                        </label>
                    </div>
                    @error('gender')
                        <span class="block mt-2 text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <x-datepicker-disabled label="DATE OF BIRTH" name="dob" value="{{ old('dob') }}"
                        inputId="dob" />
                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="email" class="md:text-lg font-medium block mb-4 uppercase">Email</span></label>

                    <input type="text" name="email" placeholder="Enter Email" id="email"
                        value="{{ old('email', $employee->email ?? '') }}"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        @if ($isView) disabled @endif>

                    @error('email')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="mobile_no" class="md:text-lg font-medium block mb-4 uppercase">Mobile No.<span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-2">
                        <input type="text"
                            class="text-sm bg-secondary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                            value="+91" readonly>
                        <input type="text" name="mobile_no" id="mobile_no" type="number" maxlength="10"
                            minlength="10" placeholder="Enter Mobile No"
                            value="{{ old('mobile_no', $employee->mobile_no ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            @if ($isView) disabled @endif>
                    </div>
                    @error('mobile_no')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="address" class="md:text-lg font-medium block mb-4 uppercase">Address</label>

                    <input type="text" name="address" id="address" placeholder="Enter Address"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('address', $employee->address ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('address')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="father_name" class="md:text-lg font-medium block mb-4 uppercase">Father Name</label>

                    <input type="text" name="father_name" id="father_name" placeholder="Enter Father Name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('father_name', $employee->father_name ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('father_name')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="pan_no" class="md:text-lg font-medium block mb-4 uppercase">PAN No.</label>

                    <input type="text" name="pan_no" id="pan_no" placeholder="Enter PAN No"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('pan_no', $employee->pan_no ?? '') }}"
                        @if ($isView) disabled @endif minlength="10" maxlength="10"
                        pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}"
                        title="PAN number must be 10 characters: 5 letters, 4 digits, 1 letter">

                    @error('pan_no')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="aadhar_no" class="md:text-lg font-medium block mb-4 uppercase">Aadhaar No.</label>

                    <input type="text" name="aadhar_no" id="aadhar_no" placeholder="Enter Aadhar No" maxlength="12"
                        inputmode="numeric"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('aadhar_no', $employee->aadhar_no ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('aadhar_no')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="blood_group" class="md:text-lg font-medium block mb-4 uppercase">Blood Group</label>
                    <input type="hidden" id="selectedBloodId"
                        value="{{ isset($employee) ? $employee->blood_group : '' }}">
                    @if (isset($isView) && $isView)
                        {{-- View Mode: Just display the member name --}}
                        <input type="text" value="{{ $employee->bloodgroups->group ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="blood_group" id="bloodGroupDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                            <option value="">Select Blood Group</option>

                        </select>

                        @error('blood_group')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    @endif

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="monthly_salary" class="md:text-lg font-medium block mb-4 uppercase">Monthly Salary</label>

                    <input type="number" name="monthly_salary" id="monthly_salary" placeholder="Enter Monthly Salary"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('monthly_salary', $employee->monthly_salary ?? '') }}"
                        @if ($isView) disabled @endif>

                    <x-number-to-word for="monthly_salary" />

                    @error('monthly_salary')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="location" class="md:text-lg font-medium block mb-4 uppercase">Location</label>

                    <input type="text" name="location" id="location" placeholder="Enter Location"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('location', $employee->location ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('location')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>
                <h4 class="uppercase">Bank Info</h4> <br>
                <div class="col-span-2 md:col-span-1">

                    <label for="account_holder" class="md:text-lg font-medium block mb-4 uppercase">Bank A/c Holder's
                        Name</label>

                    <input type="text" name="account_holder" id="account_holder" placeholder="Enter Account Holder"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('account_holder', $employee->account_holder ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('account_holder')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="bank_name" class="md:text-lg font-medium block mb-4 uppercase">Bank Name</label>
                    @if (isset($isView) && $isView)
                        {{-- View Mode: Just display the member name --}}
                        <input type="text" value="{{ $employee->bankname->name ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="bank_name" id="bankDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border rounded-10 border-n30 dark:border-n500 px-3 md:px-6 py-2 md:py-3">

                            <option value="">Select Bank</option>

                        </select>

                        @error('bank_name')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="account_no" class="md:text-lg font-medium block mb-4 uppercase">Bank Account No</label>

                    <input type="number" name="account_no" id="account_holder" placeholder="Enter Bank A/C No"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('account_no', $employee->account_no ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('account_no')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="ifsc" class="md:text-lg font-medium block mb-4 uppercase">Bank IFSC</label>

                    <input type="text" name="ifsc" id="ifsc" placeholder="Enter IFSC Code"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('ifsc', $employee->ifsc ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('ifsc')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <h4 class="uppercase">Nominee Info</h4><br>

                <div class="col-span-2 md:col-span-1">

                    <label for="nominee_name" class="md:text-lg font-medium block mb-4 uppercase">Nominee Name</label>

                    <input type="text" name="nominee_name" id="nominee_name" placeholder="Enter Nominee Name"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('nominee_name', $employee->nominee_name ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('nominee_name')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="nominee_relation" class="md:text-lg font-medium block mb-4 uppercase">Nominee
                        Relation</label>
                    <input type="hidden" id="selectedRelationId"
                        value="{{ isset($employee) ? $employee->nominee_relation : '' }}">

                    @if (isset($isView) && $isView)
                        {{-- View Mode: Just display the member name --}}
                        <input type="text" value="{{ $employee->nominee_relations->relation ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="nominee_relation" id="nomineeDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 rounded-10 border border-n30 dark:border-n500 px-3 md:px-6 py-2 md:py-3">

                            <option value="">Select Relation</option>

                        </select>

                        @error('nominee_relation')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    @endif

                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="nominee_address" class="md:text-lg font-medium block mb-4 uppercase">Nominee
                        Address</label>

                    <input type="text" name="nominee_address" id="nominee_address"
                        placeholder="Enter Nominee Address"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="{{ old('nominee_address', $employee->nominee_address ?? '') }}"
                        @if ($isView) disabled @endif>

                    @error('nominee_address')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>
                <br>

                <h4 class="uppercase">Link With Software Accounting</h4><br>

                <div class="col-span-2 md:col-span-1">

                    <label for="nominee_address" class="md:text-lg font-medium block mb-4 uppercase">Auto Generate Payable
                        Ledger</label>

                    <input type="checkbox" name="auto_generate" id="auto_generate_checkbox"
                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        value="true"
                        style="height: 17px; width: 17px; margin: 0px; margin-top: -2px; vertical-align: middle;"
                        {{ !empty($employee) && $employee->auto_generate ? 'checked' : '' }}
                        {{ !empty($isView) && $isView ? 'disabled' : '' }}>

                    <span class="ft-600 co-red" id="ledger_note" style="color: red;">( Check this for auto generate
                        )</span>

                    @error('nominee_address')
                        <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">
                    <input type="hidden" id="selectedledgerId"
                        value="{{ isset($employee) ? $employee->payable_ledger : '' }}">


                    <label for="payable_ledger" class="md:text-lg font-medium block mb-4 uppercase">Linked Accounting
                        Payable Ledger</label>
                    @if (isset($isView) && $isView)
                        <input type="text" value="{{ $employee?->payableLedgers?->name ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="payable_ledger" id="payableDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                            <option value="">Select Accounting Payable Ledger</option>

                        </select>

                        @error('payable_ledger')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>

                <div class="col-span-2 md:col-span-1">

                    <label for="expense_ledger" class="md:text-lg font-medium block mb-4 uppercase">Linked Accounting
                        Expense Ledger</label>
                    @if (isset($isView) && $isView)
                        <input type="text" value="{{ $employee->payableExpenses?->name ?? 'N/A' }}"
                            @if ($isView) disabled @endif
                            class="w-full text-sm bg-gray-100 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @else
                        <select name="expense_ledger" id="expenseDropdown"
                            class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                            <option value="">Select Accounting Expense Ledger</option>

                        </select>

                        @error('expense_ledger')
                            <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
        </div>

        <div class="col-span-2 flex gap-4 md:gap-6 mt-2 uppercase">

            @if (empty($isView))
                <button class="btn-primary uppercase" type="submit">
                    {{ isset($employee) ? 'Update Employee' : 'Add Employee' }}
                </button>
            @endif

            @if (!isset($employee))
                <button class="btn-outline uppercase" type="reset"
                    onclick="document.getElementById('companyForm').reset();">
                    Reset
                </button>
            @endif

            <button class="btn-outline uppercase" type="reset"
                onclick="window.location.href='{{ route('employee.index') }}'">
                Back
            </button>

        </div>

        </form>

    </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        setTimeout(function() {

            var successAlert = document.getElementById('success-alert');

            var errorAlert = document.getElementById('error-alert');

            if (successAlert) successAlert.style.display = 'none';

            if (errorAlert) errorAlert.style.display = 'none';

        }, 5000);
    </script>

    <script>
        $(document).ready(function() {
            const selectedId = $('#selectedMemberId').val();
            $.ajax({
                url: "{{ url('/get-members') }}",
                type: 'GET',
                success: function(response) {
                    let dropdown = $('#memberDropdown');
                    dropdown.empty();
                    dropdown.append('<option value="">Select Member</option>');

                    $.each(response, function(index, member) {
                        console.log(member);
                        let selected = (selectedId == member.id) ? 'selected' : '';
                        dropdown.append(
                            `<option value="${member.id}" ${selected}> ${member.member_info_first_name+' '+member.member_info_last_name}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Failed to load members and promoers.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedBranchId = $('#selectedBranchId').val();
            $.ajax({
                url: "{{ url('/get-branches') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#branchDropdown');
                    dropdown.empty();
                    dropdown.append('<option value="">Select Branch</option>');

                    $.each(response, function(index, branch) {
                        let selected = (selectedBranchId == branch.id) ? 'selected' : '';
                        dropdown.append(
                            `<option value="${branch.id}" ${selected}>${branch.branch_code} - ${branch.branch_name}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch branches.');
                }
            });
        });
    </script>
    <script>
        const selectedRelationId = $('#selectedRelationId').val();
        $(document).ready(function() {
            $.ajax({
                url: "{{ url('/get-relation') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#nomineeDropdown');
                    dropdown.empty();
                    dropdown.append('<option value="">Select Relationship</option>');

                    $.each(response, function(index, relation) {
                        let selected = (selectedRelationId == relation.id.toString()) ?
                            'selected' : '';
                        dropdown.append(
                            `<option value="${relation.id}" ${selected}>${relation.relation}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch relations.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedId = $('#selectedBankId').val();
            $.ajax({
                url: "{{ url('/get-bank') }}",
                type: "GET",
                success: function(response) {
                    $.each(response, function(key, bank) {
                        $('#bankDropdown').append(
                            `<option value="${bank.id}">${bank.name}</option>`);
                    });
                    // console.log(response.id);
                },
                error: function() {
                    alert('Failed to fetch banks.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedId = $('#selectedexpenseId').val();
            $.ajax({
                url: "{{ url('/get-payable-expense') }}",
                type: "GET",
                success: function(response) {
                    $.each(response, function(key, expense) {
                        $('#expenseDropdown').append(
                            `<option value="${expense.id}">${expense.name}</option>`);
                    });
                },
                error: function() {
                    alert('Failed to fetch banks.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedledgerId = $('#selectedledgerId').val();
            $.ajax({
                url: "{{ url('/get-payable-ledger') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#payableDropdown');
                    dropdown.empty();
                    dropdown.append('<option value="">Select Accounting Payable Ledger</option>');
                    // console.log("Selected ID:", selectedledgerId);
                    // console.log(response);

                    $.each(response, function(key, ledger) {
                        // let selected = (selectedledgerId == ledger.id) ? 'selected' : '';
                        let selected = (selectedledgerId.toString() === ledger.id.toString()) ?
                            'selected' : '';
                        dropdown.append(
                            `<option value="${ledger.id}" ${selected}>${ledger.name}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch banks.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectedBloodId = $('#selectedBloodId').val();
            $.ajax({
                url: "{{ url('/get-blood-group') }}",
                type: "GET",
                success: function(response) {
                    let dropdown = $('#bloodGroupDropdown');
                    dropdown.empty();
                    dropdown.append('<option value="">Select Blood Group</option>');

                    $.each(response, function(index, blood) {
                        let selected = (selectedBloodId == blood.id.toString()) ? 'selected' :
                            '';
                        dropdown.append(
                            `<option value="${blood.id}" ${selected}>${blood.group}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Failed to fetch banks.');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.getElementById("auto_generate_checkbox");
            const ledgerDropdown = document.getElementById("payableDropdown");

            // Function to toggle ledger dropdown based on checkbox state
            function toggleLedgerDropdown() {
                if (checkbox.checked) {
                    ledgerDropdown.disabled = true;
                } else {
                    ledgerDropdown.disabled = false;
                }
            }
            toggleLedgerDropdown();

            checkbox.addEventListener("change", toggleLedgerDropdown);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileFields = ['mobile_no'];

            mobileFields.forEach(function(id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('input', function() {
                        // Allow only digits
                        this.value = this.value.replace(/\D/g, '');

                        // Limit to 10 digits
                        if (this.value.length > 10) {
                            this.value = this.value.slice(0, 10);
                        }
                    });
                }
            });
        });
    </script>
    <script>
        document.getElementById('pan_no').addEventListener('input', function() {
            let value = this.value.toUpperCase();

            value = value.replace(/[^A-Z0-9]/g, '');

            if (value.length > 10) {
                value = value.slice(0, 10);
            }

            this.value = value;

            const panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            if (!panPattern.test(value) && value.length === 10) {
                this.setCustomValidity("Invalid PAN format. Example: ABCDE1234F");
            } else {
                this.setCustomValidity("");
            }
        });

        document.getElementById('aadhar_no').addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');

            if (value.length > 12) {
                value = value.slice(0, 12);
            }

            this.value = value;

            if (value.length !== 12) {
                this.setCustomValidity("Aadhar must be exactly 12 digits.");
            } else {
                this.setCustomValidity("");
            }
        });
    </script>


@endsection
