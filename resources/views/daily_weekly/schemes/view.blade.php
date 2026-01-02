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
                <h1 class="text-xl font-semibold uppercase">
                    {{ $scheme->scheme_name }}
                </h1>
                <p class="text-gray-500 text-sm font-semibold">
                    DAILY WEEKLY LOAN SCHEME
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
        <div class="box col-span-2 md:col-span-1">
            <!-- Edit Button -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('daily_weekly.schemes.edit', $scheme->id) }}" class="btn-primary px-2 py-2">
                    <i class="las la-pencil-alt"></i>
                </a>

            </div>

            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="w-full  text-sm md:text-base">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3 w-1/2">Scheme Code</td>
                            <td class="p-3">{{ $scheme->scheme_code }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Scheme Name</td>
                            <td class="p-3">{{ $scheme->scheme_name }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Tenure</td>
                            <td class="p-3">{{ $scheme->no_of_emi }} {{ ucfirst($scheme->gold_loan_setting) }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Maximum CC Limit</td>
                            <td class="p-3">₹ {{ number_format($scheme->max_loan_amount, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Annual Interest Rate</td>
                            <td class="p-3">{{ $scheme->annual_interest_rate }} %</td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Overdue Interest Rate (%)</td>
                            <td class="p-3">{{ $scheme->overdue_rate }} of {{ $scheme->overdue_type }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Fore Closure Charges</td>
                            <td class="p-3">₹ {{ number_format($scheme->fore_closer_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Stamp Duty Fee</td>
                            <td class="p-3">₹ {{ number_format($scheme->stamp_duty_charge, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Insurance Charges</td>
                            <td class="p-3">₹ {{ number_format($scheme->insurance_fee, 2) }}</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Processing Fee</td>
                            <td class="p-3">{{ $scheme->processing_fee }} %</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Penalty Charge</td>
                            <td class="p-3">{{ $scheme->penalty_charge }} %</td>
                        </tr>
                         <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Credit Period</td>
                            <td class="p-3">
                                {{ rtrim(rtrim(number_format($scheme->credit_period, 2), '0'), '.') }}
                                {{ $scheme->credit_period == 1 ? 'Day' : 'Days' }}
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b ">
                            <td class="font-semibold uppercase  p-3">Active</td>
                            <td class="p-3">
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 {{ $scheme->is_active ? 'bg-primary/20 text-primary' : 'bg-red-200 text-red-600' }} py-2 text-center text-xs dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    {{ $scheme->is_active ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold uppercase  p-3">Created at</td>
                            <td class="p-3">{{ $scheme->created_at->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <td class="font-semibold uppercase  p-3">Updated at</td>
                            <td class="p-3">{{ $scheme->updated_at->format('d-m-Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div></div>

        </div>

    <div class="w-full mt-5" col-span-4 md:col-span-1>
        <!-- Card -->
        <div class="box shadow-md rounded-10">
            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 dark:bg-bg3 bg-secondary/5 rounded-10 ">
                <h3 class="text-lg font-semibold text-gray-800">DAILY / WEEKLY LOAN SETTING AUDIT TRAIL</h3>
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
                                <th class="px-4 py-2 text-start uppercase">Creator</th>
                                <th class="px-4 py-2 text-start uppercase">Event</th>
                                <th class="px-4 py-2 text-start uppercase ">Created On</th>
                                <th class="px-4 py-2 text-start uppercase">Change Logs</th>
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