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
            <h3 class=" flex text-xl block  uppercase font-semibold">RD/ DD/ LOAN EMI - PAYMENT COLLECTION
            </h3>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class="mb-5 flex justify-end gap-2 flex-col md:flex-row lg:flex-row">
                <a href="{{ route('payments.collect.print') }}" target="_blank"
                    class="btn-primary rounded-10 px-1 py-2 uppercase">
                    <i class="las la-print"></i>
                    print
                </a>
                <a href="{{ route('payments.collect.csv') }}" class="btn-error rounded-10 px-1 py-2 uppercase">
                    <i class="las la-download"></i>
                    download csv
                </a>
                <a href="{{ route('payments.collect.dat') }}" class="btn-error rounded-10 px-1 py-2 uppercase">
                    <i class="las la-download"></i>
                    download machine dat
                </a>
            </div>

            @php
                function detectLoanType($loanId)
                {
                    $map = [
                        'gold_loan_emi_status' => 'Gold Loan',
                        'mortgage_loan_emi_status' => 'Mortgage Loan',
                        'loan_against_emi_status' => 'Loan Against Deposit',
                        'daily_weekly_loan_emi_status' => 'Daily/Weekly Loan',
                        'cc_od_loan_emi_status' => 'CC/OD Loan',
                        'personal_loan_emi_status' => 'Personal Loan',
                        'vehical_loan_emi_status' => 'Vehicle Loan',
                        'business_loan_emi_status' => 'Business Loan',
                    ];

                    foreach ($map as $table => $label) {
                        if (DB::table($table)->where('loan_id', $loanId)->exists()) {
                            return $label;
                        }
                    }
                    return '-';
                }
            @endphp

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
                                    GROUP
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    ADV/ STAFF
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    CUSTOMER
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    A/C NO.
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    WEIGHTAGE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    INST. DUE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    INST. OVERDUE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    DUE DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    DUE DAYS
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    SAVING BAL.
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    AMT. TO COLLECT
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
                        @foreach ($applications as $app)
                            <tr id="row-{{ $app->loan_id }}-{{ $app->emi_no }}" class="border-b dark:border-bg3">
                                {{-- Branch Name --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        {{ $app->branch_name ?? '-' }}
                                    </div>
                                </td>

                                {{-- Branch Code --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 capitalize">
                                        -
                                    </div>
                                </td>

                                {{-- Member Full Name --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1 uppercase">
                                        -
                                    </div>
                                </td>

                                {{-- Member No & Name --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ url('members/member/' . $app->member_id ?? '') }}"
                                            class="text-green-600 hover:underline">
                                            {{ $app->member_no ?? '-' }} -
                                            {{ $app->member_info_first_name ?? '-' }}
                                        </a>
                                    </div>
                                </td>

                                {{-- Loan Type --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ $app->loan_type }} </td>

                                {{-- Application Number --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    @php
                                        $route = '';
                                        if ($app->loan_type === 'Gold Loan') {
                                            $route = route('gold-loan.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Mortgage Loan') {
                                            $route = route('mortgage.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Personal Loan') {
                                            $route = route('personal.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Loan Against Deposit') {
                                            $route = route('loanagainst.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Daily/Weekly Loan') {
                                            $route = route('daily_weekly.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'CC/OD Loan') {
                                            $route = route('cc_od.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Vehicle Loan') {
                                            $route = route('vehical.account.show', $app->loan_id);
                                        } elseif ($app->loan_type === 'Business Loan') {
                                            $route = route('bussiness.account.show', $app->loan_id);
                                        }
                                    @endphp
                                    <a href="{{ $route }}" class="text-primary">
                                        {{ $app->loan_id ?? '-' }}
                                    </a>
                                </td>

                                {{-- EMI --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ $app->weightage ?? 1 }}
                                </td>

                                {{-- Pending EMI --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ $app->inst_due ?? 0 }}
                                </td>

                                {{-- Total Paid EMI --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ $app->inst_overdue ?? 0 }}
                                </td>

                                {{-- Loan Date --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ $app->due_date ? date('d-m-Y', strtotime($app->due_date)) : '-' }} </td>

                                {{-- Days --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    @if ($app->due_date)
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($app->due_date)->startOfDay();
                                            $today = \Carbon\Carbon::now()->startOfDay();
                                            $days = (int) $today->diffInDays($dueDate, false);
                                        @endphp

                                        @if ($days > 0)
                                            <span class="text-red-600 font-semibold">{{ $days }} Days</span>
                                        @elseif($days < 0)
                                            <span class="text-blue-600">{{ abs($days) }} Days Left</span>
                                        @else
                                            <span class="text-green-600">Today</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Advisor --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    -
                                </td>

                                {{-- Loan Amount --}}
                                <td class="text-start !py-5 px-6 min-w-[100px]">
                                    {{ number_format($app->remaining_amount ?? 0, 2) }}
                                </td>

                                {{-- Options --}}
                                <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                    <div class="flex justify-center">
                                        <div class="relative">
                                            <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li>
                                                    @php
                                                        $collectRoute = '';

                                                        if ($app->loan_type === 'Gold Loan') {
                                                            $collectRoute = route(
                                                                'gold-loan.account.pay-emi',
                                                                $app->loan_id,
                                                            );
                                                        } elseif ($app->loan_type === 'Mortgage Loan') {
                                                            $collectRoute = route(
                                                                'mortgage.account.pay-emi',
                                                                $app->loan_id,
                                                            );
                                                        } elseif ($app->loan_type === 'Personal Loan') {
                                                            $collectRoute = route(
                                                                'personal.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        } elseif ($app->loan_type === 'Loan Against Deposit') {
                                                            $collectRoute = route(
                                                                'loanagainst.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        } elseif ($app->loan_type === 'Daily/Weekly Loan') {
                                                            $collectRoute = route(
                                                                'daily_weekly.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        } elseif ($app->loan_type === 'CC/OD Loan') {
                                                            $collectRoute = route(
                                                                'cc_od.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        } elseif ($app->loan_type === 'Vehicle Loan') {
                                                            $collectRoute = route(
                                                                'vehical.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        } elseif ($app->loan_type === 'Business Loan') {
                                                            $collectRoute = route(
                                                                'bussiness.account.pay-emi',
                                                                $app->loan_id,
                                                            ); // OPTIONAL
                                                        }
                                                    @endphp
                                                    <a href="{{ $collectRoute }}" class="single-option">COLLECT</a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('loan.generate.collection.link', [$app->loan_type, $app->loan_id]) }}"
                                                        class="single-option">
                                                        GENERATE COLLECTION LINK
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="{{ route('payments-to-collect.comments', [$app->loan_type, $app->loan_id]) }}"
                                                        class="single-option">
                                                        COMMENTS
                                                    </a>
                                                </li>
                                                @if (($app->status ?? '') == 'PAID')
                                                    <li>
                                                        <button class="single-option"
                                                            onclick="markDone('{{ $app->loan_type }}','{{ $app->loan_id }}','{{ $app->emi_no }}','{{ $app->remaining_amount }}', this)">
                                                            MARK DONE
                                                        </button>
                                                    </li>
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        <x-pagination :paginator="$applications" />
                    </div>
                </table>

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
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <tbody class="divide-y divide-gray-200">

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Member No :</td>
                                        <td colspan="3" class="py-2 underline">
                                            <a href="#" class="text-primary">
                                                <span id="modalMember"></span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Account Type :</td>
                                        <td class="py-2 pr-4">
                                            <span id="modalLoanType"></span>
                                        </td>

                                        <td class="font-semibold uppercase py-2 pr-4">Account No :</td>
                                        <td class="py-2 underline">
                                            <a href="#" class="text-primary">
                                                <span id="modalLoanId"></span>
                                            </a>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Inst Due :</td>
                                        <td class="py-2 pr-4">
                                            <span id="modalInstDue"></span>
                                        </td>

                                        <td class="font-semibold uppercase py-2 pr-4">Due Date :</td>
                                        <td class="py-2">
                                            <span id="modalDueDate"></span>
                                        </td>
                                    </tr>

                                    <tr class="border-b">
                                        <td class="font-semibold uppercase py-2 pr-4">Saving Bal :</td>
                                        <td class="py-2 pr-4">-</td>

                                        <td class="font-semibold uppercase py-2 pr-4">Amt to Collect :</td>
                                        <td class="py-2">
                                            <span id="modalAmount"></span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        {{-- 
                        <!-- Last credit table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">

                                <thead>
                                    <tr>
                                        <th colspan="5"
                                            class="bg-gray-50 py-2 text-center text-lg font-semibold uppercase">
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

                                    @if (!empty($app->last_transaction))
                                        <tr>
                                            <td>{{ $app->last_transaction->id ?? '-' }}</td>

                                            <td>
                                                {{ $app->last_transaction->transaction_date
                                                    ? date('d-m-Y', strtotime($app->last_transaction->transaction_date))
                                                    : '-' }}
                                            </td>

                                            <td>{{ $app->last_transaction->fee_mode ?? '-' }}</td>

                                            <td>
                                                {{ number_format($app->last_transaction->amount_collected ?? 0, 2) }}
                                            </td>

                                            <td>
                                                {{ strtoupper($app->last_transaction->status ?? '-') }}
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500">
                                                No Transaction History Found
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div> --}}

                        <hr />

                        <!-- Comment Form -->
                        <form method="POST" action="{{ route('loan.save.comment') }}" class="space-y-4 mt-4">
                            @csrf
                            <div class="mt-6">
                                <div class="text-center uppercase font-semibold mb-3">
                                    Comment History
                                </div>

                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="bg-gray-50 border-b">
                                            <td class="py-2 px-3 uppercase font-semibold">Comment</td>
                                            <td class="py-2 px-3 uppercase font-semibold">Comment By</td>
                                            <td class="py-2 px-3 uppercase font-semibold">Date</td>
                                        </tr>
                                    </thead>

                                    <tbody id="commentHistory">
                                        <tr>
                                            <td colspan="3" class="text-center">No Comments</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <input type="hidden" name="loan_id" id="modalLoanIdInput">
                            <input type="hidden" name="loan_type" id="modalLoanTypeInput"> <label
                                class="text-lg uppercase font-medium">Add New Comment <span
                                    class="text-red-500">*</span></label>

                            <textarea name="comment"
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

    </div>
    <script>
        function openLoanModal(memberNo, memberName, loanType, loanId, instDue, dueDate, amount) {

            document.getElementById('loanModal').classList.remove('hidden');

            document.getElementById('modalMember').innerHTML = memberNo + " - " + memberName;
            document.getElementById('modalLoanType').innerHTML = loanType;
            document.getElementById('modalLoanId').innerHTML = loanId;
            document.getElementById('modalInstDue').innerHTML = instDue;
            document.getElementById('modalDueDate').innerHTML = dueDate;
            document.getElementById('modalAmount').innerHTML = amount;

            document.getElementById('modalLoanIdInput').value = loanId;
            document.getElementById('modalLoanTypeInput').value = loanType;

            fetch('/loan/comments/' + loanType + '/' + loanId)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    if (data.length === 0) {
                        html = '<tr><td colspan="3" class="text-center">No Comments</td></tr>';
                    } else {

                        data.forEach(c => {

                            html += `
                    <tr>
                        <td class="py-2 px-3">${c.comment}</td>
                        <td class="py-2 px-3">${c.comment_by ?? '-'}</td>
                        <td class="py-2 px-3">${new Date(c.created_at).toLocaleString()}</td>
                    </tr>
                    `;

                        });

                    }

                    document.getElementById('commentHistory').innerHTML = html;

                });
        }
    </script>
    <script>
        function markDone(type, loan_id, emi_no, amount, btn) {

            if (!confirm("Mark this EMI as done?")) return;

            fetch(`/loan/mark-done/${type}/${loan_id}/${emi_no}/${amount}`)
                .then(res => res.text())
                .then(data => {

                    let row = document.getElementById(`row-${loan_id}-${emi_no}`);

                    if (row) {
                        row.style.transition = "0.4s";
                        row.style.opacity = "0";

                        setTimeout(() => {
                            row.remove();
                        }, 400);
                    }

                })
                .catch(err => {
                    alert("Something went wrong");
                    console.log(err);
                });

        }
    </script>
@endsection
