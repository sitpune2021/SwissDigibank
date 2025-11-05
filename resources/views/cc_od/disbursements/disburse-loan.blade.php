@extends('layout.main')

@section('content')

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
                /* Modern browser support */
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
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h3 class="uppercase font-semibold">CC Limit Disbursement</h3>
            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class="w-full overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                  
                <form id="disbursementForm" 
                    action="{{ route('cc_od_disbursment.store') }}" 
                    method="POST"
                    class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-6 space-y-5">
                    @csrf

                    <!-- Header -->
                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-gray-800 border-b pb-2">
                            Application No - {{ $disbursement->id }}
                        </h3>
                        <input type="hidden" name="loan_application_id" 
                            value="{{ $disbursement->loan_application_id ?? $disbursement->id }}">
                    </div><br>

                    <!-- Loan Disbursement Date -->
                    <div>
                        <label for="disbursal_date" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">
                            Loan Disbursement Date <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="disbursal_date" name="disbursal_date" 
                            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ date('d-m-Y') }}" required readonly>
                    </div><br>

                    <!-- Approved CC Limit -->
                    <div>
                        <label for="loan_amount" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">
                            Approved CC Limit
                        </label>
                        <input type="number" id="loan_amount" name="loan_amount" 
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed"
                            value="{{ $disbursement->net_loan_amount ?? '' }}" readonly>
                    </div><br>

                    <!-- Available CC Limit -->
                    <div>
                        <label for="finalAmount" class="block text-sm sm:text-base font-medium text-gray-700 mb-1">
                            Available CC Limit <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="finalAmount" name="final_amount" 
                            class="w-full border rounded-lg px-3 py-2 bg-gray-100 cursor-not-allowed"
                            value="{{ $disbursement->net_loan_amount ?? '' }}" readonly>
                    </div><br>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row justify-center gap-3 mt-5"> <button class="btn-primary uppercase justify-center" type="submit" id="submitBtn"> DISBURSE LOAN </button> <a href="{{ route('cc_od.disbursements.index') }}" class="btn-outline uppercase justify-center">BACK</a> </div>
                
                </form>

                </div>
            </div>
        


        <div class="w-full overflow-hidden">
            <!-- CC Limit Application Info  -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black font-semibold text-lg">CC Limit Application Info</h3>
                    <!-- Toggle Button -->
                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>
                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 hidden">
                    <table class="w-full text-sm whitespace-nowrap text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2 w-1/3">Application Date</td>
                                <td class="px-3 py-2">{{ $disbursement->application_date }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Application Status</td>
                                <td class="px-3 py-2">Approved</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Application No</td>
                                <td class="px-3 py-2">{{ $disbursement->id }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Branch</td>
                                <td class="px-3 py-2">{{ $disbursement->branch->branch_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Member</td>
                                <td class="px-3 py-2">{{ $disbursement->member->id ?? '' }} - {{ $disbursement->member->member_info_first_name ?? '' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">1st Co-Applicant Member</td>
                                <td class="px-3 py-2">{{ $disbursement->coApplicant1->id ?? '' }} - {{ $disbursement->coApplicant1->member_info_first_name ?? '' }}
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Requested</td>
                                <td class="px-3 py-2">{{ $disbursement->net_loan_amount ?? '' }}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Approvable</td>
                                <td class="px-3 py-2">
                                 ₹ 100,000.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Amount Approved</td>
                                <td class="px-3 py-2">
                                    ₹ 200,000.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interst Type</td>
                                <td class="px-3 py-2">
                                 FLAT ADVANCED
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Interest Amount</td>
                                <td class="px-3 py-2">
                                ₹ 10,500.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Annual Interest Rate</td>
                                <td class="px-3 py-2">
                                    15.0 %
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Credit Period</td>
                                <td class="px-3 py-2">
                                   1 Days
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Total Amount to Recover</td>
                                <td class="px-3 py-2">
                                   ₹ 80,501.00
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Tenure of Loan</td>
                                <td class="px-3 py-2">
                                   12 MONTHS
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Collect Principal Amount as EMI</td>
                                <td class="px-3 py-2">
                               <span                                         class="block w-28  rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                          Yes
                                        </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Processing Fee</td>
                                <td class="px-3 py-2">
                                    {{ number_format($total, 2, '.', '') }}  (Incl. 18.0 % GST)
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Stamp Duty Fee</td>
                                <td class="px-3 py-2">
                                   ₹ 1.00  (Incl. 18.0 % GST)
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="font-semibold px-3 py-2">Insurance Fee</td>
                                <td class="px-3 py-2">
                                   {{ $disbursement->insurance_amount ?? 0 }} (Incl. 18.0 % GST)
                                </td>
                            </tr>
                          
                        </tbody>
                    </table>

                </div>

            </div>
        </div>


    </div>
</div>



<!-- collapsed logic + - button-->
<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }

    document.addEventListener("DOMContentLoaded", function () {
        const checkboxes = document.querySelectorAll(".toggle-paymode");

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", function () {
                const targetId = this.dataset.target;
                const target = document.getElementById(targetId);

                if (target) {
                    target.classList.toggle("hidden", !this.checked);
                }
            });
        });
    });
</script>
    

@endsection