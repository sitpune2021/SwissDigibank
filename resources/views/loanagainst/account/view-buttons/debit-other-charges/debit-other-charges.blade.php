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
                    LOAN AGAINST DEPOSITE - {{$goldLoan->id}}
                </h3>
            </div>
        </div>
    </div>

    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class=" w-full  box overflow-hidden">
            <form action="{{route('loanagainst.debitOtherCharges.store',$goldLoan->id)}}" method="post">
                @csrf
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Charge Type
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="charge_type" id="charge_type"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Type</option>
                        <option value="sms_charges" data-gst="18">Sms Charges</option>
                        <option value="cheque_bounce_charges" data-gst="18">Cheque Bounce Charges</option>
                        <option value="passbook_charges" data-gst="18">Passbook Charges</option>
                        <option value="other_charges" data-gst="18">Other Charges</option>
                        <option value="maintenance_charges" data-gst="18">Maintenance Charges</option>
                        <option value="collection_charges" data-gst="18">Collection Charges</option>
                        <option value="notice_charges" data-gst="18">Notice Charges</option>
                        <option value="service_charges" data-gst="18">Service Charges</option>
                        <option value="insurance_fee" data-gst="18">Insurance Fee</option>
                        <option value="processing_charges" data-gst="18">Processing Charges</option>
                        <option value="cancellation_charges" data-gst="18">Cancellation Charges</option>
                        <option value="gst" data-gst="18">Gst</option>
                        <option value="visit_charges" data-gst="18">Visit Charges</option>
                        <option value="fitness_fee" data-gst="18">Fitness Fee</option>
                    </select>
                    @error('charge_type')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-4">
                    <x-datepicker-disabled label="Transaction Date" name="charge_date" class="md:text-lg uppercase font-medium block mt-4"
                        placeholder="Select Charge Date" />
                </div>
                <div class="col-span-2 md:col-span-1 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-2">
                        Charges
                        <span class="text-red-500">*</span>
                    </label>
                    <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                        <tbody>
                            <!-- Column Labels -->
                            <tr class="">
                                <th class="text-center uppercase px-3 py-1 ">Amount</th>
                                <th class="text-center uppercase px-3 py-1 ">GST Rate (%) </th>
                                <th class="text-center uppercase px-3 py-1 ">Total Amount</th>
                            </tr>
                            <!-- Input Row -->
                            <tr class="">
                                <td class="px-2 py-2 ">
                                    <input type="text" name="amount" id="amount" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>
                                <td class="px-2 py-2 ">
                                    <input type="text" name="gst_rate" id="gst_rate" placeholder="18" value="18" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>

                                <td class="px-2 py-2 ">
                                    <input type="text" name="total_amount" id="total_amount" placeholder="Amount"
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>
                            </tr>
                            @error('total_amount')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                            @enderror
                        </tbody>
                    </table>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Remarks (if any)
                    </label>

                    <textarea name="remarks" id="remarks"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Remarks (if any)"></textarea>
                </div>
                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save">
                            Debit
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset"  onclick="window.location.href='{{ route('mortgage.account.index') }}'">
                            BACK
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class=" w-full  overflow-hidden">
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">LOAN AGAINST DEPOSITE ACCOUNT INFO</h3>

                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <div class="overflow-x-auto p-4 ">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2 w-1/3">Loan No.</td>
                                <td class="px-3 py-2"> {{$goldLoan->id??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Member</td>
                                <td class="px-3 py-2">{{$goldLoan->member->member_no??''}} {{$goldLoan->member->member_info_first_name??''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Open Date</td>
                                <td class="px-3 py-2">{{ $goldLoan->application_date ? \Carbon\Carbon::parse($goldLoan->application_date)->format('d-m-Y') : '' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Scheme</td>
                                <td class="px-3 py-2"> {{$goldLoan->scheme->scheme_name??''}} </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Loan Amount</td>
                                <td class="px-3 py-2">₹ {{$goldLoan->loan_amount??''}} </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Current Debt</td>
                                <td class="px-3 py-2">{{$goldLoan->LoanAgainstTransactions->first()->current_debt ?? ''}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">
                                    {{$goldLoan->scheme->annual_interest_rate??''}} %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Interest Type</td>
                                <td class="px-3 py-2 capitalize">
                                    {{ ucwords(str_replace('_', ' ', $goldLoan->scheme->gold_loan_setting ?? '')) }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Tenure</td>
                                <td class="px-3 py-2">
                                    {{$goldLoan->scheme->tenure??''}} MONTHS
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold uppercase px-3 py-2">Status</td>
                                <td class="px-3 py-2">
                                    @if($goldLoan->is_active == 1)
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Active
                                    </span>
                                    @else
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                        Inactive
                                    </span>
                                    @endif
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
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

    document.getElementById('charge_type').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];

        const amount = parseFloat(selected.dataset.amount) || '';
        const gst = parseFloat(selected.dataset.gst) || '';

        document.getElementById('amount').value = amount !== '' ? parseFloat(amount).toFixed(2) : '';
        document.getElementById('gst_rate').value = gst !== '' ? parseFloat(gst).toFixed(2) : '';

        document.getElementById('total_amount').value = '';
    });

    document.getElementById('total_amount').addEventListener('input', function() {
        const totalAmount = parseFloat(this.value) || 0;
        const gstRate = parseFloat(document.getElementById('gst_rate').value) || 0;

        const baseAmount = totalAmount / (1 + gstRate / 100);

        document.getElementById('amount').value = totalAmount > 0 ? baseAmount.toFixed(2) : '';
    });
</script>
@endsection