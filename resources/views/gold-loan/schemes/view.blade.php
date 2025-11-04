@extends('layout.main')
@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
    }
</style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <div class="flex items-center gap-3">
                <h1 class="text-xl font-semibold capitalize">
                    {{ $scheme->scheme_name }}
                </h1>
                <p class="text-gray-500 text-sm font-semibold">
                    Gold Loan Scheme
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
        <div class="box col-span-2 md:col-span-1">
            <!-- Edit Button -->
            <div class="flex justify-end mb-4" style="padding-left: 400px;">
                <a href="{{ route('gold-loan.schemes.edit', $scheme->id) }}" class="btn-primary px-2 py-2">
                    <i class="las la-pencil-alt"></i>
                </a>
            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="w-full  text-sm md:text-base">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3 w-1/2">Scheme Code</td>
                            <td class="p-3">{{ $scheme->scheme_code }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Scheme Name</td>
                            <td class="p-3">{{ $scheme->scheme_name }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Tenure</td>
                            <td class="p-3">{{ $scheme->tenure }} Months</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Maximum Loan Amount</td>
                            <td class="p-3">₹ {{ number_format($scheme->max_loan_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Maximum Loan Limit Against Deposit</td>
                            <td class="p-3">{{ $scheme->max_loan_limit }} % </td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Minimum Loan Amount</td>
                            <td class="p-3">₹ {{ number_format($scheme->min_loan_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Annual Interest Rate</td>
                            <td class="p-3">{{ $scheme->annual_interest_rate }} %</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Interest Type</td>
                            <td class="p-3">{{ $scheme->gold_loan_setting }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Fore Closure Charges</td>
                            <td class="p-3">₹ {{ number_format($scheme->fore_closer_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Stamp Duty Fee</td>
                            <td class="p-3">₹ {{ number_format($scheme->stamp_duty_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Insurance Charges</td>
                            <td class="p-3">₹ {{ number_format($scheme->insurance_fee, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Processing Fee</td>
                            <td class="p-3">{{ $scheme->processing_fee }} %</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Penalty Charge</td>
                            <td class="p-3">{{ $scheme->penalty_charge }} %</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Overdue Interest Rate (%)</td>
                            <td class="p-3">{{ $scheme->overdue_interest_rate }} %</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">SMS Charges per EMI</td>
                            <td class="p-3">₹ {{ number_format($scheme->sms_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Fuel Charges per EMI</td>
                            <td class="p-3">₹ {{ number_format($scheme->fuel_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Stationary Charges per EMI</td>
                            <td class="p-3">₹ {{ number_format($scheme->stationary_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Maintenance Charges per EMI</td>
                            <td class="p-3">₹ {{ number_format($scheme->maintenance_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Collection Charges per EMI</td>
                            <td class="p-3">₹ {{ number_format($scheme->collection, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Credit Period</td>
                            <td class="p-3">{{ number_format($scheme->credit_period) }} Days</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold p-3">Active</td>
                            <td class="p-3">
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                    {{ $scheme->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Created at</td>
                            <td class="p-3">{{ $scheme->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold p-3">Updated at</td>
                            <td class="p-3">{{ $scheme->updated_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


            @php
                // If it's already array, use it directly; otherwise decode
                $emiSlabs = is_array($scheme->no_emi_slabs)
                    ? $scheme->no_emi_slabs
                    : json_decode($scheme->no_emi_slabs ?? '[]', true);

                $goldLoanSetting = strtolower($scheme->gold_loan_setting ?? '');
            @endphp


            {{-- Show only when gold_loan_setting = "no_emi" and valid slab data --}}
            @if($goldLoanSetting === 'no_emi' && !empty($emiSlabs) && collect($emiSlabs)->whereNotNull('from_date')->count() > 0)
            <div class="box col-span-2 md:col-span-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg capitalize">INTEREST CHART</h1>
                    <p class="text-gray-500 text-sm font-semibold">
                        Charge Floating Interest Rate per Slab
                    </p>
                    <span
                        class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3">
                        {{ $scheme->floating_interest ?? 'No' }}
                    </span>
                </div>

                <hr class="mb-3 mt-2">

                <div class="tableWidth mt-2 px-4">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-secondary/5 text-sm text-black">
                                <tr>
                                    <th colspan="2" class="text-center py-3">DAYS</th>
                                    <th rowspan="2" class="text-center">PENAL INTEREST<br>RATE (%) (MONTHLY)</th>
                                    <th rowspan="2" class="text-center py-3">ANNUAL INTEREST RATE (%)</th>
                                </tr>
                                <tr>
                                    <th class="text-center">FROM</th>
                                    <th class="text-center">TO</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 text-sm text-center">
                                @foreach($emiSlabs as $slab)
                                    @if(!empty($slab['from_date']) && !empty($slab['to_date']))
                                        <tr class="bg-gray-50 border-b">
                                            <td class="px-4 py-2 text-sm">{{ $slab['from_date'] }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $slab['to_date'] }}</td>
                                            <td class="px-4 py-2 text-sm">{{ $slab['penal_rate_interest'] ?? 0 }} %</td>
                                            <td class="px-4 py-2 text-sm">{{ $slab['annual_rate_interest'] ?? 0 }} %</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif


        </div>

    <div class="w-full mt-5" col-span-4 md:col-span-1>
        <!-- Card -->
        <div class="box shadow-md rounded-10">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 dark:bg-bg3 bg-secondary/5 rounded-10 ">
                <h3 class="text-lg font-semibold text-gray-800">GOLD LOAN SETTING AUDIT TRAIL</h3>
                <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'auditTrail')">
                    <span class="toggle-icon text-lg font-bold">−</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4" id="auditTrail">
                <div class="overflow-x-auto">
                    <table class="w-full  text-sm md:text-base">
                        <thead class="bg-gray-100">
                            <tr class="text-start">
                                <th class="px-4 py-2 text-start">Creator</th>
                                <th class="px-4 py-2 text-start">Event</th>
                                <th class="px-4 py-2 text-start ">Created On</th>
                                <th class="px-4 py-2 text-start">Change Logs</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="text-start">
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // <!-- collapsed logic + - button-->

    function toggleSection(button, sectionId) {
        const section = document.getElementById(sectionId);
        const icon = button.querySelector('.toggle-icon');

        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>

@endsection