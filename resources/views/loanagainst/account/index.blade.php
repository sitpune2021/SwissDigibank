@extends('layout.main')
@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h1 class=" flex text-xl block  uppercase font-semibold">LOAN AGAINST DEPOSITE</h1>
        <!-- <a href="#" class=" block flex btn-primary capitalize ">
            Add
        </a> -->
    </div>

    <div class="col-span-12 box lg:col-span-12">
        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                ASSOCIATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                GROUP
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                LOAN NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CUSTOMER NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
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
                                EMI COLLECTION
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                OPEN DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CLOSE DATE
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                STATUS
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                LOAN AMT.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                            <div class="flex items-center gap-1">
                                CURRENT DEBT
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
                    
                    @foreach ($goldLoan as $loan)
                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    <!-- {{ $loan->member->member_info_first_name ?? 'N/A' }} --> -
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 capitalize">
                                    -
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center text-secondary gap-1">
                                    <a href="{{ route('loanagainst.account.show', $loan->id) }}" 
                                        class="text-blue-600 hover:underline">
                                        {{ $loan->id }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center text-secondary gap-1">
                                    <a href="{{ url('members/member/' . $loan->member_id) }}" 
                                        class="text-blue-600 hover:underline">
                                        {{ $loan->member->member_no ?? 'N/A' }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    {{ $loan->member->member_info_first_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    {{ $loan->branch->branch_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 capitalize">
                                    <!-- {{ $loan->purpose_of_loan ?? 'N/A' }} -->
                                    {{ $loan->scheme->scheme_name ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    {{ strtoupper($loan->emi_collection ?? '-') }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    {{ \Carbon\Carbon::parse($loan->application_date)->format('d-m-Y') ?? '-' }}
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">{{ $loan->close_date ? \Carbon\Carbon::parse($loan->close_date)->format('d-m-Y') : '-' }}</td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                @if($loan->foreclosure_status == 'Active')
                                    <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-center text-xs text-primary">
                                        Active
                                    </span>
                                    @else
                                    <span class="block w-28 rounded-[30px] border bg-error/20 py-2 text-center text-xs text-error">
                                        Fore Close
                                    </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    {{ number_format($loan->loan_amount ?? 0, 2) }}

                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">{{ number_format($loan->current_debt, 2) }}</td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                        'id' => $loan->id,
                                        'viewRoute' => 'loanagainst.account.show',
                                    ])
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if($goldLoan->isEmpty())
                        <tr>
                            <td colspan="15" class="text-center py-4 text-gray-500">
                                No records found
                            </td>
                        </tr>
                    @endif

                </tbody>

            </table>
        </div>
    </div>
    @endsection