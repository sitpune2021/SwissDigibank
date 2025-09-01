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
            <h1 class="text-xl font-semibold">Open New RD Account</h1>
            <p class="text-gray-500">
                <a href="{{route('mds-rd-accounts.rd-account-index')}}" class="text-gray-500">Recuuring Deposits</a> >
                <a href="#" class="text-gray-500"> New</a>
            </p>

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('rd-accounts.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Member
                        <span class="text-red-500">*</span>
                    </label>
                    <select id="memberDropdown" name="member_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Member</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ $member->full_name }}
                            @endforeach
                    </select>
                    @error('member_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror

                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4">
                        Member Name
                    </label>

                    <input type="text" id="memberName" name="member_name"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="" readonly>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="city" class="md:text-lg font-medium block mb-4">
                        Member Address
                    </label>

                    <input type="text" id="memberAddress" name="member_address"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="" readonly>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="frequency" class="md:text-lg font-medium block mb-4">
                        Member Mobile No
                    </label>
                    <div class="flex gap-2">

                        <input type="text" name="member_mobile" id="" class=" text-sm bg-secondary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3" value="+91" readonly>
                        <input type="text" id="memberMobile" name="member_mobile" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3" placeholder="Enter Mobile No " readonly>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2"> Minor (if any) </label>
                    <select id="minor_id" name="minor_id" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3">
                    </select>

                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Branch <span class="text-red-500 text-sm">*</span> </label>
                    <select id="branch_id" name="branch_id"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                    </select>
                    @error('branch_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Advisor/ Staff </label>
                    <select id="" name="advisor_staff"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">ALL</option>
                        <option value="head_office">Head Office</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Collection Advisor/ Staff </label>
                    <select id="" name="collection_advisor_staff"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Collection Advisor Staff</option>
                        <option value="head_office">Head Office</option>
                    </select>
                </div>


                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">Scheme <span class="text-red-500">*</span>
                        :</label>
                    <select id="" name="scheme"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Scheme</option>
                        @foreach ($schemes as $scheme)
                        <option value="{{ $scheme->id }}">{{ $scheme->scheme_name }}</option>
                        @endforeach
                    </select>
                    @error('scheme')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">RD Amount <span class="text-red-500">*</span>
                        :</label>
                    <input type="number" id="rdAmount" name="rd_amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="" value="">
                </div>
                @error('rd_amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="col-span-2 md:col-span-1 relative">
                    <label class="font-medium block mb-2">
                        Open Date <span class="text-red-500">*</span> :
                    </label>
                    <input type="text" id="date5" name="open_date" value="{{ old('open_date') }}" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
               rounded-10 px-3 md:px-6 py-2 md:py-3 pr-10" placeholder="DD/MM/YYYY">
                    <i class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                </div>
                @error('open_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror


                <div class="col-span-2 md:col-span-1"></div>

                <!-- TDS -->
                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2">TDS Deduction<span class="text-red-500">*</span></label>
                    <div class="flex items-center  gap-2">
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds" value="yes"> Yes</label>
                        <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds" value="no"> No</label>
                    </div>
                    @error('tds')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1"></div>

                <div class="col-span-2 md:col-span-1 mt-4">
                    <label class="font-medium block mb-2">Account Type <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="accountType" value="single" onclick="toggleAccountType('single')" class="accent-primary">
                            <span>Single</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="accountType" value="joint" onclick="toggleAccountType('joint')" class="accent-primary">
                            <span>Joint A/C</span>
                        </label>
                    </div>
                    @error('accountType')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <!-- single (no fields) -->
                    <div id="single" class="hidden"></div>
                </div>

                <div class="col-span-2 md:col-span-1 mt-4">
                    <div id="joint" class="hidden mt-4">
                        <label class="font-medium block mb-1">Select Saving Account<span class="text-red-500">*</span></label>
                        <select id="savingAccountJoint" name="savings_account" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                       rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Account</option>


                        </select>
                        @error('savings_account')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Nominee -->
            <div class="col-span-2 md:col-span-1 mt-4">
                <label class="font-medium block mb-2">Nominee <span class="text-red-500">*</span></label>
                <div class="flex items-center  gap-2">
                    <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee" value="yes" onclick="toggleAddMore(true)">Yes</label>
                    <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="nominee" value="no" onclick="toggleAddMore(false)"> No</label>
                </div>
                @error('nominee')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <!-- Add More Button -->
                <div id="addMoreContainer" class="mt-2 hidden">
                    <button type="button" onclick="addNominee()" class="text-blue-600 font-medium">
                        + ADD MORE NOMINEE
                    </button>
                </div>

                <!-- Nominee Forms Container -->
                <div id="nomineeContainer" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 items-end p-3 rounded-10 bg-gray-50 dark:bg-bg3">
                    <!-- Forms will be added here -->
                </div>
            </div>

            <div class="col-span-2 md:col-span-1"></div>
            <!-- Payment Mode -->
            <div class="grid grid-cols-1 gap-4 mt-6 xl:mt-8 2xl:gap-6">

                <div class="col-span-1 mt-4">
                    <label class="block font-medium mb-2">
                        Payment Mode <span class="text-red-500">*</span>
                    </label>

                    <!-- Payment Mode Radios -->
                    <div class="flex flex-wrap gap-4 mt-4">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="payment_mode" value="cash" onclick="togglePaymentMode('cash')" checked>
                            <span>Cash</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="onlineTr" onclick="togglePaymentMode('onlineTr')">
                            <span>Online Tr.</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="cheque" onclick="togglePaymentMode('cheque')">
                            <span>Cheque</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="payment_mode" value="savingAcc" onclick="togglePaymentMode('savingAcc')">
                            <span>Saving Ac.</span>
                        </label>
                    </div>
                    @error('payment_mode')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror


                    <!-- Cash (no fields) -->
                    <div id="cash" class="hidden"></div>


                    <!-- Online Transfer Fields -->
                    <div id="onlineTr" class="hidden grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6 mt-4">

                        <!-- Transfer Date -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Transfer Date <span class="text-red-500">*</span></label>
                            <input type="text" name="transfer_date" id="date2" value="{{ old('transfer_date') }}" placeholder="dd/mm/yyyy"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <i class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                        </div>
                        @error('transfer_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- UTR / Transaction No -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">UTR / Transaction No <span class="text-red-500">*</span></label>
                            <input type="text" name="transaction_no" placeholder="Enter UTR / Transaction No"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        </div>
                        @error('transaction_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror


                        <!-- Transfer Mode -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Transfer Mode <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="IMPS" class="accent-primary">
                                    <span>IMPS</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="VPA" class="accent-primary">
                                    <span>VPA</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="NEFT/RTGS" class="accent-primary">
                                    <span>NEFT/RTGS</span>
                                </label>
                            </div>
                        </div>
                        @error('transfer_mode')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Credited in Company Account -->
                        <div class="col-span-2 md:col-span-1 mt-4">
                            <label class="font-medium block mb-1">Credited in Company Account? <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="yes"> <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="no"> <span>No</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @error('credited')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror


                    <!-- Cheque Fields -->
                    <div id="cheque" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                        <div class="cheque-row flex flex-wrap justify-start gap-4">
                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Bank Name<span class="text-red-500">*</span></label>
                                <input type="text" name="cheque_bank_name" placeholder="Enter Bank Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                            @error('cheque_bank_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror

                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Cheque No<span class="text-red-500">*</span></label>
                                <input type="text" placeholder="Enter Cheque No" name="cheque_no" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            </div>
                            @error('cheque_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                <label class="font-medium block mb-1">Cheque Date<span class="text-red-500">*</span></label>
                                <input type="text" id="date3" value="{{ old('cheque_date') }}" placeholder="dd/mm/yyyy" name="cheque_date" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                <i class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                            </div>
                            @error('cheque_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Saving Account Fields -->
                    <div id="savingAcc" class="space-y-4 mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700">
                            Select Saving Account <span class="text-red-500">*</span>
                        </label>

                        <select id="savingAccountSelect" name="savings_account"
                            class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                            <option value="">Select Account</option>

                        </select>
                    </div>
                    <div id="accountBalanceDiv" class="mt-3 hidden">
                        <label class="block text-sm font-medium text-gray-700">Account Balance</label>
                        <div id="accountBalance"
                            class="p-3  text-sm font-semibold text-primary"></div>
                    </div>
                </div>
            </div>


            <!-- Date & Amount -->
            <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">
                        T.Date <span class="text-red-500">*</span> </label>
                    <input type="text" name="t_date" id="date4" value="{{ old('t_date') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="DD/MM/YYYY"> <i class="absolute -translate-y-1/2 cursor-pointer las la-calendar ltr:right-4 rtl:left-4 top-1/2"></i>
                </div>
                @error('t_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-2">
                        Amount <span class="text-red-500">*</span> </label>
                    <input type="number" name="amount"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
                @error('amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <!-- Buttons -->
            <div class="flex justify-center col-span-2 gap-4 mt-2 md:gap-6">
                <button class="btn-primary" type="submit">Save Scheme</button>
                <button class="btn-outline" type="button">Back</button>
                <button class="btn-outline" type="reset">Reset</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    // Nominee functions
    function toggleAddMore(show) {
        document.getElementById('addMoreContainer').style.display = show ? 'block' : 'none';
        if (!show) document.getElementById('nomineeContainer').style.display = 'hidden';
    }

    function addNominee() {
        const container = document.getElementById("nomineeContainer");
        container.style.display = "flex"; // make visible

        const newNominee = document.createElement("div");
        newNominee.className = "w-full nominee-item columns-4 gap-4 items-end bg-white p-4 rounded dark:bg-bg3";

        newNominee.innerHTML = `
        
<div class="nominee-row flex flex-wrap justify-start gap-6">
    <div class="flex-center flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Relation <span class="text-red-500">*</span></label>
        <select name="nominees[0][relation]" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                           rounded-10 px-3 md:px-6 py-2 md:py-3">
            <option value="">Select Relation</option>

            <!-- Immediate Family -->
            <option>Father</option>
            <option>Mother</option>
            <option>Spouse</option>
            <option>Son</option>
            <option>Daughter</option>

            <!-- Siblings -->
            <option>Brother</option>
            <option>Sister</option>

            <!-- Extended Family -->
            <option>Grandfather</option>
            <option>Grandmother</option>
            <option>Uncle</option>
            <option>Aunt</option>
            <option>Cousin</option>
            <option>Nephew</option>
            <option>Niece</option>

            <!-- In-Laws -->
            <option>Father-in-law</option>
            <option>Mother-in-law</option>
            <option>Brother-in-law</option>
            <option>Sister-in-law</option>
            <option>Son-in-law</option>
            <option>Daughter-in-law</option>

            <!-- Others -->
            <option>Guardian</option>
            <option>Friend</option>
            <option>Other</option>
        </select>


    </div>

    <div class="flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Name <span class="text-red-500">*</span></label>
        <input type="text" name="nominees[0][name]" placeholder="Enter Nominee Name"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                        rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[300px] max-w-full">
        <label class="font-medium block mb-2">Address <span class="text-red-500">*</span></label>
        <input type="text" name="nominees[0][address]" placeholder="Enter Nominee Address"
            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                         rounded-10 px-3 md:px-6 py-2 md:py-3">
    </div>

    <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
        <button type="button" onclick="removeNominee(this)"
            class="text-red-500 mt-8 font-bold text-lg hover:text-red-700">✕</button>
    </div>
</div>
          
        `;

        container.appendChild(newNominee);
    }

    function removeNominee(button) {
        const item = button.closest(".nominee-item");
        item.remove();

        // Hide container if no nominee left
        const container = document.getElementById("nomineeContainer");
        if (container.children.length === 0) {
            container.style.display = "none";
        }
    }
    const rdAmount = document.getElementById('rdAmount');
    const amountField = document.querySelector('input[name="amount"]');

    // Update the "Amount" field whenever "RD Amount" changes
    if (rdAmount && amountField) {
        rdAmount.addEventListener('input', () => {
            amountField.value = rdAmount.value;
        });
    }

    function togglePaymentMode(type) {
        // Hide all sections first
        ['cash', 'onlineTr', 'cheque', 'savingAcc'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        // Show the selected section
        if (type === 'onlineTr') document.getElementById('onlineTr').classList.remove('hidden');
        if (type === 'cheque') document.getElementById('cheque').classList.remove('hidden');
        if (type === 'savingAcc') document.getElementById('savingAcc').classList.remove('hidden');
    }

    function toggleAccountType(type) {

        ['single', 'joint'].forEach(id => {
            document.getElementById(id).classList.add('hidden');
        });
        // Show the selected section
        if (type === 'joint') {
            document.getElementById('joint').classList.remove('hidden');
        } else {
            document.getElementById('single').classList.remove('hidden');
        }


    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    $(document).ready(function() {
        $('#memberDropdown').on('change', function() {
            let memberId = $(this).val();
console.log(memberId);
            // Get dropdown references
            const $jointSelect = $('#savingAccountJoint');
            const $savingSelect = $('#savingAccountSelect');

            // Always clear both dropdowns first
            $jointSelect.empty().append('<option value="">Select Account</option>');
            $savingSelect.empty().append('<option value="">Select Account</option>');


            if (memberId) {
                $.ajax({
                     url: "{{ route('members.get', '') }}/" + memberId,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);

                        // ========== Fill Member Info ==========
                        $('#memberName').val(response.member?.member_info_first_name ?? 'Not Available');
                        $('#memberAddress').val(response.member?.address?.member_address_line_1 ?? 'Not Available');
                        $('#memberMobile').val(response.member?.member_info_mobile_no ?? '');
                        $('#branch_id').val(response.member?.branch?.id ?? '');

                        // ========== Populate Minors ==========
                        const $minorSelect = $('#minor_id');
                        $minorSelect.empty();
                        if (response.member?.minors?.length > 0) {
                            response.member.minors.forEach(minor => {
                                $minorSelect.append(
                                    `<option value="${minor.id}">${minor.first_name} ${minor.last_name}</option>`
                                );
                            });
                        } else {
                            $minorSelect.append('<option value="">No minors found</option>');
                        }

                        // ========== Populate Branch ==========
                        const $branchSelect = $('#branch_id');
                        $branchSelect.empty();
                        if (response.member?.branch?.id) {
                            $branchSelect.append(
                                `<option value="${response.member.branch.id}">${response.member.branch.branch_name}</option>`
                            );
                        } else if (Array.isArray(response.member?.branch) && response.member.branch.length > 0) {
                            response.member.branch.forEach(branch => {
                                $branchSelect.append(
                                    `<option value="${branch.id}">${branch.branch_name}</option>`
                                );
                            });
                        } else {
                            $branchSelect.append('<option value="">No branches available</option>');
                        }

                        // ========== Populate Joint Saving Accounts ==========
                        if (response.accounts?.length > 0) {
                            response.accounts.forEach(account => {
                                $jointSelect.append(`<option value="${account.id}">${account.account_no}</option>`);
                            });
                        } else {
                            $jointSelect.append('<option value="">No Saving Accounts Found</option>');
                        }

                        // ========== Populate Saving Accounts ==========
                        if (response.accounts?.length > 0) {
                            response.accounts.forEach(account => {
                                $savingSelect.append(`<option value="${account.id}" data-balance="${account.amount_deposit}">${account.account_no}</option>`);
                            });
                        } else {
                            $savingSelect.append('<option value="">No Saving Accounts Found</option>');
                        }

                        // show account balance when savingAccountSelect changes
                        $savingSelect.on('change', function() {
                            const selected = $(this).find('option:selected');
                            const balance = selected.data('balance');
                            if (balance || balance === 0) {
                                $('#accountBalance').text('₹ ' + balance);
                                $('#accountBalanceDiv').removeClass('hidden');
                            } else {
                                $('#accountBalance').text('');
                                $('#accountBalanceDiv').addClass('hidden');
                            }
                        });

                        // Reset displayed balance
                        $('#accountBalance').text('');
                        $('#accountBalanceDiv').addClass('hidden');
                    },
                    error: function() {
                        alert('Unable to fetch member details and accounts.');
                    }
                });
            } else {
                // If no member is selected, reset all fields
                $('#memberName').val('');
                $('#memberAddress').val('');
                $('#memberMobile').val('');
                $('#minor_id').empty();
                $('#branch_id').empty().append('<option value="">Select branch</option>');

                // Keep savings and joint account dropdowns empty
                $jointSelect.empty().append('<option value="">Select a member first</option>');
                $savingSelect.empty().append('<option value="">Select a member first</option>');

                $('#accountBalance').text('');
                $('#accountBalanceDiv').addClass('hidden');
            }
        });
    });
</script>


@endsection