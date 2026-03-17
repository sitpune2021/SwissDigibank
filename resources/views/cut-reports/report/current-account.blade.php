@extends('layout.main')
@section('content')

    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-lg block  uppercase font-semibold">
                Reports - Current Accounts
            </h3>
        </div>
        <div class="col-span-12 box lg:col-span-12">
            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">
                <a href="{{ route('reports.saving.print') }}" target="_blank"
                    class="btn-primary rounded-10 px-2 py-2 flex justify-center  text-sm uppercase">
                    <i class="las la-print"></i>
                    Print Report
                </a>
                <a href="{{route('report.saving.index')}}"
                    class="btn-primary rounded-10 px-2 py-2 flex justify-center  text-sm uppercase">
                    <i class="las la-download"></i>
                    download Cut Report
                </a>
                <a href="{{ route('accounts.export.csv') }}"
                    class="btn-error rounded-10 px-2 flex justify-center py-2 text-sm uppercase">
                    <i class="las la-download"></i>
                    Download Csv
                </a>

            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">

                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACCOUNT NO.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ACCOUNT TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    MEMBER NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    BRANCH
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ENROLLMENT DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    STATUS
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($account as $row)
                                        <tr class="border-b dark:border-bg3">
                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1 uppercase">
                                                    <a href="{{ $row?->id ? route('accounts.show', base64_encode($row->id)) : '#' }}"
                                                        class="text-primary">
                                                        {{ $row->account_no ?? ''}}
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1 uppercase">                   
                                                        {{ $row->account_type ?? ''}}                                                
                                                </div>
                                            </td>

                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1 capitalize">
                                                    {{ $row->members->member_info_first_name ?? '' }}
                                                    {{ $row->members->member_info_last_name ?? '' }}
                                                </div>
                                            </td>

                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1">
                                                    {{ $row->branch->branch_name ?? '' }}
                                                </div>
                                            </td>

                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1">
                                                    {{ $row->members?->general_enrollment_date
                            ? \Carbon\Carbon::parse($row->open_date)->format('d-m-Y')
                            : '' }}
                                                </div>
                                            </td>

                                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                                <div class="flex items-center gap-1">
                                                    {{ $row->final_status }}
                                                </div>
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            <div class="mt-5">
                <x-pagination :paginator="$account" />
            </div>
        </div>


        <!-- BACKDROP -->
        <div id="loanModal"
            class="fixed inset-0 z-50 hidden bg-black/60 flex items-start justify-center overflow-y-auto pt-10">

            <!-- MODAL CONTAINER -->
            <div class="w-full max-w-3xl mt-5 rounded-lg shadow-xl bg-white">

                <div class="box">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between border-b px-4 py-3">
                        <h4 class="w-full text-center text-lg font-semibold uppercase tracking-wide">
                            LOAN INFO
                        </h4>

                        <button type="button"
                            class="ml-4 inline-flex h-8 w-8 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100"
                            onclick="closeLoanModal()">
                            &times;
                        </button>
                    </div>

                    <!-- BODY -->
                    <div class="p-4 sm:p-6 space-y-6">

                        <!-- Loan info table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <tbody class="divide-y divide-gray-200">

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Member No :</td>
                                        <td colspan="3" class="py-2 underline">
                                            <a href="" class="text-primary">
                                                DEMO-03253 - LAVANYA K
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Account Type :</td>
                                        <td class="py-2 pr-4">DD</td>
                                        <td class="font-semibold uppercase py-2 pr-4">Account No :</td>
                                        <td class="py-2 underline">
                                            <a href="" class="text-primary">
                                                DDA01450
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Inst Due :</td>
                                        <td class="py-2 pr-4">188</td>
                                        <td class="font-semibold uppercase py-2 pr-4">Due Date :</td>
                                        <td class="py-2">17/01/2023</td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Saving Bal :</td>
                                        <td class="py-2 pr-4"></td>
                                        <td class="font-semibold uppercase py-2 pr-4">Amt to Collect :</td>
                                        <td class="py-2">282,000.00</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                        <!-- Last credit table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">

                                <thead>
                                    <tr>
                                        <th colspan="5" class="bg-gray-50 py-2 text-center text-lg font-semibold uppercase">
                                            Last Credit Transaction Info
                                        </th>
                                    </tr>
                                    <tr class="border-b text-md font-medium uppercase text-gray-500">
                                        <th class="py-2 pr-4 text-start">Trans Id</th>
                                        <th class="py-2 pr-4 text-start">T Date</th>
                                        <th class="py-2 pr-4 text-start">Pay Mode</th>
                                        <th class="py-2 pr-4 text-start">Amount</th>
                                        <th class="py-2 text-start">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="py-2 pr-4">DD6491</td>
                                        <td class="py-2 pr-4">13-12-2024</td>
                                        <td class="py-2 pr-4">Cash</td>
                                        <td class="py-2 pr-4">1500.0</td>
                                        <td class="py-2">
                                            <div class="flex items-center gap-1">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-yellow-100 py-2 text-center text-xs text-yellow-600">
                                                    Pending
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        <hr />

                        <!-- Comment Form -->
                        <form class="space-y-4 mt-4">
                            <label class="text-lg uppercase font-medium">Add New Comment <span
                                    class="text-red-500">*</span></label>

                            <textarea
                                class="w-full bg-secondary/5 rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500"
                                rows="3" placeholder="Write Your Comment Here..."></textarea>

                            <div class="flex items-center justify-center gap-3 pt-2">

                                <button type="submit" class="btn-primary uppercase">
                                    SAVE
                                </button>

                                <button type="button" onclick="closeLoanModal()" class="btn-outline uppercase">
                                    Back
                                </button>

                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>

@endsection