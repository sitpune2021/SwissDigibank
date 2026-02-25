@extends('layout.main')
@section('content')
    @php
        $setting = $goldLoan->scheme->gold_loan_setting ?? '';
        switch ($setting) {
            case 'reducing_emi':
                $settingLabel = 'Reducing Emi';
                break;
            case 'flat_advanced_interest':
                $settingLabel = 'Flat Advanced Interest';
                break;
            case 'flat_emi':
                $settingLabel = 'Flat Emi';
                break;
            case 'no_emi':
                $settingLabel = 'No Emi';
                break;
            default:
                $settingLabel = '';
        }
    @endphp
    <style>
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


        @media (prefers-color-scheme: dark) {
            .custom-thead {
                background-color: #14532d;
                color: #d1fae5;
            }
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
    </style>

    @if (session('success'))
        {{-- //alert msg --}}
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
    @endif

    <div class="main-inner">
        @if ($hasPendingApproval)
            <div style="background:#f39c12; padding:20px; color:white; margin-bottom:20px; border-radius:5px;">
                <h4 style="margin:0;">ALERT PENDING TRANSACTION!</h4>
                <p style="margin:5px 0;">
                    Some transactions are pending for approval. To approve
                    <a href="{{ route('pending-transaction.index') }}"
                        style="background:#2980b9; color:white; padding:6px 12px; text-decoration:none; border-radius:4px;">
                        CLICK HERE
                    </a>
                </p>
            </div>
        @endif
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-lg uppercase font-semibold">Gold Loan - {{ $goldLoan->id }} </h1>
                <!-- <p class="text-gray-500">
                                                                    <a href="#" class="text-gray-500 text-sm">Gold Loans </a> >
                                                                    <a href="#" class="text-gray-500 text-sm">00460</a>
                                                                </p> -->
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('gold-loan.account.transaction', $goldLoan->id) }}"
                class="btn-secondary uppercase px-2 py-2 rounded-10 text-sm ">
                View Transaction
            </a>
            @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi')
                <a href="{{ route('gold-loan.account.pay-emi', $goldLoan->id) }}"
                    class="btn-primary uppercase px-2 py-2 rounded-10 text-sm">
                    {{ $payButtonText }}
                </a>

                @if (in_array(strtolower($goldLoan->scheme->gold_loan_setting), ['flat_emi', 'reducing_emi']))
                    <a href="" class="btn-primary uppercase px-2 py-2 rounded-10 text-sm">
                        RE-SCHEDULE EMIs
                    </a>
                @endif

                <a href="{{ route('gold-loan.account.fourcloser', $goldLoan->id) }}"
                    class="btn-error uppercase px-2 py-2 rounded-10 text-sm">
                    Fore CloseLoan
                </a>
                <input type="hidden" name="confirm" value="1">
                <button type="button" onclick="confirmRemove({{ $goldLoan->id }})"
                    class="btn-error uppercase px-2 py-2 rounded-10 text-sm">
                    Remove Account
                </button>
                <div class="relative inline-block text-left">
                    <!-- Button -->
                    <button type="button"
                        class="btn-secondary uppercase px-2 py-2 rounded-10 flex items-center gap-2 text-sm"
                        onclick="toggleDropdown('debitCharges')">
                        Debit Other Charges
                        <i class="las la-angle-down text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="debitCharges"
                        class="hidden absolute right-0 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div class="py-1">
                            <a href="{{ route('gold-loan.debitChargesList.form', $goldLoan->id) }}"
                                class="flex items-center uppercase gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Other Charges List
                            </a>
                            <a href="{{ route('gold-loan.debitOtherCharges.form', $goldLoan->id) }}"
                                class="flex items-center uppercase gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Debit Other Charges
                            </a>
                            <a href="{{ route('gold-loan.clear-due.form', $goldLoan->id) }}"
                                class="flex items-center uppercase gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Clear Dues
                            </a>
                        </div>
                    </div>
                </div>
                @if (strtolower($goldLoan->scheme->gold_loan_setting) == 'flat_advanced_interest')
                    <a href="{{ route('gold-loan.account.extension', $goldLoan->id) }}"
                        class="btn-error uppercase px-2 py-2 rounded-10 text-sm">
                        LOAN EXTENSION
                    </a>
                @endif
            @endif

            @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi')
                <a href="" class="btn-primary  uppercase px-2 py-2 rounded-10 text-sm">
                    Re-Update Emi Chart
                </a>
            @endif

            {{-- @if (in_array(strtolower($goldLoan->scheme->gold_loan_setting), ['flat_emi', 'reducing_emi']))
                <a href="" class="btn-primary uppercase px-2 py-2 rounded-10 text-sm">
                    RE-SCHEDULE EMIs
                </a>
            @endif --}}

            @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'flat_advanced_interest' &&
                    strtolower($goldLoan->scheme->gold_loan_setting) != 'reducing_emi')
                <a href="{{ $payRoute }}" class="btn-primary uppercase px-2 py-2 rounded-10 text-sm">
                    {{ $payButtonText }}
                </a>
            @endif


            <a href="{{ route('gold-loan.account.linksaving', $goldLoan->id) }}"
                class="btn-primary uppercase px-2 py-2 rounded-10 text-sm ">
                link saving account(Auto Debit)
            </a>

            <form id="remove-account-form-{{ $goldLoan->id }}" action="{{ route('goldloan.remove', $goldLoan->id) }}"
                method="POST" class="inline">
                @csrf
                {{-- Optional: add a hidden input to indicate reason or confirm flag --}}
                {{-- <input type="hidden" name="confirm" value="1">
                <button type="button" onclick="confirmRemove({{ $goldLoan->id }})"
                    class="btn-error uppercase px-2 py-2 rounded-10 text-sm">
                    Remove Account
                </button> --}}
            </form>

            <div class="relative inline-block text-left">
                <!-- Button -->
                <button type="button" class="btn-secondary  text-sm px-2 py-2 rounded-10 flex items-center gap-2"
                    onclick="toggleDropdown('printDropdown')">
                    <i class="las la-print text-sm"></i>
                    PRINT DOCUMENTS
                    <i class="las la-angle-down text-xs"></i>
                </button>

                <!-- Dropdown Menu -->
                <div id="printDropdown"
                    class="hidden absolute right-0 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                    <div class="py-1">
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i>Repayment Schedule
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Loan Status
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Closing Request letter
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i>Renewal Letter
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Notice For Guarantor
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i>Notice for OVERDUE </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Facility recall notice
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Transaction Dispute
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Reminder notice for ac holder
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> Reminder notice for ac Guarantor
                        </a>

                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> section 101 final notice ac holder
                        </a>

                        <a href="#"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 uppercase">
                            <i class="las la-print text-secondary"></i> section 101 final notice ac Guarantor
                        </a>
                    </div>
                </div>

            </div>

            <a href="{{ route('gold-loan.account.audit-trail') }}"
                class="btn-primary text-sm uppercase  px-2 py-2 rounded-10 ">
                Show audit trail
            </a>

        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">

                    <table class="min-w-full text-sm text-left border-collapse">
                        <tbody class="divide-y divide-gray-200">
                            <tr class="border-b">
                                <td class="font-semibold px-4 uppercase py-2 w-1/3">Status</td>
                                <td class="px-4 py-2">
                                    <a href="" class="text-primary  capitalize hover:underline">
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                            ACTIVE
                                        </span>
                                        (static)
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase  px-4 py-2">
                                    ACTIVE
                                    CUSTOMER</td>
                                <td class="px-4 py-2 capitalize  text-primary">{{ $goldLoan->member->member_no ?? '' }}
                                    {{ $goldLoan->member->member_info_first_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 uppercase py-2">Customer Contact No</td>
                                <td class="px-4 py-2 capitalize text-primary">
                                    {{ $goldLoan->member->member_info_mobile_no ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold px-4 uppercase py-2">Guarantor 1 Customer</td>
                                <td class="px-4 py-2">{{ $goldLoan->coApplicant1->member_no ?? '' }} -
                                    {{ $goldLoan->coApplicant1->member_info_first_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Account No.</td>
                                <td class="px-4 py-2">{{ str_pad($goldLoan->id ?? 0, 6, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Application No.</td>
                                <td class="px-4 py-2 text-primary">{{ $goldLoan->id ?? 'N/A' }}</td>
                            </tr>
                            @php
                                use Carbon\Carbon;

                                $applicationDate = Carbon::parse($goldLoan->application_date);
                                $firstEmiDate = $applicationDate->copy()->addMonth(); // next month same date

                                switch (strtolower($goldLoan->tenure_type)) {
                                    case 'days':
                                        $lastEmiDate = $firstEmiDate->copy()->addDays($goldLoan->tenure_value - 1);
                                        break;

                                    case 'weeks':
                                        $lastEmiDate = $firstEmiDate->copy()->addWeeks($goldLoan->tenure_value - 1);
                                        break;

                                    case 'months':
                                    default:
                                        $lastEmiDate = $firstEmiDate
                                            ->copy()
                                            ->addMonthsNoOverflow($goldLoan->tenure_value - 1);
                                        break;
                                }

                            @endphp
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Open Date</td>
                                <td class="px-4 py-2">{{ $applicationDate->format('d-m-Y') ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">First EMI Date</td>
                                <td class="px-4 py-2">{{ $firstEmiDate->format('d-m-Y') ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Last EMI Date</td>
                                <td class="px-4 py-2">{{ $lastEmiDate->format('d-m-Y') ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Scheme</td>
                                <td class="px-4 py-2">{{ $goldLoan->scheme->scheme_name ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2"> Loan Amount</td>
                                <td class="px-4 py-2">₹ {{ $goldLoan->loan_amount ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Total Deposit</td>
                                <td class="px-4 py-2">₹ {{ number_format($totalDeposit, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2">Current Debt</td>
                                <td class="px-4 py-2">₹ {{ number_format($currentDebt, 2) }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2"> Close Date</td>
                                <td class="px-4 py-2">{{ $closeDate ?? '---' }}</td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-semibold uppercase px-4 py-2"> Interest Rate</td>
                                <td class="px-4 py-2">{{ $goldLoan->scheme->annual_interest_rate ?? '0' }} %</td>
                            </tr>
                            <tr class="">
                                <td class="font-semibold uppercase px-4 py-2"> Annualized Percentage Rate (APR)</td>
                                <td class="px-4 py-2"> %</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <!--APPOINTMENT DETAILS-->
                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">

                    <div
                        class="border-b flex items-center bg-secondary/5 text-black justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">APPOINTMENT DETAILS</h3>
                        <div class=" flex gap-3">
                            <a href="javascript:void(0)" onclick="openModal()"
                                class="p-2 uppercase text-sm rounded-10 btn-primary">
                                <i class="las la-upload"></i>New Appointment

                            </a>
                        </div>
                    </div>
                </div>

                <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
                    <div
                        class="border-b flex items-center bg-secondary/5 text-black justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">ALLOCATED PASSBOOK
                        </h3>
                        <div class=" flex gap-3">
                            <a href="" class="p-2 rounded-10 text-sm uppercase btn-primary">
                                <i class="las la-upload"></i>Passbook
                            </a>
                        </div>
                    </div>
                </div>

                <!--documents-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            Documents
                        </h3>
                        <div class="">
                            <a href="#" class="btn-primary p-1 pointer">
                                <i class="las la-upload y"></i>
                            </a>

                            <button type="button" class="p-1 rounded transition"
                                onclick="toggleSection(this, 'Documents')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4" id="Documents">
                        <div class="overflow-x-auto">
                            <p class="capitalize">No documents found</p>
                        </div>
                    </div>
                </div>

                <!--COMMENTS-->
                {{-- <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <!-- Header -->
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  capitalize">
                            COMMENTS
                        </h3>
                        <div class="">

                            <button type="button" class="p-1 rounded transition"
                                onclick="toggleSection(this, 'Comment')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4" id="Comment">
                        <p class="capitalize">No Comment Found</p>
                        <div class="overflow-x-auto mt-5 flex flex-col items-center ">
                            <button class="btn-primary uppercase ">Add Comment</button>
                        </div>
                    </div>
                </div> --}}
                <!-- COMMENTS -->
                <div x-data="{ open: true }" class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                    <!-- Header -->
                    <div class="border-b flex items-center justify-between px-4 py-3 
                bg-secondary/5 rounded-10 text-lg cursor-pointer"
                        @click="open = !open">

                        <h3 class="text-lg font-semibold text-black uppercase">
                            COMMENTS
                        </h3>

                        <i :class="open ? 'las la-minus' : 'las la-plus'" class="text-xl"></i>
                    </div>

                    <!-- Body -->
                    <div x-show="open" x-transition class="p-4 bg-white dark:bg-bg3">

                        @if ($comments->isEmpty())
                            <p class="mb-4 text-sm text-gray-700 dark:text-gray-300">
                                No Comment Found
                            </p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse text-start mt-5 text-lg">
                                    <thead>
                                        <tr class="bg-secondary/5 text-black">
                                            <th class="px-4 py-2 font-semibold text-start">DATE</th>
                                            <th class="px-4 py-2 font-semibold text-start">COMMENT BY</th>
                                            <th class="px-4 py-2 font-semibold text-start">COMMENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comments as $comment)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="px-4 py-2 text-start">
                                                    {{ \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') }}
                                                </td>
                                                <td class="px-4 py-2 text-start">
                                                    {{ $comment->commented_by ?? '-' }}
                                                </td>
                                                <td class="px-4 py-2 text-start">
                                                    {{ $comment->comment }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <!-- Buttons -->
                        <div class="w-full flex items-center justify-center gap-4 mt-4">

                            <!-- Add Comment -->
                            <a href="{{ route('goldloan.addComment', $goldLoan->id) }}"
                                class="btn-primary rounded-10 py-2">
                                ADD COMMENT
                            </a>

                            <!-- View All -->
                            @if ($comments->isNotEmpty())
                                <a class="btn-primary rounded-10 py-2"
                                    href="{{ route('goldloan.addComment', $goldLoan->id) }}">
                                    VIEW ALL
                                </a>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-x-auto  ">
                <div class="flex flex-row gap-4 dark:bg-bg3      rounded-10">
                    <div class="w-full box dark:bg-bg3 p-2 rounded-10 shadow-md border border-gray-200">
                        <div
                            class="flex justify-center gap-2  border-gray-200 px-4 py-3 bg-gray-50 rounded-t-2xl border-b">

                            <h3 class="font-semibold  text-center sm:text-lg">
                                {{-- Rupee Symbol --}} &#x20B9; BALANCE REPORT
                            </h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <tbody>
                                    <tr class="border-b">
                                        <td class="whitespace-nowrap font-semibold text-md px-4 py-2">C. DEBT</td>
                                        <td class="px-4 py-2 ">
                                            <span class="">{{ number_format($currentDebt, 2) }}</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="whitespace-nowrap font-semibold text-md px-4 py-2">T. DEPOSIT</td>
                                        <td class="px-4 py-2 ">
                                            <span class="">{{ number_format($totalDeposit, 2) }}</span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="whitespace-nowrap font-semibold text-md px-4 py-2">T. DUE</td>
                                        <td class="px-4 py-2 ">
                                            <span class="font-semibold text-red-600">
                                                ₹ {{ number_format($tDueAmount, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td
                                            class="whitespace-nowrap text-md font-semibold px-4 py-2 flex items-start gap-2 ">
                                            OC DUE

                                        </td>
                                        <td class="px-4 py-2  font-semibold text-red-800">
                                            <span class="">0.00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="whitespace-nowrap font-semibold text-md px-4 py-2">DUE DAYS</td>
                                        <td class="px-4 py-2">
                                            <span class="">0</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <!--SMS SETTINGS-->
                <div class="box dark:bg-bg3 mt-3 border-gray-200 shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">SETTINGS</h3>
                    </div>
                    <div class="p-4 overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-200">

                                <!-- SMS Toggle -->
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">SMS</td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="smsToggle" class="sr-only slider-toggle">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                    </td>
                                </tr>

                                {{-- SMS REMINDER --}}
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">SMS REMINDER </td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="smsToggle" class="sr-only slider-toggle">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                                {{-- ON HOLD --}}
                                <tr>
                                    <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">ON HOLD</td>
                                    <td class="px-4 py-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" id="smsToggle" class="sr-only slider-toggle">
                                            <div class="relative">
                                                <div
                                                    class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                                                </div>
                                                <div
                                                    class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="bg-white dark:bg-bg3 shadow-md mt-4 p-2 rounded-xl border border-gray-200">
                    <div class="px-4 py-3">
                        <h3 class="text-lg border-b font-semibold text-black">PENALTY SETTING</h3>
                    </div>
                    <!--Old MIS No.-->
                    <form action="" class=" p-3 border-b ">

                        <label for="" class="block mb-2 font-semibold">Penalty Charges </label>
                        <div class="col-sm-7">
                            <div class="flex items-center gap-2">

                                <!-- Left Select -->
                                <select name="bonus_rate_type" id="bonus-rate-type round-10"
                                    class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-2 md:py-3">
                                    <option value="percentage">%</option>
                                    <option value="fixed">FIXED</option>
                                </select>

                                <!-- Main Input -->
                                <input type="number" id="bonus-rate" name="bonus_rate_value"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter Penalty Value ">

                                <button type="submit" class="block btn-primary uppercase rounded-10">Update</button>
                            </div>

                        </div>
                    </form>

                    <!--Branch-->
                    <form action="" method="" class="mt-2 px-3">
                        <label for="branch" class="block mb-2 font-semibold">Overdue Interest (%) </label>
                        <div class="col-sm-7">
                            <div class="flex items-center mb-4 gap-2">

                                <!-- Left Select -->
                                <select name="bonus_rate_type" id="bonus-rate-type round-10"
                                    class="w-24 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-2 md:py-3">
                                    <option value="percentage"> TYPE_2</option>
                                    <option value="fixed">TYPE_1</option>
                                </select>

                                <!-- Main Input -->
                                <input type="number" id="bonus-rate" name="bonus_rate_value"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="0.0">

                                <button type="submit" class="block btn-primary uppercase rounded-10">Update</button>
                            </div>

                        </div>
                    </form>

                </div>


                <div class="box shadow-md dark:bg-bg3 mt-5 rounded-lg overflow-hidden">
                    <div class="p-4" id="SecurityDeposits">
                        <div class="overflow-x-auto text-center">
                            <div class="w-full overflow-x-auto">
                                <table class="min-w-full border-collapse whitespace-nowrap text-sm text-center">
                                    <thead class="bg-gray-100">
                                        <tr class="bg-secondary/5">
                                            <th class="px-4 py-2"></th>
                                            <th class="px-4 py-2">NET P.</th>
                                            <th class="px-4 py-2">EMI P.</th>
                                            <th class="px-4 py-2">EMI INT.</th>
                                            <th class="px-4 py-2">EMI CHRGS.</th>
                                            <th class="px-4 py-2">OVERDUE INT.</th>
                                            <th class="px-4 py-2">OTHER CHRGS.</th>
                                            <th class="px-4 py-2">ADV. AMOUNT</th>
                                            <th class="px-4 py-2">DISCOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-primary border-b">
                                            <th class="px-4 py-2 text-left">PAID</th>
                                            <td class="px-4 py-2">{{ $paidSummary['net_p'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['emi_p'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['emi_int'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['emi_charges'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['overdue_int'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['other_charges'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['advance'] }}</td>
                                            <td class="px-4 py-2">{{ $paidSummary['discount'] }}</td>
                                        </tr>
                                        <tr class="text-error">
                                            <th class="px-4 py-2 text-left">DUE</th>
                                            <td class="px-4 py-2">{{ $dueSummary['net_p'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['emi_p'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['emi_int'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['emi_charges'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['overdue_int'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['other_charges'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['advance'] }}</td>
                                            <td class="px-4 py-2">{{ $dueSummary['discount'] }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Gold Loan Scheme Info-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black uppercase ">
                            Gold Loan Scheme Info
                        </h3>
                        <div class="">
                            <button type="button" class="p-1 rounded transition"
                                onclick="toggleSection(this, 'goldLoanSchemeInfo')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="overflow-x-auto mt-5 " id="goldLoanSchemeInfo">
                        <table
                            class="w-full border-collapse rounded-lg overflow-hidden whitespace-nowrap  bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2 w-1/2 md:w-1/3">
                                        Scheme Name
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->scheme_name ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">Scheme Code</td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->scheme_code ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">
                                        Maximum Loan Amount

                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ {{ $goldLoan->scheme->max_loan_amount ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">
                                        Maximum Loan Limit

                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->max_loan_limit ?? '' }} %
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-bold px-4 uppercase py-2">Interest Type</td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $settingLabel ?? '' }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Interest Rate
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->annual_interest_rate ?? '' }} %
                                    </td>
                                </tr>
                                <tr class=" text-center">
                                    <td class="font-bold px-4 uppercase py-2" colspan="2">
                                        Per EMI Charges
                                    </td>

                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        SMS Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->sms_charge ?? '0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Fuel Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->fuel_charge ?? '0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Stationary Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->stationary_charge ?? '0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Maintenance Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->maintenance_charge ?? '0.0' }} ₹
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Collection Charges
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->scheme->collection ?? '0.0' }} ₹
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--Update Branch/ Associate/ Guarantor-->
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black  uppercase">
                            Update Branch/ Associate/ Guarantor
                        </h3>
                        <div class="">
                            <button type="button" class="p-1 rounded transition"
                                onclick="toggleSection(this, 'Guarantor')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="overflow-x-auto mt-2 " id="Guarantor">
                        <form action="" class="mt-1    ">
                            <label for="" class="block mb-2 font-semibold">Branch</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Select Branch</option>
                                    </select>
                                    <button type="submit" class="block btn-primary uppercase rounded-10">Update</button>
                                </div>
                            </div>
                        </form>
                        <form action="" class="mt-1  ">
                            <label for="" class="block mb-2 font-semibold">Advisor/ Staff</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Advisor/Staff</option>
                                    </select>

                                    <button type="submit" class="block uppercase btn-primary rounded-10">Update</button>
                                </div>

                            </div>
                        </form>
                        <form action="" class="mt-1   ">
                            <label for="" class="block mb-2 font-semibold">Guarantor 1</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Select Guarantor Nme</option>
                                    </select>

                                    <button type="submit" class="block uppercase btn-primary rounded-10">Update</button>
                                </div>

                            </div>
                        </form>
                        <form action="" class="mt-1 ">
                            <label for="" class="block mb-2 font-semibold">Guarantor 2</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Select Guarantor Nme</option>
                                    </select>

                                    <button type="submit" class="block uppercase btn-primary rounded-10">Update</button>
                                </div>

                            </div>
                        </form>
                        <form action="" class="mt-1 ">
                            <label for="" class="block mb-2 font-semibold">Guarantor 3</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Select Guarantor Nme</option>
                                    </select>

                                    <button type="submit" class="block uppercase btn-primary rounded-10">Update</button>
                                </div>

                            </div>
                        </form>
                        <form action="" class="mt-1 ">
                            <label for="" class="block mb-2 font-semibold">Guarantor 4</label>
                            <div class="col-sm-7">
                                <div class="flex items-center gap-2">
                                    <select id="bonus-rate" name="bonus_rate_value"
                                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                        placeholder="Enter Penalty Value ">
                                        <option value="">Select Guarantor Nme</option>
                                    </select>

                                    <button type="submit" class="block uppercase btn-primary rounded-10">Update</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>


                {{-- Gold Loan Basic Details --}}
                <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                    <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                        <h3 class="text-lg font-semibold text-black uppercase ">
                            Gold Loan Basic Details
                        </h3>
                        <div class="">
                            <button type="button" class="p-1 rounded transition"
                                onclick="toggleSection(this, 'goldLoanSchemeInfo')">
                                <span class="toggle-icon text-lg font-bold">−</span>
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto mt-5" id="goldLoanSchemeInfo">
                        <table
                            class="w-full border-collapse rounded-lg overflow-hidden whitespace-nowrap  bg-white dark:bg-bg3">
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2 w-1/2 md:w-1/3">
                                        Branch
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->member->branch->branch_name ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">Advisor/ Staff</td>
                                    <td class="px-4 py-2 text-right md:text-left"></td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">
                                        Loan Amount
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        ₹ {{ $goldLoan->loan_amount ?? '' }}
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-semibold uppercase px-4 py-2">
                                        Annual Interest Rate
                                    </td>
                                    <td class="px-4 py-2 text-right md:text-left">
                                        {{ $goldLoan->scheme->annual_interest_rate ?? '' }} %
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="font-bold px-4 uppercase py-2">Credit Period</td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->credit_period ?? '' }} Days
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Interest Type
                                    </td>

                                    <td class="px-4 py-2 text-right md:text-left capitalize">
                                        {{ $settingLabel ?? '' }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2" colspan="">
                                        Per EMI Charges
                                    </td>
                                    <td class="px-4 py-2 ">
                                        {{ $goldLoan->emi_collection ?? '' }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Tenure of Loan
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->tenure ?? '' }} MONTHS
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Processing Fee
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        ₹ {{ $goldLoan->processing_fee_value ?? '0.0' }}
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-bold uppercase px-4 py-2">
                                        Purpose of Loan
                                    </td>
                                    <td class="px-4 py-2  text-right md:text-left">
                                        {{ $goldLoan->processing_fee_value ?? 'N/A' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>

        </div>


        <!-- Tabs Wrapper -->
        <div class="w-full box mt-5">
            <!-- Tab Navigation -->
            <ul class="flex border-b overflow-x-auto text-sm font-medium text-gray-600">
                @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi')
                    <li>
                        <button class="tab-btn px-4 py-2 border-b-2 uppercase text-primary" data-tab="tab1">
                            Repayment Schedule (Installments)
                        </button>
                    </li>
                @endif
                <li>
                    <button
                        class="tab-btn px-4 py-2 border-b-2 uppercase border-transparent hover:text-blue-600 hover:border-blue-500"
                        data-tab="tab2">
                        Current Statement
                    </button>
                </li>
                <li>
                    <button
                        class="tab-btn px-4 py-2 border-b-2 uppercase border-transparent hover:text-blue-600 hover:border-blue-500"
                        data-tab="tab3">
                        Security Deposit
                    </button>
                </li>
                @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi' &&
                        strtolower($goldLoan->scheme->gold_loan_setting) != 'flat_advanced_interest')
                    <li>
                        <button
                            class="tab-btn px-4 py-2 border-b-2 uppercase border-transparent hover:text-blue-600 hover:border-blue-500"
                            data-tab="tab4">
                            EIR Payout Chart
                        </button>
                    </li>
                @endif
            </ul>

            <div class="tab-content p-4">
                @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi')
                    <div id="tab1" class="tab-pane block">
                        <div class="overflow-x-auto">
                            <input type="hidden" id="loan_id" value="{{ $goldLoan->id }}">

                            <table class="w-full border-collapse whitespace-nowrap border  text-sm" id="emiTable">

                                <thead class="bg-secondary/5 border">
                                    <tr>
                                        <th class="p-2">EMI No.</th>
                                        <th class="p-2">EMI DATE</th>
                                        <th class="p-2">EMI DUE DATE</th>
                                        <th class="p-2">PRINCIPAL</th>
                                        <th class="p-2">INTEREST</th>
                                        <th class="p-2">OTHER CHRG.</th>
                                        <th class="p-2">EMI</th>
                                        <th class="p-2">BAL. PRINCIPAL</th>
                                        <th class="p-2">REMAINING AMT</th>
                                        <th class="p-2">PAID DATE</th>
                                        <th class="p-2">STATUS</th>
                                        <th class="p-2">PROCESSED</th>
                                        <th class="p-2">ACTIONS</th>
                                    </tr>
                                </thead>

                                <tbody class="border">
                                    @foreach ($emiSchedule as $emi)
                                        @php
                                            static $processShown = false;
                                            $rowStatus = $emi['status'];

                                            // Show PROCESS button ONLY on first UNPAID EMI
                                            $showProcessButton =
                                                $rowStatus === 'UNPAID' && !$processShown && $emi['status'] !== 'DUE';

                                            if ($showProcessButton) {
                                                $processShown = true;
                                            }
                                        @endphp


                                        <tr class="border {{ $emi['status'] == 'PAID' ? 'bg-green-50' : '' }}">
                                            <td class="p-2 border">{{ $emi['emi_no'] }}</td>
                                            <td class="p-2 border emi-date">{{ $emi['emi_date'] }}</td>
                                            <td class="p-2 border emi-due-date">{{ $emi['emi_due_date'] }}</td>
                                            <td class="p-2 border">{{ $emi['principal'] }}</td>
                                            <td class="p-2 border">{{ $emi['interest'] }}</td>
                                            <td class="p-2 border">{{ $emi['other_charges'] }}</td>
                                            <td class="p-2 border">{{ $emi['emi_amount'] }}</td>
                                            <td class="p-2 border">{{ $emi['balance_principal'] }}</td>
                                            <td class="p-2 border">{{ $emi['remaining_amount'] }}</td>
                                            <td class="p-2 border">{{ $emi['paid_date'] }}</td>

                                            <!-- STATUS -->
                                            <td class="p-2 border status">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary">
                                                    {{ $emi['status'] }}
                                                </span>
                                            </td>


                                            <!-- PROCESSED -->
                                            <td class="p-2 border processed">
                                                <span
                                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error">
                                                    {{ $emi['processed'] }}
                                                </span>
                                            </td>
                                            <td class="p-2 border">
                                                @if ($emi['status'] === 'PAID')
                                                    <a href="{{ route('gold-loan.emi_receipt.view', [$goldLoan->id, $emi['emi_no']]) }}"
                                                        class="btn-primary text-white px-3 py-1 rounded">
                                                        Print
                                                    </a>
                                                @elseif ($showProcessButton)
                                                    <button class="process-btn btn-primary px-3 py-1 rounded"
                                                        data-emi="{{ $emi['emi_no'] }}">
                                                        PROCESS
                                                    </button>
                                                @endif
                                            </td>


                                            {{-- 
                                            <!-- ACTION BUTTON -->
                                            <td class="p-2 border">
                                                @if ($showProcessButton)
                                                    <button class="process-btn btn-primary px-3 py-1 rounded"
                                                        data-emi="{{ $emi['emi_no'] }}">
                                                        PROCESS
                                                    </button>
                                                @endif
                                            </td> --}}

                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>
                    </div>
                @endif

                <div id="tab2" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-collapse whitespace-nowrap  text-sm">
                            <thead class="bg-gray-100 border">
                                <tr class="bg-secondary/5">
                                    <th class="text-start p-2 border">DATE</th>
                                    <th class="text-start p-2 border">TYPE</th>
                                    <th class="text-start p-2 border">PAYMENT MODE</th>
                                    <th class="text-start p-2 border">AMOUNT</th>
                                    <th class="text-start p-2 border">STATUS</th>
                                </tr>
                            </thead>
                            <tbody class="border">
                                @forelse($currentStatement as $row)
                                    <tr class="border-b">
                                        <td class="p-2 border">{{ Carbon::parse($row->date)->format('d-m-Y') }}</td>
                                        <td class="p-2 border">{{ $row->type }}</td>
                                        <td class="p-2 border">-</td>
                                        <td class="p-2 border">₹ {{ number_format($row->amount, 2) }}</td>

                                        {{-- Status Color --}}
                                        <td class="p-2 border">
                                            <span
                                                class="@if ($row->status == 'PAID') text-green-600 font-semibold @else text-red-600 font-semibold @endif">
                                                {{ ucfirst($row->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 p-3">No Records Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="tab3" class="tab-pane hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-collapse whitespace-nowrap  text-sm">
                            <thead class="border bg-gray-100">
                                <tr class="bg-secondary/5">
                                    <th class=" p-2 border">ITEM TYPE</th>
                                    <th class=" p-2 border">NAME</th>
                                    <th class=" p-2 border">QTY</th>
                                    <th class=" p-2 border">VAL./gm (₹)</th>
                                    <th class=" p-2 border">GROSS WEIGHT (gm)</th>
                                    <th class=" p-2 border">NET WEIGHT (gm)</th>
                                    <th class=" p-2 border">TUNCH (%)</th>
                                    <th class=" p-2 border">FINE WEIGHT (gm)</th>
                                    <th class=" p-2 border">TOTAL VAL. (₹)</th>
                                    <th class=" p-2 border">IMAGE</th>
                                    <th class=" p-2 border">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ornaments as $orn)
                                    <tr class="border-b">
                                        <td class="p-2 border">{{ $orn->item_type }}</td>
                                        <td class="p-2 border">{{ $orn->item_name }}</td>
                                        <td class="p-2 border">{{ $orn->no_of_items }}</td>
                                        <td class="p-2 border">{{ $orn->value_per_gram }}</td>
                                        <td class="p-2 border">{{ $orn->gross_weight }}</td>
                                        <td class="p-2 border">{{ $orn->net_weight }}</td>
                                        <td class="p-2 border">{{ $orn->tunch }}%</td>
                                        <td class="p-2 border">{{ $orn->fine_weight }}</td>
                                        <td class="p-2 border">{{ $orn->total_value }}</td>

                                        <td class="p-2 border">
                                            -
                                        </td>

                                        <td class="p-2 border">{{ $orn->status == 1 ? 'Mortgage' : 'Release' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center p-3 text-gray-500">
                                            No ornaments added.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if (strtolower($goldLoan->scheme->gold_loan_setting) != 'no_emi' &&
                        strtolower($goldLoan->scheme->gold_loan_setting) != 'flat_advanced_interest')
                    <div id="tab4" class="tab-pane hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse whitespace-nowrap text-sm">

                                {{-- HEADER --}}
                                <thead>
                                    <tr class="bg-gray-200 text-left">
                                        <th class="p-2 border">EMI No.</th>
                                        <th class="p-2 border">EMI DATE</th>
                                        <th class="p-2 border">EMI DUE DATE</th>
                                        <th class="p-2 border">EIR PRINCIPAL</th>
                                        <th class="p-2 border">EIR INTEREST</th>
                                        <th class="p-2 border">EIR OTHER CHRG.</th>
                                        <th class="p-2 border">EIR EMI</th>
                                        <th class="p-2 border">EIR BAL. PRINCIPAL</th>
                                        <th class="p-2 border">REMAINING AMT</th>
                                    </tr>
                                </thead>

                                {{-- FIRST ROW — LOAN AMOUNT --}}
                                <tr class="bg-yellow-100 font-semibold">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="9" class="p-2 border text-left">
                                        {{ number_format($goldLoan->loan_amount, 2) }}
                                    </td>
                                </tr>

                                {{-- EMI ROWS --}}
                                <tbody>
                                    @foreach ($eirSchedule as $row)
                                        <tr>
                                            <td class="p-2 border">{{ $row['emi_no'] }}</td>
                                            <td class="p-2 border">{{ $row['emi_date'] }}</td>
                                            <td class="p-2 border">{{ $row['emi_due_date'] }}</td>
                                            <td class="p-2 border">{{ $row['principal'] }}</td>
                                            <td class="p-2 border">{{ $row['interest'] }}</td>
                                            <td class="p-2 border">{{ $row['other_charges'] }}</td>
                                            <td class="p-2 border">{{ $row['emi_amount'] }}</td>
                                            <td class="p-2 border">{{ $row['balance_principal'] }}</td>
                                            <td class="p-2 border">{{ $row['remaining_amount'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>


    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        window.addEventListener("click", function(e) {
            const dropdown = document.getElementById("printDropdown");
            if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                dropdown.classList.add("hidden");
            }
        });
    </script>

    <!-- box minimize Code -->
    <script>
        const tabBtns = document.querySelectorAll(".tab-btn");
        const tabPanes = document.querySelectorAll(".tab-pane");

        tabBtns.forEach(btn => {
            btn.addEventListener("click", () => {
                const target = btn.dataset.tab;

                tabBtns.forEach(b => b.classList.remove("border-primary", "text-primary"));
                tabPanes.forEach(p => p.classList.add("hidden"));

                btn.classList.add("border-primary", "text-primary");
                document.getElementById(target).classList.remove("hidden");
            });
        });

        function toggleSection(button, sectionId) {
            const section = document.getElementById(sectionId);
            const icon = button.querySelector('.toggle-icon');

            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>

    <!-- process button -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const processButtons = document.querySelectorAll(".process-btn");

            // ⭐ STEP 1 — Disable buttons where previous EMI is NOT PAID
            processButtons.forEach(btn => {
                let row = btn.closest("tr");
                let prevRow = row.previousElementSibling;

                if (prevRow) {
                    let prevStatus = prevRow.querySelector(".status span").textContent.trim();

                    if (prevStatus !== "PAID") {
                        btn.disabled = true;
                        btn.classList.add("opacity-50", "cursor-not-allowed");
                    }
                }
            });

            // ⭐ STEP 2 — On Click Handler
            processButtons.forEach(btn => {
                btn.addEventListener("click", function() {

                    let row = btn.closest("tr");
                    let nextRow = row.nextElementSibling;

                    // ⭐ BLOCK IF PREVIOUS EMI NOT PAID
                    let prevRow = row.previousElementSibling;
                    if (prevRow) {
                        let prevStatus = prevRow.querySelector(".status span").textContent.trim();
                        let prevRemaining = parseFloat(
                            prevRow.querySelector("td:nth-child(9)").textContent.replace(/,/g,
                                '')
                        );

                        if (prevStatus !== "PAID" || prevRemaining > 0) {
                            alert("Please clear previous EMI first.");
                            return;
                        }
                    }

                    // ⭐ UPDATE CURRENT ROW STATUS
                    row.querySelector(".status span").textContent = "DUE";
                    row.querySelector(".processed span").textContent = "No";

                    const today = new Date();
                    row.querySelector("td:nth-child(10)").textContent =
                        `${String(today.getDate()).padStart(2, '0')}-${String(today.getMonth() + 1).padStart(2, '0')}-${today.getFullYear()}`;

                    let emiNo = btn.getAttribute("data-emi");
                    let loanId = document.getElementById("loan_id").value;

                    // ⭐ MOVE BUTTON TO NEXT ROW
                    btn.remove();

                    if (nextRow) {
                        let nextActionCell = nextRow.querySelector("td:last-child");
                        nextActionCell.appendChild(btn);

                        let newEmi = nextRow.querySelector("td:first-child").textContent.trim();
                        btn.setAttribute("data-emi", newEmi);

                        // Enable next button now
                        btn.disabled = false;
                        btn.classList.remove("opacity-50", "cursor-not-allowed");
                    }

                    // AJAX CALL
                    // current row ka remaining amount
                    let remaining = parseFloat(
                        row.querySelector("td:nth-child(9)").textContent.replace(/,/g, "")
                    );

                    fetch("{{ route('gold-loan.emi.saveStatus') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                loan_id: loanId,
                                emi_no: emiNo,
                                status: "DUE",
                                remaining_amount: remaining
                            })
                        })
                        .then(async res => {
                            let text = await res.text();
                            console.log("RAW:", text);

                            try {
                                console.log("JSON:", JSON.parse(text));
                            } catch (e) {
                                console.error("JSON PARSE ERROR:", e);
                            }
                        })
                        .catch(err => console.error("AJAX ERROR:", err));

                });
            });

        });
    </script>

    <!-- remove account -->
    <script>
        function confirmRemove(id) {
            if (!confirm(
                    'Are you sure you want to remove this account? This will update loan status to 0 and delete related transactions and other charges.'
                )) {
                return;
            }
            document.getElementById('remove-account-form-' + id).submit();
        }
    </script>



@endsection
