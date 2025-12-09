@extends('layout.main')
@section('content')
<div class="main-inner">

    <head>
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
    </head>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-center gap-2">
                <h3 class="uppercase text-lg font-semibold">
                    BUSINESS LOAN
                </h3>
            </div>
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class=" w-full  box overflow-hidden">
            <div class="">
                <h3 class="text-lg">CHARGES - CLEAR DUES</h3>
            </div>
            <hr class="mt-3">
            <form action="{{ route('bussiness.clear-due', $goldLoan->id) }}" method="POST">
                @csrf
                <div class="col-span-2 md:col-span-1 mt-5 mb-2 ">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Due Amount
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="due_amount" id="due_amount" placeholder="0.0" value="{{ number_format($totalDue ?? 0, 2) }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Waived Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="waived_amount" id="waived_amount" placeholder="0.0" step="0.01"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
                <div class="col-span-2 md:col-span-1 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mt-3 mb-2">
                        Charges / Penalty Due
                        <span class="text-red-500">*</span>
                    </label>
                    <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                        <tbody>
                            <!-- Column Labels -->
                            <tr class="">
                                <th class="text-center px-3 py-1 uppercase ">Amount</th>
                                <th class="text-center px-3 py-1 uppercase ">GST Rate (%) </th>
                                <th class="text-center px-3 py-1 uppercase ">Total Amount</th>
                            </tr>

                            <!-- Input Row -->
                            <tr class="">
                                <td class="px-2 py-2 ">
                                    <input type="text" name="amount" id="amount" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>

                                <td class="px-2 py-2 ">
                                    <input type="text" name="gst_rate" id="gst_rate" placeholder="18" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>

                                <td class="px-2 py-2 ">
                                    <input type="text" name="gst_rate" id="gst_rate" placeholder="0"
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Rounding Off
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="round_off" id="round_off" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Net Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="net_amount" id="net_amount" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Remarks (if any)
                    </label>
                    <textarea name="remark" id="remark"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Remarks (if any)"></textarea>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Transaction Date
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="transaction_date" id="date" placeholder="DD/MM/YYYY"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                </div>
               
                <div class="col-span-2 md:col-span-1">
                    <label class="font-medium block mb-4 mt-3  uppercase">Payment Mode <span class="text-red-500">*</span></label>
                    <div class="mt-3">
                    <div class="flex grid col-span-1">
                    <div class="flex gap-3">
                            <label class="flex gap-2">
                        <input type="radio" name="fee_mode" value="cash" checked> 
                        <p>Cash</p>
                        </label>
                        <label class="flex gap-2">
                        <input type="radio" name="fee_mode" value="cheque">
                        <p>Cheque</p> 
                        </label>
                        <label class="flex gap-2">
                        <input type="radio" name="fee_mode" value="online"> 
                        <p>Online Transfer</p>
                        </label>
                    </div>
                    <div class="flex gap-3 mt-3">
                        <label class="flex gap-2">
                        <input type="radio" name="fee_mode" value="saving"> 
                        <p>Saving Account</p>
                        </label>
                    </div>

                    </div>
                    <!-- Fields for Cheque -->
                    <div id="cheque_fields" style="display:none; margin-top:10px;">
                        <label for="bank_id" class="block mb-2 text-sm font-medium">Select Bank</label>
                        <select id="bank_id" name="bank_id"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                <option value="">-- Select Bank --</option>
                                @foreach($banks as $id => $name)
                                    <option value="{{ $id }}">
                                        {{ $name }}
                                    </option>
                                @endforeach
                        </select>
                        <!-- Cheque No -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                            <input type="text" name="cheque_no"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                placeholder="Enter Cheque No">
                        </div>

                        <!-- Cheque Date -->
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                            <input type="text" id="cheque_date" name="cheque_date"
                            value="{{ old('cheque_date', date('d-m-Y')) }}"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>
                    </div>

                    <!-- Fields for Online -->
                    <div id="online_fields" style="display:none; margin-top:10px;">
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Transfer Date <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="transfer_date" name="transfer_date" 
                            value="{{ old('transfer_date', date('d-m-Y')) }}"
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                UTR / Transaction No. <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="utr_no" name="utr_no" placeholder="Enter Transaction No."
                                class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
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
                    </div>

                    <!-- Fields for Saving Account -->
                    <div id="saving_fields" style="display:none; margin-top:10px;">
                        <label>Saving Account:</label>
                        <select id="saving" name="saving"
                            class="w-full rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">

                            <option value="">-- Select Saving Acc. --</option>

                            @foreach ($savingAccounts as $acc)
                                <option value="{{ $acc }}">{{ $acc }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    
                </div>

                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Debit
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="{{ route('mortgage.account.show', $goldLoan->id) }}"> BACK</a>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class=" w-full  overflow-hidden">
        </div>

    </div>

</div>

<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
    document.addEventListener('DOMContentLoaded', function() {
        const dueAmountInput = document.getElementById('due_amount');
        const waivedAmountInput = document.getElementById('waived_amount');
        const form = waivedAmountInput.closest('form'); // get parent form element

        // When user changes waived amount
        waivedAmountInput.addEventListener('input', function() {
            const dueAmount = parseFloat(dueAmountInput.value) || 0;
            const waivedAmount = parseFloat(waivedAmountInput.value) || 0;

            if (waivedAmount > dueAmount) {
                alert('⚠️ Waived amount cannot be greater than due amount.');
                waivedAmountInput.value = dueAmount.toFixed(2); // reset to max allowed
            }
        });

        // Optional: Double-check before submitting
        form.addEventListener('submit', function(e) {
            const dueAmount = parseFloat(dueAmountInput.value) || 0;
            const waivedAmount = parseFloat(waivedAmountInput.value) || 0;

            if (waivedAmount > dueAmount) {
                e.preventDefault();
                alert('⚠️ Please correct the waived amount. It cannot exceed the due amount.');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        const amountInput = document.getElementById('amount');
        const gstRateInput = document.getElementById('gst_rate');
        const totalInput = document.getElementById('total_amount');

        function calculateGST() {
            const amount = parseFloat(amountInput.value) || 0;
            const gstRate = parseFloat(gstRateInput.value) || 0;

            // Calculate GST and total
            const gstAmount = (amount * gstRate) / 100;
            const total = amount + gstAmount;

            totalInput.value = total.toFixed(2);
        }

        amountInput.addEventListener('input', calculateGST);
        gstRateInput.addEventListener('input', calculateGST);
    });

    document.addEventListener("DOMContentLoaded", () => {
        const payModeRadios = document.querySelectorAll('input[name="payment_mode"]');
        const onlineFields = document.getElementById('onlineFields');
        const chequeFields = document.getElementById('chequeFields');

        function hideAll() {
            onlineFields.classList.add('hidden');
            chequeFields.classList.add('hidden');
        }

        payModeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                hideAll();
                if (e.target.value === 'online') {
                    onlineFields.classList.remove('hidden');
                } else if (e.target.value === 'cheque') {
                    chequeFields.classList.remove('hidden');
                }
            });
        });

        const checked = document.querySelector('input[name="payment_mode"]:checked');
        if (checked) {
            checked.dispatchEvent(new Event("change"));
        }
    });
</script>

<!-- pay mode -->
 <script>
document.querySelectorAll('input[name="fee_mode"]').forEach((elem) => {
  elem.addEventListener("change", function(event) {
    let value = event.target.value;

    // hide all first
    document.getElementById("cheque_fields").style.display = "none";
    document.getElementById("online_fields").style.display = "none";
    document.getElementById("saving_fields").style.display = "none";

    // show according to selection
    if (value === "cheque") {
      document.getElementById("cheque_fields").style.display = "block";
    } else if (value === "online") {
      document.getElementById("online_fields").style.display = "block";
    } else if (value === "saving") {
      document.getElementById("saving_fields").style.display = "block";
    }
  });
});
</script>


@endsection