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
            <h4 class=" flex text-xl block  uppercase font-semibold">
              Loan Approval - History
            </h4>  
        </div>

      
        <div class="col-span-12 box lg:col-span-12">
            
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    MEMBER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C TYPE
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    APPLICATION NO.
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    AMT. REQUESTED
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CALCULATED APPROVAL
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
                                    CREATED AT
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   APPROVED AT
                                </div>
                            </th>
                            
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   	APPROVED BY
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   REMARKS
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                     {{ $application->branch->branch_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 Capitalize">
                                    <span class="text-primary">
                                        {{ $application->member->member_info_first_name ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">

                                    @switch($application->model_type)
                                        @case('loan')
                                            Gold Loan
                                            @break
                                        @case('mortgage')
                                            Mortgage Loan
                                            @break
                                        @case('loan_against')
                                            Loan Against
                                            @break
                                        @case('business_loan')
                                            Business Loan
                                            @break
                                        @case('cc_od')
                                            CC / OD Loan
                                            @break
                                        @case('daily_weekly')
                                            Daily / Weekly Loan
                                            @break
                                             @case('personal')
                                            Personal Loan
                                            @break
                                             @case('vehical')
                                            Vehical Loan
                                            @break
                                        @default
                                            Unknown Type
                                    @endswitch

                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center  gap-1">
                                    <span class="text-primary">
                                        {{ $application->id }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">                   
                                   @if($application->model_type == 'daily_weekly')
                                   {{ $application->loan_amount }}
                                    @else
                                    {{ $application->max_loan_amount }}
                                    @endif
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    @if($application->model_type == 'daily_weekly')
                                        {{ $application->loan_amount }}
                                    @elseif($application->model_type == 'personal')
                                    {{ $application->approved_loan_amount }}
                                    @else
                                        {{ $application->maximum_approvable_amount }}
                                    @endif
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    @if($application->model_type == 'daily_weekly')
                                        <input type="number"
                                            value="{{ $application->loan_amount }}"
                                            class="border py-2 bg-secondary/5 rounded-10 px-3">
                                    @else
                                        <input type="number"
                                            value="{{ $application->approved_loan_amount }}"
                                            class="border py-2 bg-secondary/5 rounded-10 px-3">
                                    @endif
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    Approved
                                </div>
                            </td>
                             <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                   {{ $application->created_at }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  {{ $application->updated_at }}
                                </div>
                            </td>
                              <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                  -
                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                 <div class="flex items-center gap-1">
                                 -
                                </div>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection