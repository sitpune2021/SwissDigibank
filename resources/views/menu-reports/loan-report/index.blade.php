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

    .bg-greens {
        background-color: #14532d;
    }

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            DOWNLOAD LOAN REPORT
        </h3>
    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 gap-6  md-4">
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

            <form method="GET" action="{{ route('loan-report.index') }}">


                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Account Type -->
                    <div>
                        <label for="loan_type" class="block text-sm font-medium mb-2">
                            Account Type <span class="text-red-600">*</span>
                        </label>
                        <select name="loan_type" id="loan_type"
                            class="w-full border bg-secondary/5 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
                            <option value="">Select Loan Type</option>
                            <option value="gold_loan" {{ request('loan_type')=='gold_loan' ? 'selected' : '' }}>Gold
                                Loan
                            </option>
                            <option value="mortgage_loan" {{ request('loan_type')=='mortgage_loan' ? 'selected' : '' }}>
                                Prop./Mortgage Loan</option>
                            <option value="loan_against" {{ request('loan_type')=='loan_against' ? 'selected' : '' }}>
                                Loan Against</option>
                            <option value="cc_od" {{ request('loan_type')=='cc_od' ? 'selected' : '' }}>
                                CC OD Loan </option>
                            <option value="other_loan" {{ request('loan_type')=='other_loan' ? 'selected' : '' }}>
                                Business
                                Loan</option>

                            <option value="daily_weekly" {{ request('loan_type')=='daily_weekly' ? 'selected' : '' }}>
                                Daily Weekly Loan</option>
                            <option value="personal_loan" {{ request('loan_type')=='personal_loan' ? 'selected' : '' }}>
                                Personal Loan</option>

                            <option value="fixed_loan" {{ request('loan_type')=='fixed_loan' ? 'selected' : '' }}>Fixed
                                Loan</option>

                            <option value="vehicle_loan" {{ request('loan_type')=='vehicle_loan' ? 'selected' : '' }}>
                                Vehicle Loan</option>

                        </select>
                    </div>

                    <!-- Loan Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            Loan Status <span class="text-red-600">*</span>
                        </label>
                        <select name="status" id="status"
                            class="w-full border bg-secondary/5 rounded-lg px-3 py-2  focus:ring-2 focus:ring-green-500 focus:outline-none">
                            <option>Select Loan status</option>
                            <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                            <option value="fore_closed">Fore Closed
                            </option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                </div>

                <!-- Submit -->
                <div class="text-center pt-4">
                    <button type="submit" class="btn-primary text-sm rounded-10">
                        <span class="fa fa-list"></span>
                        LIST REPORT
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="col-span-12 box lg:col-span-12 mt-5">

        <div class="flex  justify-end">

            <button class="btn-error uppercase rounded-10 py-2 text-sm">
                <i class="las la-download"></i>
                Download Reports
            </button>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6 mt-5">

            <table class="w-full whitespace-nowrap select-all-table" id="">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                            <div class="flex items-center gap-1 uppercase">
                                MEMBER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                MEMBER NO.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                ACCOUNT NO.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DISBURSEMENT TILL DATE
                            </div>
                        </th>

                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TOTAL RECEIVED
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DAILY COLLECTION
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TENURE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                LOAN DISBURSE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DOJ
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DOM
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                AGENT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                CONTACT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TO CLOSE TODAY
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                TO RCV TILL DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                BACKFALL
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DAYS STATUS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DAYS EXCEED BY
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                CLOSURE ALERT
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                PROCESSING FEE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                DISBURSE DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                MODE OF DISBURSE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1 uppercase">
                                SCHEME
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr class="border-b ">

                        <td class="px-6 py-3">
                            {{ ($loan->member->member_info_first_name ?? '-') .' '.($loan->member->member_info_last_name
                            ?? '-') }}
                        </td>

                        <td class="px-6 py-2">
                            {{ $loan->member->member_no ?? '-' }}
                        </td>

                        <td class="px-6 py-2">
                            {{ $loan->application_no?? str_pad($loan->id, 10, '0', STR_PAD_LEFT) }}

                            {{-- {{ str_pad( $loan->application_no, 10, '0', STR_PAD_LEFT) ?? str_pad($loan->id, 10,
                            '0', STR_PAD_LEFT) }} --}}
                        </td>

                        <td class="px-6 py-2">
                            {{-- {{ $loan->disbursement->amount ?? 0 }} --}}
                            {{ $loan->loan_amount ?? '-' }}
                        </td>

                        <td class="px-6 py-2">
                            {{ $loan->emiPayments->sum('amount') }}
                        </td>

                        <td class="px-6 py-2">{{ $loan->emi_amount ?? $loan->charge_per_emi ?? '-' }}</td>

                        <td class="px-6 py-2">{{ $loan->tenure_value ?? '-' }}</td>

                        <td class="px-6 py-2">{{ $loan->loan_amount ?? '-' }}</td>

                        <td class="px-6 py-2">{{ $loan->member->date_of_joining ?? '-' }}</td>

                        <td class="px-6 py-2">
                            @php
                            $date = $loan->disbursement?->disbursal_date;
                            @endphp
                            {{ $date ? \Carbon\Carbon::parse($date)->format('d-m-Y') : '-' }}
                        </td>
                        <td class="px-6 py-2">{{ $loan->member->date_of_maturity ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $loan->member->member_info_mobile_no ?? '-' }}</td>
                        <td class="px-6 py-2">{{ $loan->advisor_id ?? '-' }}</td>



                        <td class="px-6 py-2">-</td>
                        <td class="px-6 py-2">-</td>
                        <td class="px-6 py-2">-</td>
                        <td class="px-6 py-2">-</td>
                        <td class="px-6 py-2">-</td>


                        <td class="px-6 py-2">{{ $loan->processing_fee_total ?? '-' }}</td>

                        <td class="px-6 py-2">

                            @php
                            $date = $loan->disbursement?->disbursal_date;
                            @endphp
                            {{-- {{ $loan->disbursement->disbursal_date
                            ? \Carbon\Carbon::parse($loan->disbursement->disbursal_date)->format('d-m-Y')
                            : '-' }} --}}
                              {{ $date ? \Carbon\Carbon::parse($date)->format('d-m-Y') : '-' }}
                        </td>

                        <td class="px-6 py-2">{{ $loan->transfer_mode ?? '-' }}</td>

                        <td class="px-6 py-2">{{ $loan->scheme->scheme_name ?? '-' }}</td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="21" class="text-center py-4">No records found</td>
                    </tr>
                    @endforelse
                </tbody>




            </table>

        </div>


    </div>
</div>


@endsection