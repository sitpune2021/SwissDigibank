@extends('layout.main')
@section('content')
<div class="main-inner">
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
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
    </style>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-end gap-2">
                <h3 class="uppercase font-semibold text-lg">
                    Close Saving Account - {{$account->account_no??''}}
                </h3>
            </div>
        </div>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <!-- Left: Details -->
        <div class=" w-full">
            <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                <form action="">
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Current Balance (A)
                        </label>

                        <input type="number" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" value="{{ $available_balance??0}}" readonly>

                    </div>

                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Interest Accrued (B)

                        </label>

                        <input type="number" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0">

                    </div>
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Due Penalty Charges Charges (C)
                            <span class="text-red-500">*</span>
                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>

                                </tr>

                                <!-- Input Row -->
                                <tr>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Other Charges (if any) (D)

                        </label>
                        <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                            <tbody>
                                <!-- Column Labels -->
                                <tr class="">
                                    <th class="text-center px-3 py-1 ">Amount</th>
                                    <th class="text-center px-3 py-1 ">GST Rate (%) </th>
                                    <th class="text-center px-3 py-1 ">Total Amount</th>
                                </tr>

                                <!-- Input Row -->
                                <tr>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0" readonly
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                    <td class="px-2 py-2 ">
                                        <input type="number" name="" id="" placeholder="0"
                                            class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Total Value (E = A + B - C - D)
                        </label>

                        <input type="number" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>

                    </div>

                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Rounding Off (F)
                        </label>

                        <input type="number" id="penalInterestRate"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" readonly>
                    </div>


                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Member's Sign
                        </label>
                        <p>
                            No Signature Present for Member
                        </p>
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Reason to Close A/c.
                        </label>

                        <textarea id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Reason to Close A/c."></textarea>
                    </div>
                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Request Letter
                        </label>

                        <input type="file" id=""
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    </div>

                    <div class="col-span-2 md:col-span-1 mb-4">
                        <label for="" class="md:text-lg uppercase font-medium block mb-4">
                            Transaction Date <span class="text-error">*</span>
                        </label>

                        <input type="text" id="date"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="DD/MM/YYYY">
                    </div>
                    <div class="col-span-2 md:col-span-1 mt-3">
                        <div class="">
                            <label for="" class="md:text-lg font-medium block uppercase mt-3 mb-4">
                                Pay Mode <span class="text-error ">*</span>
                            </label>
                            <!-- Radio Buttons -->
                            <div class="mt-3 flex gap-3">
                                <!-- Pay Mode -->
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="cash" checked>
                                    <p class="uppercase">Cash</p>
                                </label>
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="cheque">
                                    <p class="uppercase">Cheque</p>
                                </label>
                                <label class="mr-4 flex gap-2 items-center">
                                    <input type="radio" name="fee_mode" value="online">
                                    <p class="uppercase"> Online Tr.</p>
                                </label>

                            </div>

                            <!-- Bank + Cheque Fields -->
                            <div id="bankDropdownWrapper" class="mt-3 hidden">
                                <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                                <select id="bank_id" name="bank_id"
                                    class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                    <option value="">-- Select Bank --</option>

                                </select>

                                <!-- Cheque No -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                    <input type="text" name="cheque_no"
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                        placeholder="Enter Cheque No" value="">
                                </div>

                                <!-- Cheque Date -->
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                    <input type="date" id="cheque_date" name="cheque_date" value=""
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>
                            </div>

                            <!-- Online Transaction Fields -->
                            <div id="onlineFields" class="space-y-4 hidden">
                                <div class="mt-3">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" id="transfer_date" name="transfer_date" value=""
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        UTR / Transaction No. <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                        value=""
                                        class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Transfer Mode <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex gap-4 mt-2">
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="imps">
                                            <span>IMPS</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="vpa">

                                            <span>VPA</span>
                                        </label>
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="transfer_mode" value="neft_rtgs">
                                            <span>NEFT/RTGS</span>
                                        </label>
                                    </div>
                                </div>

                                {{-- <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            Credited in Company Account <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="1" checked>
                                                <span>Yes</span>
                                            </label>

                                            <label class="flex items-center gap-2">
                                                <input type="radio" name="credited" value="0" {{ old('credited')==0
                                                    ? 'checked' : '' }}>
                                <span>No</span>
                                </label>
                            </div>
                        </div> --}}
                    </div>

                    <!-- Saving Account-->
                    <div id="savingAccount" class="mt-3 hidden">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Transaction Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="transfer_date" name="transfer_date" value=""
                                class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>


                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Interest to Withdraw
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name=""
                                class="w-full rounded-10 border px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Interest to Withdraw " value="">
                        </div>



                    </div>

            </div>
        </div>
        <div class="col-span-2 md:col-span-1 mb-4 mt-4">
            <label for="" class="md:text-lg uppercase font-medium block mb-4">
                Net Amount to Release (E - F) <span class="text-error">*</span>
            </label>

            <input type="number" id=""
                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                placeholder="0.00" readonly>
        </div>
        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button class="btn-primary uppercase justify-center" type="submit" name="">
                Close Account
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="#"> BACK</a>
            </button>
        </div>
        </form>
    </div>
</div>

<!-- Left: Details -->
<div class=" w-full  overflow-hidden">
    <!-- scheme info-->
    <div class="box shadow-md dark:bg-bg3  rounded-lg overflow-hidden">
        <div
            class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
            <h3 class="text-lg font-semibold uppercase">
                Saving Account Info
            </h3>
            <div class="">

                <button type="button" class="p-1 rounded transition" onclick="toggleSection(this)">
                    <span class="toggle-icon text-lg font-bold">+</span>
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="overflow-x-auto p-4 hidden">
            <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2 w-1/3">Member </td>
                        <td class="px-3 py-2">
                            <a href="" class="text-primary">
                                {{$account->members->member_no??''}} {{$account->members->member_info_first_name??''}}
                            </a>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            PAN No.
                        </td>
                        <td class="px-3 py-2">
                            {{$account->members->kyc->member_kyc_pan_no??''}}
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Joint Account
                        </td>
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-1">
                                @if($account->account_holder_type === 'joint')
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    Yes
                                </span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    No
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Account No.
                        </td>
                        <td class="px-3 py-2">
                            {{$account->account_no??''}}
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">Scheme</td>
                        <td class="px-3 py-2"> {{$account->scheme->scheme_name??''}}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Open Date
                        </td>
                        <td class="px-3 py-2">
                            {{$account->open_date??''}}
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Status
                        </td>
                        <td class="px-3 py-2">
                            <span class="{{ $account->account_status == 1 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $account->account_status == 1 ? 'Active' : 'Not Active' }}
                            </span>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Lock Balance (A)
                        </td>
                        <td class="px-3 py-2">{{ $account->scheme->lock_in_amount??0}}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Hold Balance (B)
                        </td>
                        <td class="px-3 py-2"> </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Available Balance (C)
                        </td>
                        <td class="px-3 py-2">
                             {{ $available_balance??0}}
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Sweep In Balance (D)
                        </td>
                        <td class="px-3 py-2">
                            0.00
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Due Penalty Amount (E)
                        </td>
                        <td class="px-3 py-2">
                            0.00
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="uppercase font-semibold px-3 py-2">
                            Combined Balance (A + B + C + D - E)
                        </td>
                        <td class="px-3 py-2">
                            10,927.99
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>

</div>

</div>


<!-- pay mode -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const radios = document.querySelectorAll('input[name="fee_mode"]');
        const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
        const onlineFields = document.getElementById("onlineFields");
        const savingAccount = document.getElementById("savingAccount");

        radios.forEach(radio => {
            radio.addEventListener("change", () => {
                // Hide all sections first
                bankDropdownWrapper.classList.add("hidden");
                onlineFields.classList.add("hidden");
                savingAccount.classList.add("hidden");

                // Show based on selected mode
                if (radio.value === "cheque" && radio.checked) {
                    bankDropdownWrapper.classList.remove("hidden");
                }
                if (radio.value === "online" && radio.checked) {
                    onlineFields.classList.remove("hidden");
                }
                if (radio.value === "savingaccount" && radio.checked) {
                    savingAccount.classList.remove("hidden");
                }
            });
        });

        // Default today's date
        let today = new Date().toISOString().split('T')[0];
        const chequeDate = document.getElementById("cheque_date");
        const onlineDate = document.getElementById("online_transfer_date");
        const savingDate = document.getElementById("saving_transfer_date");

        if (chequeDate) chequeDate.value = today;
        if (onlineDate) onlineDate.value = today;
        if (savingDate) savingDate.value = today;
    });
</script>

<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>
@endsection