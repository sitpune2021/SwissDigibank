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

    .tableWidth {
        width: 90%;
        margin: auto;

    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-start  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <h1 class="text-xl font-semibold">New MIS Account</h1>
            <p class="text-gray-500">
                <a href="{{route('misaccount.index')}}" class="text-gray-500 text-sm">MIS Accounts</a> >
                <a href="#" class="text-gray-500  text-sm"> New</a>
            </p>

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">
        <form action="{{ route('misaccount.store') }}" method="post">
            @csrf

            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Member
                        <span class="text-red-500">*</span>
                    </label>

                    <select id="member_id" name="member_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                        <option value="">Select member name</option>
                        @foreach ($members as $member)
                        <option value="{{ $member->id }}" data-fullname="{{ $member->member_info_first_name }}"
                            data-address="{{ $member->address->member_address_line_1 ?? '' }}"
                            data-branch="{{ $member->general_branch }}"
                            data-mobile="{{ $member->member_info_mobile_no ?? '' }}" {{ old('member_id') == $member->id ?
                                'selected' : '' }}>
                            {{ $member->member_info_first_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('member_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="member_name" class="md:text-lg font-medium block mb-4">Member Name</label>
                    <input type="text" id="selected_member_name" name="member_name"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize"
                        placeholder="Member Name" readonly>
                </div>
                @error('member_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <div class="col-span-2 md:col-span-1">
                    <label for="city" class="md:text-lg font-medium block mb-4">
                        Member Address

                    </label>

                    <input type="text" id="selected_member_address" name="member_address"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize"
                        placeholder="Member Address" value="" readonly>
                    @error('member_address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Member Mobile No.
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="" id=""
                            class=" text-sm bg-secondary/5 w-20 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3"
                            value="+91" disabled>


                        <input type="text" id="selected_member_mobile" name="member_mobile"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                            placeholder="Enter Mobile No " readonly>
                    </div>
                    @error('member_mobile')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="minor_id" class="md:text-lg font-medium block mb-4">
                        Minor

                    </label>
                    <div class="flex items-center gap-1 ">

                        <select id="minor_id" name="minor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                            <option value="">Select minor</option>
                            @foreach ($minors as $minor)
                            <option value="{{ $minor->id }}" data-member="{{ $minor->member_id }}"
                                style="display:none;">
                                {{ $minor->first_name }}
                            </option>
                            @endforeach
                        </select>



                    </div>
                    @error('minor_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-span-2 md:col-span-1 pt-3">
                    <label for="fd_scheme_id" class="md:text-lg font-medium block mb-4">
                        Schemes
                    </label>
                    <div class="flex items-center gap-1">
                        <select name="fd_scheme_id" id="fd_scheme_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                            <option value="">Select Scheme</option>
                            @foreach($schemes as $scheme)
                            <option value="{{ $scheme->id }}">
                                {{ $scheme->scheme_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('fd_scheme_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Branch
                        <span class="text-red-500">*</span>
                    </label>

                    <select id="branch_id" name="branch_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                        <option value="">Select branch</option>
                        @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">
                            {{ $branch->branch_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Advisor/ Staff

                    </label>

                    <select name="advisor_id" id="advisor_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                        <option value="">Select advisor</option>
                        <option value="1">Rahul Mehra</option>
                        <option value="2">Priya Sharma</option>
                        <option value="3">Ankit Verma</option>
                        <option value="4">Neha Iyer</option>
                        <option value="5">Amit Joshi</option>
                        <option value="6">Sneha Reddy</option>
                        <option value="7">Ravi Kapoor</option>
                        <option value="8">Kavita Nair</option>
                        <option value="9">Arjun Desai</option>
                        <option value="10">Pooja Singh</option>
                    </select>
                    @error('advisor_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Open Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="date" name="open_date" placeholder="DD/MM/YYYY"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 py-3 md:py-3">
                    @error('open_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Tenure Period
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="md:w-2/3 flex flex-row gap-2  my-2  space-y-2 md:flex-row md:space-y-0 md:space-x-2">
                        <input type="number" name="tenure_year" placeholder="Year"
                            class="w-full md:w-1/3 border bg-secondary/5  rounded-10 px-3 py-3 ">
                        <input type="number" name="tenure_month" placeholder="Month"
                            class="w-full md:w-1/3 border bg-secondary/5  rounded-10 px-3 py-3 ">

                        <input type="number" name="tenure_day" placeholder="Days"
                            class="w-full md:w-1/3 border bg-secondary/5  rounded-10 px-3 py-3 ">
                    </div>
                </div>
                @error('tenure_year')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @error('tenure_month')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @error('tenure_day')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="col-span-2 md:col-span-1">
                    <label for="misAmount" class="md:text-lg font-medium block mb-4">
                        MIS Amount <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="misAmount" name="mis_amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                        placeholder="0.0">
                    @error('mis_amount')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="interest_payout_type" class="md:text-lg font-medium block mb-4">
                        Interest Payout Type
                        <span class="text-error ">*</span>
                    </label>

                    <select name="interest_payout_type" id="interest_payout_type"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">

                        <option value="monthly" selected>Monthly</option>

                    </select>

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        TDS Deduction
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="tds_deduction" value="yes">
                            <span>Yes</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="tds_deduction" value="no">
                            <span>No</span>
                        </label>
                    </div>
                    @error('tds_deduction')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-span-2 md:col-span-1">
                    <label class="md:w-1/3 font-medium">Senior Citizen <span class="text-red-500 ">*</span></label>
                    <div class="md:w-2/3 my-2">
                        <!-- Hidden ensures "no" is submitted if unchecked -->
                        <input type="hidden" name="senior_citizen" value="no">
                        <input type="checkbox" name="senior_citizen" value="yes" class="w-5 h-5">
                    </div>
                </div>



                <div class="col-span-2 md:col-span-1">
                    <!--  Account Type -->
                    <label class="md:text-lg font-medium block mb-4">
                        Account Type <span class="text-red-500">*</span>
                    </label>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single" onclick="toggleSelect(false)"> Single
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint" onclick="toggleSelect(true)"> Joint
                            A/C
                        </label>
                    </div>

                    <!-- Select list (shown only if Joint A/C) -->
                    <div id="accountSelect" class="hidden mt-4">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Joint A/C Member <span class="text-red-500">*</span>
                        </label>
                        <select name="joint_member_id"
                            class="text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3  md:py-3 w-full">

                            <option value="">select member or name</option>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}" data-fullname="{{ $member->full_name }}"
                                data-address="{{ $member->address->member_address_line_1 ?? '' }}"
                                data-branch="{{ $member->general_branch }}"
                                data-mobile="{{ $member->member_info_mobile_no ?? '' }}" {{ old('member_id') == $member->
                                    id ?
                                    'selected' : '' }}>
                                {{ $member->full_name }}
                            </option>
                            @endforeach
                        </select>

                        @error('joint_member_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @error('account_type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>




                <!--  Nominee  -->
                <div class="mt-4 col-span-2 md:col-span-1 ">
                    <p class="font-medium">
                        Nominee
                        <span class="text-red-500">*</span>
                    </p>
                    <div class="flex items-center  gap-2">
                        <label class=" mt-2 flex items-center  gap-2">
                            <input type="radio" name="nominee" value="yes" onclick="toggleAddMore(true)"> Yes
                        </label>
                        <label class=" mt-2 flex items-center  gap-2">
                            <input type="radio" name="nominee" value="no" onclick="toggleAddMore(false)"> No
                        </label>
                    </div>


                    <!-- Add More Button -->

                    <div id="addMoreText" class="hidden mt-3">
                        <p class="text-blue-600 underline cursor-pointer uppercase" onclick="addNomineeInputs()">+ ADD
                            MORE NOMINEE</p>
                    </div>

                </div>
            </div>

            <div id="extraInputs" class="mt-3 w-full space-y-3"></div>

            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                <div class="col-span-2 md:col-span-1">
                    <label for="finalAmount" class="md:text-lg font-medium block mb-4">
                        Final Amount
                    </label>
                    <input type="text" id="finalAmount" name="final_amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                        placeholder="0" readonly>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        T. Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="date2" name="transaction_date" placeholder="DD/MM/YYYY"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3">
                    @error('transaction_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <!--Pay Mode-->
                <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">

                    <!-- Section Title -->
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Pay Mode 1</h4>

                    <!-- Amount Field -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                        <label for="" class="text-sm font-medium text-gray-700">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2">
                            <input type="number" id="amount" name="amount" placeholder="Enter Amount"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-white/5 ">

                        </div>
                    </div>

                    <!-- Pay Mode -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                        <label class="text-sm font-medium text-gray-700">
                            Pay Mode <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2 flex flex-wrap gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cash"
                                    class="text-green-500 focus:ring-green-500" checked>
                                <span class="text-sm text-gray-700">Cash</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cheque"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Cheque</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="online"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Online Tr.</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="saving"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Saving Ac.</span>
                            </label>
                        </div>
                    </div>
                    @error('pay_mode')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                    <!-- Cheque Fields -->
                    <div id="chequeFields" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Bank Name <span
                                    class="text-red-500">*</span></label>
                            <select name="bank_id"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                name="cheque_no" placeholder="Enter Cheque No.">
                        </div>
                        @error('cheque_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="date4" name="cheque_date"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                placeholder="DD/MM/YYYY">
                        </div>
                        @error('cheque_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Online Transaction Fields -->
                    <div id="onlineFields" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="date3" name="transfer_date"
                                class="w-full border rounded-10 px-3 py-3 dark:bg-bg3 text-sm bg-white"
                                placeholder="DD/MM/YYYY">
                        </div>
                        @error('transfer_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div>
                            <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" class="w-full border rounded-10 px-3 py-3 text-sm dark:bg-bg3 bg-white"
                                name="utr_no" placeholder="Enter Transaction No.">
                        </div>
                        @error('utr_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="imps"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="vpa"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="neft_rtgs"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>NEFT/RTGS</span>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Credited in Company Account <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="yes"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="no"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                        @error('credited')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div id="savingFields" class="space-y-4 mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700">
                            Select Saving Account <span class="text-red-500">*</span>
                        </label>

                        <!-- Saving Account Select -->
                        <select id="savingAccountSelect" name="saving_account_id"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-white mt-3">
                            <option value="">Select Account</option>
                        </select>

                        <!-- Balance Display -->
                        <div id="accountBalanceDiv" class="mt-3 hidden">
                            <label class="block text-sm font-medium text-gray-700">Account Balance</label>
                            <div id="accountBalance" class="p-3 text-sm font-semibold text-primary"></div>
                        </div>




                        <!-- pay mode 2-->


                    </div>


                </div>

            </div>
            <div class="flex flex-col sm:flex-row justify-center  gap-3 mt-5 w-full">
                <button type="submit" class=" sm:w-auto  justify-center btn-primary  uppercase " name="save">
                    open Mis
                </button>
                <button type="reset" class="sm:w-auto  justify-center uppercase btn-outline">
                    Reset
                </button>
                <button type="button" class=" sm:w-auto  justify-center uppercase btn-outline">
                    back
                </button>
            </div>
        </form>
    </div>

</div>



<!--Scripts here-->
<!--nomine -->
<script>
    //nomine
    function toggleSelect(show) {
        document.getElementById("accountSelect").classList.toggle("hidden", !show);
    }

    function toggleAddMore(show) {
        document.getElementById("addMoreText").classList.toggle("hidden", !show);
        if (!show) {
            document.getElementById("extraInputs").innerHTML = "";
        }
    }

    function addNomineeInputs() {
        const container = document.getElementById("extraInputs");
        const nomineeBlock = document.createElement("div");

        nomineeBlock.className = "nominee-item grid grid-cols-4 gap-2 items-center bg-gray-50 p-2 rounded-md shadow";
        nomineeBlock.innerHTML = `
                                            <div class="nominee-row flex flex-wrap items-start gap-6">
                                                <div class="flex-center flex-1 min-w-[200px] max-w-full">
                                                    <label class="font-medium mb-2">Relation<span class="text-red-500">*</span></label>
                                                    <select name="nominee_relation[]" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                                                        <option value="">Select Relation</option>
                                                        <option value="father">Father</option>
                                                        <option value="mother">Mother</option>
                                                        <option value="spouse">Spouse</option>

                                                    </select>
                                                </div>

                                                <div class="flex-1 min-w-[200px] max-w-full">
                                                    <label class="font-medium mb-2">Name <span class="text-red-500">*</span></label>
                                                    <input type="text" name="nominee_name[]" placeholder="Enter Nominee Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                                                </div>

                                                <div class="flex-1 min-w-[200px] max-w-full">
                                                    <label class="font-medium mb-2">Address <span class="text-red-500">*</span></label>
                                                    <input type="text" name="nominee_address[]" placeholder="Enter Nominee Address" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                                                </div>

                                                <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
                                                    <button type="button" onclick="removeNominee(this)" class="text-error font-bold text-lg hover:text-red-700">✕</button>
                                                </div>
                                            </div>`;
        container.appendChild(nomineeBlock);
    }

    function removeNominee(button) {
        const item = button.closest(".nominee-item");
        if (item) item.remove();

        const container = document.getElementById("extraInputs");

        // ✅ Keep container visible, just clear content if empty
        if (container.children.length === 0) {
            container.innerHTML = "";
        }
    }
</script>



<!--payment mode1-->
<script>
    //payment mode1
    const payModeRadios = document.querySelectorAll('input[name="pay_mode"]');
    const onlineFields = document.getElementById('onlineFields');
    const chequeFields = document.getElementById('chequeFields');
    const savingFields = document.getElementById('savingFields');

    payModeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            // hide all first
            onlineFields.classList.add('hidden');
            chequeFields.classList.add('hidden');
            savingFields.classList.add('hidden');

            // show based on selected
            if (radio.value === 'online') onlineFields.classList.remove('hidden');
            if (radio.value === 'cheque') chequeFields.classList.remove('hidden');
            if (radio.value === 'saving') savingFields.classList.remove('hidden');
        });
    });
</script>

{{--
    <script>
        //pay mode 2
        (function () {
            const payModeRadios2 = document.querySelectorAll('input[name="payMode2"]');
            const onlineFields2 = document.getElementById('onlineFields2');
            const chequeFields2 = document.getElementById('chequeFields2');
            const savingFields2 = document.getElementById('savingFields2');

            payModeRadios2.forEach(radio => {
                radio.addEventListener('change', () => {
                    onlineFields2.classList.add('hidden');
                    chequeFields2.classList.add('hidden');
                    savingFields2.classList.add('hidden');

                    if (radio.value === 'online') onlineFields2.classList.remove('hidden');
                    if (radio.value === 'cheque') chequeFields2.classList.remove('hidden');
                    if (radio.value === 'saving') savingFields2.classList.remove('hidden');
                });
            });
        })();
    </script> --}}

<script>
    //saving account amount show here
    document.getElementById('savingAccountSelect').addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let balance = selectedOption.getAttribute('data-balance');
        let balanceDiv = document.getElementById('accountBalanceDiv');
        let balanceText = document.getElementById('accountBalance');

        if (balance) {
            balanceText.textContent = "₹ " + balance;
            balanceDiv.classList.remove('hidden');
        } else {
            balanceText.textContent = "";
            balanceDiv.classList.add('hidden');
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('member_id');
        const nameInput = document.getElementById('selected_member_name');
        const addressInput = document.getElementById('selected_member_address');
        const mobileInput = document.getElementById('selected_member_mobile');

        function updateFields(option) {
            nameInput.value = option.getAttribute('data-fullname') || '';
            addressInput.value = option.getAttribute('data-address') || '';
            mobileInput.value = option.getAttribute('data-mobile') || '';
        }

        select.addEventListener('change', function() {
            updateFields(this.options[this.selectedIndex]);
        });

        // On load (e.g. after validation error)
        updateFields(select.options[select.selectedIndex]);
    });
</script>



<script>
    //branch
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('member_id');
        const minorSelect = document.getElementById('minor_id');
        const allMinorOptions = Array.from(minorSelect.querySelectorAll('option[data-member]'));

        function filterAndSelectMinor(memberId) {
            minorSelect.value = ''; // reset

            // Hide and disable all minors
            allMinorOptions.forEach(option => {
                option.style.display = 'none';
                option.disabled = true;
            });

            // Show minors for selected member
            const relatedMinors = allMinorOptions.filter(option => option.getAttribute('data-member') === memberId);

            if (relatedMinors.length > 0) {
                relatedMinors.forEach(option => {
                    option.style.display = 'block';
                    option.disabled = false;
                });
                // Automatically select the first minor
                minorSelect.value = relatedMinors[0].value;
            }
        }

        memberSelect.addEventListener('change', function() {
            filterAndSelectMinor(this.value);
        });

        // Optional: If member already selected on page load, run once
        if (memberSelect.value) {
            filterAndSelectMinor(memberSelect.value);
        }
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('member_id');
        const branchSelect = document.getElementById('branch_id');

        const allBranchOptions = Array.from(branchSelect.options).filter(opt => opt.value !== "");

        function updateBranchFromMember() {
            const selectedMember = memberSelect.options[memberSelect.selectedIndex];
            const branchId = selectedMember.getAttribute('data-branch');

            // Reset all options
            branchSelect.value = "";
            allBranchOptions.forEach(opt => {
                opt.style.display = 'none';
            });

            // Show and select the matching branch
            if (branchId) {
                const match = branchSelect.querySelector(`option[value="${branchId}"]`);
                if (match) {
                    match.style.display = 'block';
                    branchSelect.value = branchId;
                }
            }
        }

        memberSelect.addEventListener('change', updateBranchFromMember);

        // Optional: pre-fill on page load
        if (memberSelect.value) {
            updateBranchFromMember();
        }
    });
</script>

<script>
    document.getElementById('misAmount').addEventListener('input', function() {
        let misValue = this.value;

        // set Final Amount
        document.getElementById('finalAmount').value = misValue;

        // set Amount
        document.getElementById('amount').value = misValue;
    });
</script>
<script>
    const radios = document.querySelectorAll('input[name="pay_mode"]');
    const savingFields = document.getElementById('savingFields');
    const savingSelect = document.getElementById('savingAccountSelect');
    const balanceDiv = document.getElementById('accountBalanceDiv');
    const balanceText = document.getElementById('accountBalance');

    // Show/hide Saving Account section based on radio
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'saving') {
                savingFields.classList.remove('hidden');

                // Restore previous selection if exists
                let savedBalance = localStorage.getItem('selected_balance');
                let savedAccount = localStorage.getItem('selected_account');

                if (savedBalance && savedAccount) {
                    savingSelect.value = savedAccount;
                    balanceText.textContent = "₹ " + savedBalance;
                    balanceDiv.classList.remove('hidden');
                }
            } else {
                savingFields.classList.add('hidden');
                balanceDiv.classList.add('hidden');
            }
        });
    });

    // Handle saving account select
    savingSelect.addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        let balance = selectedOption.getAttribute('data-balance');

        if (balance) {
            balanceText.textContent = "₹ " + balance;
            balanceDiv.classList.remove('hidden');
            localStorage.setItem('selected_balance', balance);
            localStorage.setItem('selected_account', this.value);
        } else {
            balanceText.textContent = "";
            balanceDiv.classList.add('hidden');
            localStorage.removeItem('selected_balance');
            localStorage.removeItem('selected_account');
        }
    });

    // Restore on page reload
    window.addEventListener('DOMContentLoaded', function() {
        let savedPayMode = document.querySelector('input[name="pay_mode"]:checked');
        let savedBalance = localStorage.getItem('selected_balance');
        let savedAccount = localStorage.getItem('selected_account');

        if (savedPayMode && savedPayMode.value === 'saving') {
            savingFields.classList.remove('hidden');
            if (savedBalance && savedAccount) {
                savingSelect.value = savedAccount;
                balanceText.textContent = "₹ " + savedBalance;
                balanceDiv.classList.remove('hidden');
            }
        }
    });
</script>


<script>
    // saving account selection by members

    document.getElementById('member_id').addEventListener('change', function() {
        let memberId = this.value;
        let accountSelect = document.getElementById('savingAccountSelect');
        accountSelect.innerHTML = '<option value="">Select Account</option>'; // reset

        if (memberId) {
            fetch(`/misaccount/member/${memberId}/accounts`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(account => {
                        let option = document.createElement('option');
                        option.value = account.id;
                        option.textContent = account.account_no;
                        option.setAttribute('data-balance', account.amount_deposit);
                        accountSelect.appendChild(option);
                    });
                });
        }
    });

    // Show balance when account is selected
    document.getElementById('savingAccountSelect').addEventListener('change', function() {
        let balanceDiv = document.getElementById('accountBalanceDiv');
        let balanceSpan = document.getElementById('accountBalance');
        let selectedOption = this.options[this.selectedIndex];
        let balance = selectedOption.getAttribute('data-balance');

        if (balance) {
            balanceDiv.classList.remove('hidden');
            balanceSpan.textContent = balance;
        } else {
            balanceDiv.classList.add('hidden');
        }
    });
</script>


@endsection