@extends('layout.main')
@section('content')
<style>
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

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    /* Container for the toggle background */
    .blocks {
        width: 56px;
        /* 14 * 4px */
        height: 32px;
        /* 8 * 4px */
        border-radius: 9999px;
        /* Fully rounded */
        background-color: #9CA3AF;
        /* Tailwind gray-400 default */
        transition: background-color 0.3s ease;
    }

    /* The small white dot */
    .dot {
        position: absolute;
        top: 4px;
        /* 1 * 4px */
        left: 4px;
        /* 1 * 4px */
        width: 24px;
        /* 6 * 4px */
        height: 24px;
        /* 6 * 4px */
        background-color: white;
        border-radius: 9999px;
        transition: transform 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
    }

    /* When the checkbox is checked, change bg color */
    input[type="checkbox"].slider-toggle:checked+div .blocks {
        background-color: #228cc5;
        /* Tailwind green-500 */
    }

    /* Move the dot to right when checked */
    input[type="checkbox"].slider-toggle:checked+div .dot {
        transform: translateX(24px);
        /* 6 * 4px */
    }
</style>
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg font-semibold">FD ACCOUNT - {{ $fdAccount->id }}</h1>
            <!-- <p class="text-gray-500">
            <a href="#" class="text-gray-500">FD Account</a> >
                                                                                        <a href="#" class="text-gray-500"> {{ $fdAccount->id }}</a>
                              </p> -->
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <a href="{{ route('fd-mis-account.fd-payoutplan.fdpayoutplan', $fdAccount->id) }}"
            class="btn-warning px-4 py-2 text-sm rounded-10">
            FD PAYOUT PLAN
        </a>
        <a href="{{ route('fd-accounts.transactions', $fdAccount->id) }}"
            class="btn-primary px-4 py-2  text-sm rounded-10">
            VIEW TRANSACTIONS
        </a>


        <div x-data="{ open: false }" class="relative inline-block">
            <a @click="open = !open"
                class="btn-secondary px-2 py-2 text-sm  cursor-pointer rounded-10 flex items-center justify-between space-x-2">
                ACCOUNT DETAILS
                <i class="las la-angle-down text-sm transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </a>
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2">
                    <li>
                        <a href="{{ route('fd.change.account.info', $fdAccount->id) }}"
                            class="block px-4 py-2 uppercase text-start  text-black border-b hover:bg-gray-100">Change A/c Info</a>
                    </li>
                    <li>
                        <a href="{{ route('fd.add.nominee', ['type' => 'fd', 'id' => base64_encode($fdAccount->id)]) }}"
                            class="block px-4 py-2 uppercase   text-black border-b hover:bg-gray-100">Add Nominee</a>
                    </li>
                    <li>
                        <a href="{{ route('fd.foreclose.account', $fdAccount->id) }}"
                            class="block px-4 py-2 uppercase   text-black border-b hover:bg-gray-100">Fore Close</a>
                    </li>
                    <li>
                        <a href=""
                            class="block px-4 py-2 uppercase   text-black border-b hover:bg-gray-100">Remove Account</a>
                    </li>
                </ul>
            </div>
        </div>

        @if($fdAccount->status == 1)
        <button class="btn-primary px-4 py-2  text-sm rounded-10 ">
            RELEASE INTEREST
        </button>

        @if ($fdAccount->link_status != 1)
        <a href="{{ route('fd-accounts.createLinkSavingAcc', $fdAccount->id) }}"
            class="btn-warning px-2 py-2 rounded-10 text-sm flex items-center justify-between space-x-2">
            LINK SAVING ACCOUNT (AUTO DEBIT)
        </a>
        @endif

        <a class="btn-primary text-sm px-4 py-2 rounded-10 cursor-pointer">
            MARK LIEN AGAINST LOAN
        </a>

        <!-- INTEREST/TDS Button -->
        <div class="relative inline-block text-left">
            <a id="interestButton" class="btn-primary text-sm cursor-pointer px-4 rounded-10">
                <span class="text-sm ">INTEREST/TDS</span>
                <i id="interestArrow" class="las la-angle-down text-sm"></i>
            </a>

            <div id="interestMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
                <a href="{{ route('fd-account.creditDebitInterest', $fdAccount->id) }}"
                    class="block px-4 py-2 border-b uppercase  ">CREDIT/DEBIT INTEREST</a>
                <a href="{{ route('fd-account.deductReverseTds', $fdAccount->id) }}"
                    class="block px-4 py-2 uppercase  border-b  ">DEDUCT/REVESRE TDS</a>

            </div>
        </div>
@endif
        <!-- Print Documents -->
        <div x-data="{ open: false }" class="relative inline-block">

            <a @click="open = !open"
                class="btn-secondary px-2 py-2 rounded-10 flex items-center cursor-pointer justify-between text-sm space-x-2">
                <i class="las la-print "></i><span class="text-sm">PRINT DOCUMENTS</span>
                <i class="las la-angle-down text-sm transition-transform duration-300"
                    :class="{ 'rotate-180': open }"></i>
            </a>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false"
                class="absolute mt-2 w-48 bg-white border border-gray-300 rounded-lg shadow-lg z-50">
                <ul class="py-2">
                    <li>
                        <a href="{{ route('fd.bond.view', $fdAccount->id) }}"
                            class="block px-4 border-b py-2 text-gray-700 hover:bg-gray-100 "><i class="las la-print"></i>
                            FD BOND</a>
                    </li>
                    <li>
                        <a href="{{ route('fd.opening.view', $fdAccount->id) }}"
                            class="block px-4 border-b py-2 text-gray-700 hover:bg-gray-100 "><i class="las la-print"></i>
                            ACCOUNT OPENING FORM</a>
                    </li>
                    <li>
                        <a href="{{ route('fd.closing.view', $fdAccount->id)}}"
                            class="block px-4 border-b py-2 text-gray-700 hover:bg-gray-100 "><i class="las la-print"></i>
                            CLOSING FORM</a>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Show Audit Trail -->
        <button class="btn-primary text-sm px-4 py-2 rounded-10 ">
            SHOW AUDIT TRAIL
        </button>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-3 bg-white shadow-md">
                <!-- <div class="text-end p-3">
                                                                                                                                                     <a href="#" class=" p-2 btn-outline">
                                                                                                                                                            <i class="las la-pen"></i>
                                                                                                                                                        </a>
                                                                                                                                                    </div> -->
                <table class="w-full p-2 text-sm text-left border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3 uppercase">CUSTOMER</td>
                            <td class="px-4 py-2">
                                <a href="{{ $fdAccount?->member?->id ? route('member.show', $fdAccount->member->id) : '#' }}"
                                    class="text-primary hover:underline">
                                    {{ $fdAccount->member?->member_no ??
                                    ($fdAccount->member?->id ? str_pad($fdAccount->member->id, 6, '0', STR_PAD_LEFT) :
                                    'N/A') }}
                                    -
                                    {{ $fdAccount->member?->member_info_first_name }}
                                    {{ $fdAccount->member?->member_info_last_name }}
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold  px-4 py-2 uppercase">Create on</td>
                            <td class="px-4 py-2">Admin App static*</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Created by</td>
                            <td class="px-4 py-2">Test Test static*</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">FD No.</td>
                            <td class="px-4 py-2">{{ $fdAccount->fd_no }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Old FD No.</td>
                            <td class="px-4 py-2"> static*—</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Scheme</td>
                            <td class="px-4 py-2">{{ $fdAccount->fdscheme->scheme_name }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Principal Amount</td>
                            <td class="px-4 py-2">₹ {{ $fdAccount->fd_amount }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Open Date</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($fdAccount->created_at)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Maturity Date</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($fdAccount->maturity_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <!-- <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Tenure of FD/MIS</td>
                            <td class="px-4 py-2">
                                {{ $fdAccount->tenure_year }}Y,{{ $fdAccount->tenure_month }}M,{{
                                $fdAccount->tenure_days }}D
                            </td>
                        </tr> -->
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Interest Payout Type</td>
                            <td class="px-4 py-2">{{ $fdAccount->interest_payout_type }}</td>
                        </tr>

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Close Date</td>
                            <td class="px-4 py-2">{{ optional($fdAccount->close_date)->format('d-m-Y') ?? '-' }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                            <td class="px-4 py-2">{{ $fdAnnualInterest }} %</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Balance Available</td>
                            <td class="px-4 py-2">
                                ₹{{ number_format($fdBalance, 2) }}
                            </td>
                        </tr>

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Status</td>
                            <td class="px-4 py-2">Fore close approved static*</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">TDS Deduction</td>
                            <td class="px-4 py-2">
                                @if ($fdAccount->tds_deduction == 1)
                                <span
                                    class="px-2 py-1  font-medium rounded bg-green-100 text-green-600">Yes</span>
                                @else
                                <span class="px-2 py-1  font-medium rounded bg-red-100 text-red-600">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Special Account</td>
                            <td class="px-4 py-2"><span
                                    class="px-2 py-1  font-medium rounded bg-red-100 text-red-600">No
                                    static*</span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">IS Lien static*</td>
                            <td class="px-4 py-2"><span
                                    class="px-2 py-1  font-medium rounded bg-red-100 text-red-600">No
                                    static*</span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Sweep In static*</td>
                            <td class="px-4 py-2"><span
                                    class="px-2 py-1  font-medium rounded bg-red-100 text-red-600">No
                                    static*</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--MEMBER DETAILS-->
            <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class=" px-4 py-3  bg-secondary/5 rounded-10">
                    <h3 class="text-lg font-semibold text-black">CUSTOMER DETAILS</h3>
                </div>

                <!-- Body -->
                <div class="p-4 overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/3 uppercase">CUSTOMER Name</td>
                                <td class="px-4 py-2">
                                    {{ $fdAccount->member->member_no ??
                                    ($fdAccount->member_id ? str_pad($fdAccount->member_id, 6, '0', STR_PAD_LEFT) : '-')
                                    }}
                                    -
                                    {{ $fdAccount->member->member_info_first_name ?? '' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Mobile No</td>
                                <td class="px-4 py-2">{{ $fdAccount->member->member_info_mobile_no ?? '' }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Address</td>
                                <td class="px-4 py-2">{{ $fdAccount->member->address->member_address_line_1 ?? '' }}
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box shadow-md mt-5 rounded-lg dark:bg-bg3 overflow-hidden">
                <!-- Header -->
                <div class="border-b px-4 py-3 flex items-center gap-4 justify-between bg-secondary/5 rounded-10">
                    <h3 class="text-lg font-semibold uppercase text-black">ALLOCATED PASSBOOK</h3>
                    <a href="{{ route('passbook.create-passbook') }}"
                        class="btn-primary px-3 py-2 rounded-10 uppercase text-white">
                        <i class="las la-plus"></i>
                        passbook
                    </a>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr class="border-b bg-secondary/5">
                                    <th class="px-4 py-2 font-semibold uppercase">Passbook No</th>
                                    <th class="px-4 py-2 font-semibold uppercase">Issue Date</th>
                                    <th class="px-4 py-2 font-semibold uppercase">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 whitespace-nowrap">
                                @forelse($passbooks as $pass)
                                <tr class="border-b text-center">
                                    <td class="px-4 py-2">{{ $pass->passbook_no ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">
                                        {{ \Carbon\Carbon::parse($pass->issue_date)->format('d-m-Y') ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="w-full flex gap-3 justify-center">

                                            <!-- Edit -->
                                            <a href="{{ route('passbook.edit-passbook', $pass->id) }}"
                                                class="btn-primary  p-1">
                                                <i class="las la-edit "></i>
                                            </a>

                                            <!-- View -->
                                            <a href="{{ route('passbook.show', $pass->id) }}" class="btn-primary  p-1">
                                                <i class="las la-eye "></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="border-b">
                                    <td colspan="3" class="py-3 text-center text-gray-500">
                                        No FD passbooks found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <!--documents-->
            <div class="bg-white dark:bg-bg3 box shadow-md mt-5 rounded-10 overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold">DOCUMENTS</h3>
                    <a href="{{ route('fd.uploadDocuments', $fdAccount->id) }}"
                        class=" btn-primary rounded-full p-1  w-2"><i class="las la-upload"></i>
                    </a>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto">
                        @if ($documents->isEmpty())
                        <p class="capitalize text-gray-500">No documents found</p>
                        @else
                        <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                            <thead class="bg-gray-100  text-gray-700">
                                <tr class="border-b">
                                    <th class="px-4 py-2 font-semibold">Name</th>
                                    <th class="px-4 py-2 font-semibold">URL</th>
                                    <th class="px-4 py-2 font-semibold">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($documents as $doc)
                                <tr class="border-b text-center">
                                    <td class="px-4 py-2">{{ $doc->document_type }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank"
                                            class="text-primary underline">
                                            Show
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

            <!--COMMENTS-->
            <div class="bg-white box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold ">COMMENTS</h3>

                </div>

                <!-- Body -->
                <div class="p-4">

                    <div class="overflow-x-auto">

                        @if ($fdAccount->comments->count() == 0)
                        <p class="capitalize text-gray-500">No comments found</p>
                        @else
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b bg-secondary/5">
                                    <th class="px-4 py-2 text-center uppercase font-semibold">Comment</th>
                                    <th class="px-4 py-2 uppercase font-semibold">Commented By</th>
                                    <th class="px-4 py-2 uppercase font-semibold">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($fdAccount->comments as $comment)
                                <tr class="hover:bg-gray-50  border-b">
                                    <td class="px-4 text-center py-2">{{ $comment->comment }}</td>
                                    <td class="px-4 py-2 text-center">
                                        {{ $comment->commented_by ? \App\Models\User::find($comment->commented_by)->name
                                        : '-' }}
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        {{ \Carbon\Carbon::parse($comment->date)->format('d-m-Y ') ?? '' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                        <div class="overflow-x-auto text-center mt-5">
                            @if ($fdAccount->comments->count() > 0)
                            <a href="{{ route('fd.addComment', $fdAccount->id) }}"
                                class="btn-primary px-3 py-2 uppercase rounded-3xl text-white rounded-10">View All</a>
                            @endif
                            <a href="{{ route('fd.addComment', $fdAccount->id) }}"
                                class="btn-primary px-3 py-2 uppercase rounded-3xl text-white rounded-10">Add Comments</a>
                        </div>
                    </div>
                </div>

            </div>


            <!--Transactions Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold uppercase">Transactions Info</h3>
                </div>
                <!-- Body -->
                <div class="p-4">
                    <div class="overflow-x-auto text-center mt-5">
                        <div class="overflow-x-auto">
                            <table
                                class="w-full whitespace-nowrap  border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
                                <thead class="bg-gray-100 text-start text-gray-700">
                                    <tr class="border-b bg-secondary/5">
                                        <th class="px-4 py-2 text-start text-sm font-semibold">DATE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">TYPE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">PAYMENT MODE</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">AMOUNT</th>
                                        <th class="px-4 py-2 text-start text-sm font-semibold">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fdAccount->transactions->sortByDesc('id') as $tran)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">
                                            {{ \Carbon\Carbon::parse($tran->transaction_date)->format('d-m-y') }}
                                        </td>

                                        <td class="px-3 py-2">
                                            {{ $tran->transaction_type == 1 ? 'Credit' : 'Debit' }}
                                        </td>

                                        <td class="px-3 py-2">
                                            {{ $tran->mode ?? 'System' }}
                                        </td>

                                        <td class="px-3 py-2">
                                            {{ number_format($tran->amount, 2) }}
                                        </td>

                                        <td class="px-3 py-2">
                                            @php($status = $tran->final_status)

                                            @if ($status === 'approved')
                                            <span class="text-green-600 font-semibold">Approved</span>
                                            @elseif ($status === 'pending')
                                            <span class="text-yellow-600 font-semibold">Pending</span>
                                            @else
                                            <span class="text-red-600 font-semibold">Rejected</span>
                                            @endif
                                        </td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('fd-accounts.transactions', $fdAccount->id) }}"
                            class="btn-primary mt-3 py-2 text-sm uppercase rounded-10 inline-block">
                            View All
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Settings -->
        <div class=" w-full ">

            <!--settings-->
            <!--settings-->
            <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3">
                    <h3 class="text-lg border-b font-semibold text-black">SETTINGS</h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <!-- SMS Toggle -->
                            <tr>
                                <td class="font-semibold text-start align-middle px-4 py-3 w-1/3">SMS</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="smsToggle" class="sr-only slider-toggle"
                                            data-label-id="smsLabel">
                                        <div class="relative">
                                            <div
                                                class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                            </div>
                                            <div
                                                class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                            </div>
                                        </div>
                                        <!-- <span id="smsLabel" class="ml-4 text-sm font-medium text-black">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                            <!-- DEDUCT TDS Toggle -->
                            <tr>
                                <td class="font-semibold text-start align-middle px-4 py-3">DEDUCT TDS</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="tdsToggle" class="sr-only slider-toggle"
                                            data-label-id="tdsLabel">
                                        <div class="relative">
                                            <div
                                                class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                            </div>
                                            <div
                                                class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                            </div>
                                        </div>
                                        <!-- <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                            <!-- ACCOUNT ON HOLD Toggle -->
                            <tr>
                                <td class="font-semibold text-start align-middle px-4 py-3">ACCOUNT ON HOLD</td>
                                <td class="px-4 py-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="holdToggle" class="sr-only slider-toggle"
                                            data-label-id="holdLabel">
                                        <div class="relative">
                                            <div
                                                class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                                            </div>
                                            <div
                                                class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                            </div>
                                        </div>
                                        <!-- <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span> -->
                                    </label>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

            <!--AUTO RENEW SETTINGS-->
            <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl">
                <!-- Header -->
                <div class="border-b px-4 py-3 bg-secondary/5  rounded-10">
                    <h3 class="text-lg font-semibold text-black">AUTO RENEW SETTINGS</h3>
                </div>

                <!-- Body -->
                <div class="p-4">
                    <form id="autoRenewForm" class="space-y-6">

                        <!-- AUTO RENEW -->
                        <div class="flex flex-col md:flex-row md:items-center md:gap-6">
                            <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW</label>
                            <div class="flex gap-6 md:mt-0">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="autoRenew" value="true"
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span>Yes</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="autoRenew" value="false" checked
                                        class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                    <span>No</span>
                                </label>
                            </div>
                        </div>

                        <!-- AUTO RENEW INSTRUCTION -->
                        <div class="flex flex-col md:flex-row mt-5 md:items-center md:gap-6">
                            <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW INSTRUCTION</label>

                            <select id="renewInstruction"
                                class="w-full rounded-10 bg-secondary/5 py-3 shadow-sm focus:ring-primary focus:border-blue-500 text-sm p-2"
                                disabled>
                                <option value="">Select Instruction</option>
                                <option value="REINVEST_PRINCIPAL">REINVEST_PRINCIPAL</option>
                                <option value="REINVEST_PRINCIPAL_AND_INTEREST">REINVEST_PRINCIPAL_AND_INTEREST
                                </option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center mt-5">
                            <button type="submit" class="btn-primary px-4 py-2 rounded-10 text-sm">
                                UPDATE
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!---->
            <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
                <!--Old MIS No.-->
                <form action="" class="mt-3 p-3">
                    <label for="" class="block uppercase font-semibold">Old FD No.</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <input type="text" name="" id=""
                            class="block w-full bg-secondary/5 px-3 rounded-10 border py-2 dark:text-white"
                            placeholder="Enter Old FD Number">
                        <input type="button" value="update" class="block  btn-primary py-2 uppercase rounded-10 cursor-pointer">
                    </div>
                </form>

                <!--Branch-->
                <form action="{{ route('fd.updateBranch', $fdAccount->id) }}" method="POST" class="mt-2 px-3">
                    @csrf
                    @method('PUT')

                    <label for="branch_id" class="block font-semibold uppercase">Branch</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select name="branch_id" id="branch_id"
                            class="w-full rounded-10 border px-3 py-3 bg-secondary/5 dark:bg-bg3 dark:text-white">
                            <option value="">Select Branch</option>
                            @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ $fdAccount->branch_id == $branch->id ? 'selected' : ''
                                }}>
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="block rounded-10 uppercase btn-primary">Update</button>
                    </div>
                </form>

                <!--Advisor/ Staff-->
                <form action="" class="mt-3 px-3">
                    <label for="" class="block font-semibold uppercase">Advisor/ Staff</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                            <option>Select Advisor/ Staff</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block rounded-10 uppercase btn-primary cursor-pointer">

                    </div>
                </form>

                <div class=" px-6 flex py-4 flex-row items-start gap-6">
                    <p class="w-full text-lg font-semibold  uppercase">Current Chart</p>
                    <a href="#" class=" w-full uppercase">None </a>
                </div>

                <!--Commission Chart-->
                <form action="" class="mt-2 px-3 pb-4">
                    <label for="" class="block font-semibold uppercase">Commission Chart</label>
                    <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
                        <select class="w-full rounded-10 border  px-3 py-3  bg-secondary/5
       dark:bg-bg3 dark:text-white">
                            <option>Select Commission Chart</option>

                            <option>Option 2</option>
                        </select>

                        <input type="button" value="update" class="block rounded-10 uppercase btn-primary cursor-pointer">

                    </div>
                </form>
            </div>
            {{-- AUTO DEBIT SAVING ACCOUNT INFO --}}
            @if ($fdAccount->link_status == 1)
            <div class="box shadow-md dark:bg-bg3 mt-5 rounded-lg overflow-hidden">

                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('hidden')">
                    <h3 class="text-lg font-semibold uppercase">AUTO DEBIT SAVING ACCOUNT INFO</h3>
                </div>

                <!-- Body -->
                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase w-1/2 md:w-1/3">Account No.
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ optional($linkedSavingAcc)->account_no }}
                                </td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Scheme Name</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $fdAccount->fdscheme->scheme_name ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Available Balance</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $linkedSavingAcc ? $balances[$linkedSavingAcc->id] ?? 0 : 0 }}
                                </td>
                            </tr>

                            @if ($fdAccount->link_status !== 0)
                            <tr>
                                <td class="font-semibold px-4 py-2 uppercase">Un-link Saving Account
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    <a href="{{ route('fd-accounts.confirmUnlink', $fdAccount->id) }}"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                        UNLINK ACCOUNT
                                    </a>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            <!--Scheme Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('')">
                    <h3 class="text-lg font-semibold uppercase">Scheme Info</h3>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Scheme Name</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $fdAccount->fdscheme->scheme_name ?? 'NA' }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Scheme Code</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $fdAccount->fdscheme->scheme_code }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Minimum Locking Period</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $fdAccount->fdscheme->lock_in_period ?? 0 }}Months
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Interest Locking Period</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $fdAccount->fdscheme->interest_lock_in ?? 0 }} Months
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Bonus Rate</td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    {{ $fdAccount->fdscheme->bonus_rate ?? 0.0 }} %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Cancellation Charges</td>
                                <td class="px-4 py-2  text-right md:text-left">₹
                                    {{ $fdAccount->fdscheme->cancellation_charge ?? 0 }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Penal Charges (%)</td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    {{ $fdAccount->fdscheme->penal_charge ?? 0.0 }} %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Min. Amount</td>
                                <td class="px-4 py-2  text-right md:text-left">₹
                                    {{ $fdAccount->fdscheme->min_amount ?? 0 }}
                                </td>
                            </tr>

                        </tbody>
                    </table>


                    <!-- Table Wrapper  -->
                    <div class="overflow-x-auto mt-5  bg-white dark:bg-bg3">
                        <table class="min-w-full text-sm ">
                            <thead class="bg-secondary/5">
                                <tr>
                                    <th colspan="4"
                                        class="px-4 py-3 text-center text-lg dark:text-gray-50   font-semibold text-gray-800 border-b">
                                        INTEREST CHART INFO
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">
                                        DAYS</th>
                                    <th rowspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">
                                        INTEREST RATE (%) (ANNUAL)
                                    </th>
                                    <th rowspan="2" class="px-4 py-2 text-center font-semibold text-gray-700 border-b">
                                        SRCTZN INTEREST RATE (%)
                                    </th>
                                </tr>
                                <tr>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-700 border-b">FROM</th>
                                    <th class="px-4 py-2 text-center font-semibold text-gray-700 border-b">TO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fdSlabs as $slab)
                                <tr class="text-center border-b">
                                    <td class="px-3 py-2">{{ $slab->day_from }}</td>
                                    <td class="px-3 py-2">{{ $slab->day_to }}</td>
                                    <td class="px-3 py-2">{{ $slab->interest_rate }} %</td>
                                    <td class="px-3 py-2">{{ $slab->sr_citizen_rate }} %</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <!--FD  Maturity Info-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('')">
                    <h3 class="text-lg font-semibold uppercase">FD Maturity Info</h3>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Maturity Date</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ \Carbon\Carbon::parse($fdAccount->maturity_date)->format('d-m-Y') }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $fdAccount->fd_amount }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Total Interest (B)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $totalInterest }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Total TDS Deducted (C)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $tds }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Bonus Amount (D)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $bonus }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + B + D)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $maturityAmount }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Net Maturity Amount (A + B + D - C)</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $netMaturityAmount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!--FD Info-->

            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('')">
                    <h3 class="text-lg font-semibold uppercase">FD Info</h3>

                </div>

                <!-- Body -->

                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Interest Credited</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    @if ($fdAccount->interest_credited < 0) ({{ number_format(abs($fdAccount->
                                        interest_credited), 2) }})
                                        @else
                                        ₹{{ number_format($fdAccount->interest_credited, 2) }}
                                        @endif
                                        </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Interest Released</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    @if ($fdAccount->interest_released < 0) ({{ number_format(abs($fdAccount->
                                        interest_released), 2) }})
                                        @else
                                        ₹{{ number_format($fdAccount->interest_released, 2) }}
                                        @endif
                                        </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">TDS Deducted</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    @if ($fdAccount->tds_deducted < 0) ({{ number_format(abs($fdAccount->tds_deducted),
                                        2) }})
                                        @else
                                        ₹{{ number_format($fdAccount->tds_deducted, 2) }}
                                        @endif
                                        </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <!-- FD Nominee Info -->
            @if($fdAccount->nominee->isNotEmpty())

            <div class="box shadow-md dark:bg-bg3 mt-5 rounded-lg overflow-hidden">

                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3">
                    <h3 class="text-lg font-semibold uppercase">Nominee Information</h3>
                </div>

                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse shadow-md bg-white dark:bg-bg3">
                        <thead>
                            <tr class="bg-secondary/5 border-b ">
                                <th class="px-4 py-2 text-left">Name</th>
                                <th class="px-4 py-2 text-left">Relation</th>
                                <th class="px-4 py-2 text-left">Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fdAccount->nominee as $nom)
                            <tr class="border-b">
                                <td class="px-4 py-2 text-center">{{ $nom->nominee_name ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">{{ $nom->nominee_relation ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">{{ $nom->nominee_address ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            @endif

            <!--FD  Branch Info-->

            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
                    onclick="this.nextElementSibling.classList.toggle('')">
                    <h3 class="text-lg font-semibold uppercase">FD Branch Info</h3>

                </div>

                <!-- Body -->

                <div class="overflow-x-auto mt-5">
                    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Branch</td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->branch->branch_name }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Joint Account</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    @if (!empty($fdAccount->account_type))
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">Yes</span>
                                    @else
                                    <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">No</span>
                                    @endif
                                </td>
                            </tr>
                            {{-- <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Joint Account Member Name
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">{{ $fdAccount->savingAccount->branch_name
                                    }}
                            </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>



            </div>

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const interestButton = document.getElementById('interestButton');
            const interestMenu = document.getElementById('interestMenu');
            const interestArrow = document.getElementById('interestArrow');

            // Toggle menu on button click
            interestButton.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent click from closing immediately

                interestMenu.classList.toggle('hidden');
                interestArrow.classList.toggle('rotate-180');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!interestMenu.classList.contains('hidden')) {
                    interestMenu.classList.add('hidden');
                    interestArrow.classList.remove('rotate-180');
                }
            });
        });
    </script>
    <script>
        // Label update on toggle
        document.querySelectorAll('.slider-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const label = document.getElementById(this.dataset.labelId);
                label.textContent = this.checked ? 'ON' : 'OFF';
            });

            // Initialize label on page load
            toggle.dispatchEvent(new Event('change'));
        });
    </script>

    @endsection