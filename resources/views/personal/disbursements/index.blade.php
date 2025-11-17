@extends('layout.main')
@section('content')
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
    </style>
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h1 class=" flex text-xl block  uppercase font-semibold">
                Personal Loan Disbursements
            </h1>
            
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  APPLICATION NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    APPLICATION DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  CUSTOMER NO
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   CUSTOMER NAME
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    SCHEME
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   	APPROVED AMT.
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th>
                           
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>
                   <tbody>
                    @foreach($disbursements as $disbursement)
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6">
                            <a href="{{ route('personal.applications.view', $disbursement->id) }}" 
                                class="text-blue-600 hover:underline">
                                    {{ $disbursement->id }}
                                </a>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1">
                                    {{ \Carbon\Carbon::parse($disbursement->application_date)->format('d-m-Y') }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1 text-secondary">
                                    <a href="{{ url('members/member/' . $disbursement->member_id) }}" 
                                class="text-blue-600 hover:underline">
                                    {{ str_pad($disbursement->member_id, 6, '0', STR_PAD_LEFT) }}
                                </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1">
                                    {{ $disbursement->member->member_info_first_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1">
                                    {{ $disbursement->branch->branch_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1 uppercase">
                                    {{ $disbursement->scheme->scheme_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6">
                                <div class="flex items-center gap-1">
                                    {{ number_format($disbursement->approved_loan_amount, 2) }}
                                </div>
                            </td>
                        <td class="text-start !py-5 px-6">
                                @if($disbursement->status == 0)
                                    Draft
                                @elseif($disbursement->status == 1)
                                    Approved
                                @else
                                    Disbursed
                                @endif
                            </td>

                            <td class="text-start !py-5 px-6">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                            <a href="{{ route('personal.disbursements.disburse-loan', $disbursement->id) }}" class="single-option uppercase">Disburse Loan</a>
                                            </li>
                                            <li>
                                        <form action="{{ route('personal.cancel', $disbursement->id) }}" 
                                                method="POST" 
                                                onsubmit="return confirm('Are you sure you want to cancel this loan?');">
                                                @csrf
                                                <button type="submit" class="single-option uppercase text-red-600 hover:underline">
                                                    Cancel Loan
                                                </button>
                                            </form>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                </table>
                 <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $disbursements->links() }}
                </div>
            </div>
        </div>
@endsection 