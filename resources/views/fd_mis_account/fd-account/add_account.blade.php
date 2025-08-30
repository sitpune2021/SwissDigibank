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
            <h1 class="text-xl font-semibold">New FD Account</h1>
        </div>
    </div>

    <div class="col-span-12 box lg:col-span-12">
        <form method="post" action="{{route('fd-mis-schemes.fd_store')}}">
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">
                        Member <span class="text-red-500">*</span>
                    </label>
                    <select id="member_id" name="member_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3" required>
                        <option value="">Select member</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->member_info_first_name }}</option>
                        @endforeach
                    </select>
                    @error('member_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Member Name</label>
                    <input type="text" id="member_name"
                        placeholder="Enter Name"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3" disabled>
                    @error('member_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Member Address</label>
                    <input type="text" id="member_address"
                        placeholder="Enter Address"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3" disabled>
                    @error('member_address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Member Mobile No.</label>
                    <div class="flex gap-2">
                        <input type="text" class="text-sm bg-secondary/5 w-20 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3" value="+91" disabled>
                        <input type="text" id="member_mobile"
                            placeholder="Enter Mobile"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3" disabled>
                        @error('member_mobile')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Minor</label>
                    <select id="minor_id" name="minor_id" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3">
                        <option value="">Select minor</option>
                    </select>
                    @error('minor_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1 pt-3 ">
                    <p class="text-blue-500">
                    </p>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Branch
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="branch_id" id="branch_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3">
                        <option value="">select branch</option>
                    </select>
                    @error('branch_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Advisor/ Staff
                    </label>
                    <select name="advisor_staff" id="advisor_staff"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3">
                        <option value="">select associate/user code</option>
                        <option value="1">ABC</option>
                        <option value="2">XYZ</option>
                    </select>
                    @error('advisor_staff')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Open Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="date" name="date" placeholder="DD/MM/YYYY"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3">
                    @error('date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- <div class="col-span-2 md:col-span-1">
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
                </div> -->

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Scheme
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="scheme_id" name="scheme_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3">
                        <option value="">Select Scheme</option>
                        @foreach($schemes as $scheme)
                        <option value="{{ $scheme->id }}">{{ $scheme->scheme_name }}</option>
                        @endforeach
                    </select>
                    @error('scheme_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        FD Amount
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="fd_amount" name="fd_amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                        placeholder="0.0">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Interest Payout Type
                    </label>

                    <select name="payout" id="payout"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3">
                        <option value="Cumulative Yearly">Cumulative Yearly</option>
                        <option value="Cumulative Half Yearly">Cumulative Half Yearly</option>
                        <option value="Cumulative Quarterly">Cumulative Quarterly</option>
                        <option value="Cumulative Monthly">Cumulative Monthly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Half Yearly">Half Yearly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        TDS Deduction
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="tds_deduction" value="1">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="tds_deduction" value="0" selected>
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:w-1/3 font-medium">Senior Citizen <span class="text-red-500 ">*</span></label>
                    <div class="md:w-2/3 my-2 ">
                        <input type="checkbox" name="senior_citizen" value="1" class="w-5 h-5" checked>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <!-- Step 1 -->
                    <label class="md:text-lg font-medium block mb-4">
                        Account Type <span class="text-red-500">*</span>
                    </label>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="single" onclick="toggleSelect(false)"> Single
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="account_type" value="joint" onclick="toggleSelect(true)"> Joint A/C
                        </label>
                    </div>

                    <!-- Select list (shown only if Joint A/C) -->
                    <div id="accountSelect" class="hidden mt-4">
                        <label for="" class="md:text-lg font-medium block mb-4">
                            Joint A/C Member <span class="text-red-500">*</span>
                        </label>
                        <select name="joint_member_id"
                            class="text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3  md:py-3 w-full">

                            <option value="">select member or name</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->member_info_first_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!--  Nominee  -->
                <div class="mt-4 col-span-2 md:col-span-1 ">

                    <p class="font-medium">
                        Nominee
                        <span class="text-red-500">*</span>
                    </p>
                    <div class="flex items-center  gap-2">
                        <label class=" mt-2 flex items-center  gap-2">
                            <input type="radio" name="nominees" value="yes" onclick="toggleAddMore(true)"> Yes
                        </label>
                        <label class=" mt-2 flex items-center  gap-2">
                            <input type="radio" name="nominees" value="no" onclick="toggleAddMore(false)"> No
                        </label>
                    </div>

                    <!-- Add More Button -->
                    <div id="addMoreText" class="hidden mt-3">
                        <p class="text-blue-600 underline cursor-pointer uppercase" onclick="addNomineeInputs()">+ ADD MORE NOMINEE</p>
                    </div>

                </div>
            </div>

            <div id="extraInputs" class="mt-3 w-full space-y-3"></div>

            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Final Amount
                    </label>

                    <input type="text" id="final_amount" name="final_amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                        placeholder="0" value="">
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        T. Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="date2" name="transaction_date" placeholder="DD/MM/YYYY" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6 
                            py-3 md:py-3">
                </div>

                <!-- pay mode 1-->
                <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">
                    <!-- Section Title -->
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Pay Mode 1</h4>
                    <!-- Amount Field -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                        <label for="" class="text-sm font-medium text-gray-700">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2">
                            <input type="number" id="pay1_amount" name="pay1_amount" placeholder="Enter Amount"
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
                                <input type="radio" name="pay1_mode" id="payMode" value="cash" checked
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Cash</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay1_mode" value="cheque" id="payMode"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Cheque</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay1_mode" value="online" id="payMode"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Online Tr.</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay1_mode" value="saving" id="payMode"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Saving Ac.</span>
                            </label>
                        </div>
                    </div>

                    <!-- Cheque Fields -->
                    <div id="chequeFields" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Bank Name <span
                                    class="text-red-500">*</span></label>
                            <select name="pay1_bank" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
                                <option value="">Select Bank</option>
                                <option value="SBI">SBI</option>
                                <option value="HDFC">HDFC</option>
                                <option value="ICICI">ICICI</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay1_cheque_no" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                placeholder="Enter Cheque No.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="date4" name="pay1_cheque_date"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                placeholder="DD/MM/YYYY">
                        </div>
                    </div>

                    <!-- Online Transaction Fields -->
                    <div id="onlineFields" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" id="date3" name="pay1_transfer_date"
                                class="w-full border rounded-10 px-3 py-3 dark:bg-bg3 text-sm bg-white"
                                placeholder="DD/MM/YYYY">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay1_transfer_utr" class="w-full border rounded-10 px-3 py-3 text-sm dark:bg-bg3 bg-white"
                                placeholder="Enter Transaction No.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode" value="neft"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode" value="rtgs"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode" value="upi"
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
                    </div>

                    <!-- Saving Account Fields -->
                    <div id="savingFields" class="space-y-4 hidden mt-3">
                        <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                                class="text-red-500">*</span></label>
                        <select class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white saving-account">
                            <option value="">Select Account</option>
                            @foreach($savings as $saving)
                            <option value="{{ $saving->id }}">{{ $saving->account_no  }}</option>
                            @endforeach
                        </select>
                        <span id="accountBalance" style="color:red"></span>
                        <span id="accountBalance2" style="color:red"></span>
                        <!-- Balance display -->
                    </div>
                </div>

                <!-- pay mode 2-->
                <!-- <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">
                
                    <h4 class="text-lg font-semibold dark:text-white  text-gray-800 mb-2">Pay Mode 2</h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                        <label for="pay2_amount" class="text-sm font-medium text-gray-700">
                            Amount <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2">
                            <input type="number" id="" name="pay2_amount" placeholder="Enter Amount"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-gray-50 ">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                        <label class="text-sm font-medium text-gray-700">
                            Pay Mode <span class="text-red-500">*</span>
                        </label>
                        <div class="md:col-span-2 flex flex-wrap gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payMode2" value="cash"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Cash</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payMode2" value="cheque"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Cheque</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payMode2" value="online"
                                    class="text-green-500 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Online Tr.</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payMode2" value="saving"
                                    class="text-green-600 focus:ring-green-500">
                                <span class="text-sm text-gray-700">Saving Ac.</span>
                            </label>
                        </div>
                    </div>

          
                    <div id="chequeFields2" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Bank Name<span
                                    class="text-red-500">*</span></label>
                            <select name="bank_name" class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                                <option value="">Select Bank</option>
                                <option value="SBI">SBI</option>
                                <option value="HDFC">HDFC</option>
                                <option value="ICICI">ICICI</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay2_chq_no" class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white"
                                placeholder="Enter Cheque No.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cheque Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay2_chq_date" id="date5" placeholder="DD/MM/YYYY"
                                class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                        </div>
                    </div>

                    <div id="onlineFields2" class="space-y-4 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Transfer Date <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay2_transfer_date" id="date6" placeholder="DD/MM/YYYY"
                                class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="pay2_transaction_no" class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white"
                                placeholder="Enter Transaction No.">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                    class="text-red-500">*</span></label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode2" value="imps"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode2" value="vpa"
                                        class="text-green-500 focus:ring-green-500">
                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transferMode2" value="neft"
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
                                    <input type="radio" name="credited2" value="1"
                                        class="text-green-600 focus:ring-green-500">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited2" value="0"
                                        class="text-green-600 focus:ring-green-500">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="savingFields2" class="space-y-4 hidden mt-3">
                        <label class="block text-sm font-medium text-gray-700">Select Saving Account <span
                                class="text-red-500">*</span></label>
                        <select name="saving_ac" class="w-full border rounded-10 px-3 py-3 text-sm  dark:bg-bg3 bg-white">
                            <option value="">Select Account</option>
                            <option value="Account 1">Account 1</option>
                            <option value="Account 2">Account 2</option>
                        </select>
                    </div>
                </div> -->
            </div>

            <div class="flex flex-col sm:flex-row justify-center  gap-3 mt-5 w-full">
                <button type="submit" class=" sm:w-auto  justify-center btn-primary uppercase open_fd">
                    open fd
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

</div>


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
            nomineeIndex = 0;
        }

    }

    function addNomineeInputs() {
        const container = document.getElementById("extraInputs");
        const nomineeBlock = document.createElement("div");

        //  Added nominee-item class here
        nomineeBlock.className = "nominee-item grid grid-cols-4 gap-2 items-center bg-gray-50 p-2 rounded-md shadow";

        nomineeBlock.innerHTML = `
        <div class="nominee-row flex  flex-wrap items-start gap-6">
            <div class="flex-center  flex-1 min-w-[200px] max-w-full">
                <label class="font-medium mb-2">Relation <span class="text-red-500">*</span></label>
                <select name="nominee_relation[]" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                               rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">Select Relation</option>
                    <option>Father</option>
                    <option>Mother</option>
                    <option>Spouse</option>
                    <option>Son</option>
                    <option>Daughter</option>
                    <option>Brother</option>
                    <option>Sister</option>
                    <option>Grandfather</option>
                    <option>Grandmother</option>
                    <option>Uncle</option>
                    <option>Aunt</option>
                    <option>Cousin</option>
                    <option>Nephew</option>
                    <option>Niece</option>
                    <option>Father-in-law</option>
                    <option>Mother-in-law</option>
                    <option>Brother-in-law</option>
                    <option>Sister-in-law</option>
                    <option>Son-in-law</option>
                    <option>Daughter-in-law</option>
                    <option>Guardian</option>
                    <option>Friend</option>
                    <option>Other</option>
                </select>
            </div>

            <div class="flex-1 min-w-[200px]  max-w-full">
                <label class="font-medium mb-2">Name <span class="text-red-500">*</span></label>
                <input type="text" placeholder="Enter Nominee Name" name="nominee_name[]"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                    rounded-10 px-3 md:px-6 py-2 md:py-3">
            </div>

            <div class="flex-1 min-w-[200px]  max-w-full">
                <label class="font-medium mb-2">Address <span class="text-red-500">*</span></label>
                <input type="text" placeholder="Enter Nominee Address" name="nominee_address[]"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500
                    rounded-10 px-3 md:px-6 py-2 md:py-3">
            </div>

            <div class="flex-1 min-w-[60px]  max-w-full flex justify-end items-center">
                <button type="button" onclick="removeNominee(this)"
                    class="text-error font-bold  text-lg hover:text-red-700">✕</button>
            </div>
        </div> `;

        container.appendChild(nomineeBlock);
        nomineeIndex++;
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
    const payModeRadios = document.querySelectorAll('input[name="pay1_mode"]');
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


<script>
    //pay mode 2
    (function() {
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
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    const membersData = @json($membersData);

    $(document).ready(function() {
        $('#member_id').on('change', function() {
            const memberId = $(this).val();
            const member = membersData[memberId];

            if (memberId) {
                $.ajax({
                    url: "{{ route('member.savings', '') }}/" + memberId,
                    type: "GET",
                    dataType: "json",
                    success: function(savings) {
                        console.log(savings);
                        let savingSelect = $("#savingAccount");
                        savingSelect.empty(); // clear old options
                        savingSelect.append('<option value="">Select Account</option>');

                        if (savings.length > 0) {
                            $.each(savings, function(i, saving) {
                                savingSelect.append('<option value="' + saving.id + '">' + saving.account_no + '</option>');
                            });

                            $("#savingFields").removeClass("hidden"); // show div
                        } else {
                            $("#savingFields").addClass("hidden"); // hide if no savings
                        }
                    },
                    error: function() {
                        alert("Error loading saving accounts");
                    }
                });
            } else {
                $("#savingFields").addClass("hidden");
            }

            // console.log(member);
            if (member) {
                $('#member_name').val(member.first_name + ' ' + member.last_name);
                $('#member_mobile').val(member.mobile);
                $('#member_address').val(member.address);

                // Load minors
                const $minorSelect = $('#minor_id');
                $minorSelect.empty();

                if (member.minors && member.minors.length > 0) {
                    member.minors.forEach(minor => {
                        $minorSelect.append(
                            `<option value="${minor.id}">${minor.first_name} ${minor.last_name}</option>`
                        );
                    });
                }
                const $branchSelect = $('#branch_id');
                $branchSelect.empty();

                if (member.branch_id) {
                    // If a single branch
                    $branchSelect.append(`<option value="${member.branch_id.id}">${member.branch_id.branch_name}</option>`);
                } else if (member.branch && member.branch.length > 0) {
                    // If multiple branches
                    member.branch.forEach(branch => {
                        $branchSelect.append(`<option value="${branch.id}">${branch.branch_name}</option>`);
                    });
                }
            } else {
                $('#member_name').val('');
                $('#member_mobile').val('');
                $('#member_address').val('');
                $('#minor_id').empty().append('<option value="">Select minor</option>');
                $('#branch_id').empty().append('<option value="">Select branch</option>');
            }
        });
    });
</script> -->

<script>
    const membersData = @json($membersData);
    $(document).ready(function() {
        $('#member_id').on('change', function() {
            const memberId = $(this).val();
            const member = membersData[memberId];

            if (memberId) {
                // 🔹 Load savings accounts via AJAX
                $.ajax({
                    url: "{{ route('member.savings', '') }}/" + memberId,
                    type: "GET",
                    dataType: "json",
                    success: function(savings) {
                        let savingSelect = $("#savingAccount");
                        savingSelect.empty().append('<option value="">Select Account</option>');

                        if (savings.length > 0) {
                            $.each(savings, function(i, saving) {
                                savingSelect.append('<option value="' + saving.id + '">' + saving.account_no + '</option>');
                            });
                            $("#savingFields").removeClass("hidden");
                        } else {
                            $("#savingFields").addClass("hidden");
                        }
                    },
                    error: function() {
                        alert("Error loading saving accounts");
                    }
                });
            } else {
                $("#savingFields").addClass("hidden");
            }

            // 🔹 Fill member details
            if (member) {
                $('#member_name').val(member.first_name + ' ' + member.last_name);
                $('#member_mobile').val(member.mobile);
                $('#member_address').val(member.address);

                // 🔹 Load minors
                const $minorSelect = $('#minor_id');
                $minorSelect.empty().append('<option value="">Select minor</option>');
                if (member.minors && member.minors.length > 0) {
                    member.minors.forEach(minor => {
                        $minorSelect.append(`<option value="${minor.id}">${minor.first_name} ${minor.last_name}</option>`);
                    });
                }

                // 🔹 Load branch
                const $branchSelect = $('#branch_id');
                $branchSelect.empty();

                if (member.branch_id) {
                    // if you load single branch as object
                    $branchSelect.append(`<option value="${member.branch_id.id}" selected>${member.branch_id.branch_name}</option>`);
                } else if (member.branch && member.branch.length > 0) {
                    // if member has multiple branches
                    member.branch.forEach(branch => {
                        $branchSelect.append(`<option value="${branch.id}">${branch.branch_name}</option>`);
                    });
                }
            } else {
                $('#member_name').val('');
                $('#member_mobile').val('');
                $('#member_address').val('');
                $('#minor_id').empty().append('<option value="">Select minor</option>');
                $('#branch_id').empty().append('<option value="">Select branch</option>');
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const fdAmountInput = document.getElementById("fd_amount");
        const finalAmountInput = document.getElementById("final_amount");
        const pay1AmountInput = document.getElementById("pay1_amount");

        fdAmountInput.addEventListener("input", function() {
            let value = fdAmountInput.value;

            finalAmountInput.value = value;
            pay1AmountInput.value = value;
        });
    });
</script>
<script>
    $(".saving-account").on("change", function() {
        let accountId = $(this).val(); // get selected account id
        if (accountId) {
            $.ajax({
                url: "{{ route('ajax.get.account.balance') }}",
                type: "POST",
                data: {
                    account_id: accountId,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {

                    var currentBalace = response.balance;

                    // Example: update balance field
                    $("#accountBalance").text(response.balance);

                    var fd_amount = $("#fd_amount").val();
                    if (fd_amount !== "") {
                        if (currentBalace < fd_amount) {

                            $("#accountBalance2").text("insufficiant balance......");
                        }
                    }



                    // Show balance box if hidden
                    $("#balanceBox").removeClass("hidden");
                },
                error: function(xhr) {
                    console.log("Error:", xhr.responseText);
                }
            });
        }
    });



    document.addEventListener('DOMContentLoaded', function() {
        let savingFields = document.getElementById('savingFields');

        if (savingFields) {
            savingFields.addEventListener('change', function() {
                let accountId = this.value;

                if (accountId) {
                    fetch(`/account/balance/${accountId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(accountBalance);
                            // document.getElementById('balanceBox').classList.remove('hidden');
                            document.getElementById('accountBalance').value = accountBalance
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    // document.getElementById('balanceBox').classList.add('hidden');
                    document.getElementById('accountBalance').value = '';
                }
            });
        }
    });
</script>



@endsection