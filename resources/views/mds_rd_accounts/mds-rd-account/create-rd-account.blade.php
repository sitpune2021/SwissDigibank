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
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-col  gap-2">
                <h1 class="text-xl font-semibold">OPEN NEW RD ACCOUNT</h1>
            </div>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('rd-accounts.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer
                            <span class="text-red-500">*</span>
                        </label>
                        <select id="memberDropdown" name="member_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Customer</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">
                                    {{ $member->member_info_first_name }} {{ $member->member_info_last_name }}
                            @endforeach
                        </select>
                        @error('member_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Name
                        </label>

                        <input type="text" id="memberName" name="member_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Customer Name" value="" readonly>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="city" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Address
                        </label>

                        <input type="text" id="memberAddress" name="member_address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Customer Address" value="" readonly>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="frequency" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Mobile No
                        </label>
                        <div class="flex gap-2">

                            <input type="text" name="member_mobile" id=""
                                class=" text-sm bg-secondary/5 w-20 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                value="+91" readonly>
                            <input type="text" id="memberMobile" name="member_mobile"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-green-500 dark:border-n500 rounded-10 px-3 md:px-6 py-3 md:py-3"
                                placeholder="Enter Mobile No " readonly>
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase"> Minor (if any) </label>
                        <select id="minor_id" name="minor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="Minor">
                        </select>

                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">Branch <span class="text-red-500 text-sm">*</span>
                        </label>
                        <select id="branch_id" name="branch_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">ALL</option>
                        </select>
                        @error('branch_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">Advisor/ Staff </label>
                        <select id="" name="advisor_staff"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">ALL</option>
                            <option value="head_office">Head Office</option>
                        </select>
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">Collection Advisor/ Staff </label>
                        <select id="" name="collection_advisor_staff"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Collection Advisor Staff</option>
                            <option value="head_office">Head Office</option>
                        </select>
                    </div>


                    <div class="col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">Scheme <span class="text-red-500">*</span>
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
                        <label class="font-medium block mb-2 uppercase">RD Amount <span class="text-red-500">*</span>
                            :</label>
                        <input type="number" id="rdAmount" name="rd_amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Amount" value="">
                        <x-number-to-word for="rdAmount" />
                        @error('rd_amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="col-span-2 md:col-span-1 relative">
                        <x-datepicker-disabled label="OPEN DATE" name="open_date" value="{{ old('open_date') }}"
                            inputId="date_pass" />

                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <!-- TDS -->
                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2 uppercase">TDS Deduction<span
                                class="text-red-500">*</span></label>
                        <div class="flex items-center  gap-2">
                            <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds"
                                    value="yes"> Yes</label>
                            <label class="flex items-center gap-2"><input class="ms-4" type="radio" name="tds"
                                    value="no" checked> No</label>
                        </div>
                        @error('tds')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1"></div>

                    <div class="col-span-2 md:col-span-1 mt-4">
                        <label class="font-medium block mb-2 uppercase">Account Type <span
                                class="text-red-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="accountType" value="single"
                                    onclick="toggleAccountType('single')" class="accent-primary" checked>
                                <span>Single</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="accountType" value="joint"
                                    onclick="toggleAccountType('joint')" class="accent-primary">
                                <span>Joint A/C</span>
                            </label>
                            @error('accountType')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- single (no fields) -->
                        <div id="single" class="hidden"></div>
                    </div>

                    <div class="col-span-2 md:col-span-1 mt-4">
                        <div id="joint" class="hidden mt-4">
                            <label class="font-medium block mb-1 uppercase">Select Saving Account<span
                                    class="text-red-500">*</span></label>
                            <select id="savingAccountJoint" name="savings_account"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
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
                    <x-add-nominee :rdAccount="null" :member="$member ?? null" submitText="Add" backText="Back" />

                </div>

                <div class="col-span-2 md:col-span-1"></div>
                <!-- Payment Mode -->
                <div class="grid grid-cols-1 gap-4 mt-6 xl:mt-8 2xl:gap-6">

                    <div class="col-span-1 mt-4">
                        <label class="block font-medium mb-2 uppercase">
                            Payment Mode <span class="text-red-500">*</span>
                        </label>

                        <!-- Payment Mode Radios -->
                        <div class="flex flex-wrap gap-4 mt-4">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="payment_mode" value="cash"
                                    onclick="togglePaymentMode('cash')" checked>
                                <span>Cash</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="onlineTr"
                                    onclick="togglePaymentMode('onlineTr')">
                                <span>Online Tr.</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="cheque"
                                    onclick="togglePaymentMode('cheque')">
                                <span>Cheque</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="payment_mode" value="savingAcc"
                                    onclick="togglePaymentMode('savingAcc')">
                                <span>Saving Ac.</span>
                            </label>
                            @error('payment_mode')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>



                        <!-- Cash (no fields) -->
                        <div id="cash" class="hidden"></div>


                        <!-- Online Transfer Fields -->
                        <div id="onlineTr" class="hidden grid  grid-cols-2 gap-4 xl:mt-8 2xl:gap-6 mt-4">
                            <!-- Transfer Date -->

                            <x-datepicker-disabled label="Transfer Date" name="transfer_date"
                                value="{{ old('transfer_date') }}" inputId="transfer_date" />

                            <!-- UTR / Transaction No -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1 uppercase">UTR / Transaction No <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="transaction_no" placeholder="Enter UTR / Transaction No"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                @error('transaction_no')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Transfer Mode -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1 uppercase">Transfer Mode <span
                                        class="text-red-500">*</span></label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="IMPS"
                                            class="accent-primary">
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="VPA"
                                            class="accent-primary">
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="NEFT/RTGS"
                                            class="accent-primary">
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                                @error('transfer_mode')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Credited in Company Account -->
                            <div class="col-span-2 md:col-span-1 mt-4">
                                <label class="font-medium block mb-1 uppercase">Credited in Company Account? <span
                                        class="text-red-500">*</span></label>
                                <div class="flex items-center gap-4 mt-1">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="yes"> <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="no"> <span>No</span>
                                    </label>
                                </div>
                                @error('credited')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <!-- Cheque Fields -->
                        <div id="cheque" class="hidden mt-2 flex flex-col md:flex-row flex-wrap gap-4 mt-4">
                            <div class="cheque-row flex flex-wrap justify-start gap-4">
                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1 uppercase">Bank Name<span
                                            class="text-red-500">*</span></label>
                                    <!-- <input type="text" name="cheque_bank_name" placeholder="Enter Bank Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"> -->

                                    <x-searchable-dropdown :items="$banks" label="Select Bank" name="cheque_bank_name"
                                        display-field="name" value-field="id" event="Bank-selected" :selected="null" />

                                    @error('cheque_bank_name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="flex-center flex-1 min-w-[300px] max-w-full">
                                    <label class="font-medium block mb-1 uppercase">Cheque No<span
                                            class="text-red-500">*</span></label>
                                    <input type="text" placeholder="Enter Cheque No" name="cheque_no"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                                    @error('cheque_no')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <x-datepicker-disabled label="CHEQUE DATE" name="cheque_date"
                                    value="{{ old('cheque_date') }}" inputId="cheque_date" />

                            </div>
                        </div>

                        <!-- Saving Account Fields -->
                        <div id="savingAcc" class="space-y-4 mt-3 hidden">
                            <label class="block text-sm font-medium text-gray-700 uppercase">
                                Select Saving Account <span class="text-red-500">*</span>
                            </label>

                            <select id="savingAccountSelect" name="savings_account"
                                class="w-full border rounded-10 dark:bg-bg3 px-3 py-3 text-sm bg-white">
                                <option value="">Select Account</option>

                            </select>
                            @error('savings_account')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="accountBalanceDiv" class="mt-3 hidden">
                            <label class="block text-sm font-medium text-gray-700">Account Balance</label>
                            <div id="accountBalance" class="p-3  text-sm font-semibold text-primary"></div>
                        </div>
                    </div>
                </div>

                <!-- Date & Amount -->
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 2xl:gap-6">
                    <div class="col-span-2 md:col-span-1 relative">

                        <x-datepicker-disabled label="T. DATE" name="t_date" value="{{ old('t_date') }}"
                            inputId="tdate" />
                    </div>

                    <div class=" col-span-2 md:col-span-1">
                        <label class="font-medium block mb-2 uppercase">
                            Amount <span class="text-red-500">*</span> </label>
                        <input type="number" name="amount" placeholder="Amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <!-- Buttons -->
                <div class="flex justify-center  uppercase col-span-2 gap-4 mt-2 md:gap-6">
                    <button class="btn-primary" type="submit">OPEN RD</button>
                    <button class="btn-outline" type="reset">RESET</button>
                    <button class="btn-outline" type="button"
                        onclick="window.location.href='{{ route('mds-rd-accounts.rd-account-index') }}'">
                        BACK
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const rdAmount = document.getElementById('rdAmount');
        const amountField = document.querySelector('input[name="amount"]');

        if (rdAmount && amountField) {
            rdAmount.addEventListener('input', () => {
                amountField.value = rdAmount.value;
            });
        }
    </script>

    <script>
        function togglePaymentMode(type) {
            // Hide all sections first
            ['cash', 'onlineTr', 'cheque', 'savingAcc'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });

            // Always hide balance first
            document.getElementById('accountBalanceDiv').classList.add('hidden');

            // Show the selected section
            if (type === 'onlineTr') {
                document.getElementById('onlineTr').classList.remove('hidden');
            }
            if (type === 'cheque') {
                document.getElementById('cheque').classList.remove('hidden');
            }
            if (type === 'savingAcc') {
                document.getElementById('savingAcc').classList.remove('hidden');
                document.getElementById('accountBalanceDiv').classList.remove('hidden');
            }
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



    <script>
        $(document).ready(function() {
            $('#memberDropdown').on('change', function() {
                let memberId = $(this).val();

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
                            $('#memberName').val(response.member?.member_info_first_name ??
                                'Not Available');
                            $('#memberAddress').val(response.member?.address
                                ?.member_address_line_1 ?? 'Not Available');
                            $('#memberMobile').val(response.member?.member_info_mobile_no ??
                                '');
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
                                $minorSelect.append(
                                    '<option value="">No minors found</option>');
                            }

                            // ========== Populate Branch ==========
                            const $branchSelect = $('#branch_id');
                            $branchSelect.empty();
                            if (response.member?.branch?.id) {
                                $branchSelect.append(
                                    `<option value="${response.member.branch.id}">${response.member.branch.branch_name}</option>`
                                );
                            } else if (Array.isArray(response.member?.branch) && response.member
                                .branch.length > 0) {
                                response.member.branch.forEach(branch => {
                                    $branchSelect.append(
                                        `<option value="${branch.id}">${branch.branch_name}</option>`
                                    );
                                });
                            } else {
                                $branchSelect.append(
                                    '<option value="">No branches available</option>');
                            }

                            // ========== Populate Joint Saving Accounts ==========
                            if (response.accounts?.length > 0) {
                                response.accounts.forEach(account => {
                                    $jointSelect.append(
                                        `<option value="${account.id}">${account.account_no}</option>`
                                    );
                                });
                            } else {
                                $jointSelect.append(
                                    '<option value="">No Saving Accounts Found</option>');
                            }

                            // ========== Populate Saving Accounts ==========
                            if (response.accounts?.length > 0) {
                                response.accounts.forEach(account => {
                                    $savingSelect.append(
                                        `<option value="${account.id}" data-balance="${account.amount_deposit}">${account.account_no}</option>`
                                    );
                                });
                            } else {
                                $savingSelect.append(
                                    '<option value="">No Saving Accounts Found</option>');
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
