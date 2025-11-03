@extends('layout.main')
@section('content')

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

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl uppercase font-semibold">Gold Loan Application </h1>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">

        <!-- Always Visible -->
        <a href="{{ route('gold-loan.applications.view-buttons.show-emi-chart', $application->id) }}" 
            target="_blank" class="btn-primary px-2 py-2 rounded-10">
            Show EMI Chart
        </a>

        {{-- Status != DISBURSEMENT (2) --}}
        @if($application->status != 2)

            {{-- Status == DRAFT (0) OR CANCELED (3) --}}
            @if(in_array($application->status, [3]))
                <a href="{{route('gold-loan.applications.view-buttons.col_process_fee', $application->id)}}" 
                    class="btn-warning uppercase px-2 py-2 rounded-10">
                    Collect Processing Fee
                </a>
            @endif 

            {{-- Status != CANCELED (3) --}}
            @if($application->status != 3)
                <a href="{{ route('gold-loan.applications.view-buttons.disburse-setting', $application->id) }}" 
                    target="_blank" class="btn-warning uppercase px-2 py-2 rounded-10">
                    DISBURSE SETTINGS
                </a>
                <a href="#" class="btn-primary px-2 py-2 rounded-10">
                    REGISTER eNACH (Fidypay)
                </a>
                <a href="#" class="btn-primary px-2 py-2 rounded-10">
                    REGISTER eNACH (Rocketpay)
                </a>
                <a href="#" class="btn-primary px-2 py-2 rounded-10">
                    REGISTER eNACH (Rocketpay UPI)
                </a>
            @endif

        @endif


        {{-- If NOT CANCELED (3) then show print menu --}}
        @if($application->status != 3)
            <div class="relative inline-block text-left">

                <!-- Print Button -->
                <button type="button" class="btn-secondary px-2 py-2 rounded-10 flex items-center gap-2"
                    onclick="toggleDropdown('printDropdown')">
                    <i class="las la-print text-lg"></i>
                    PRINT DOCUMENTS
                    <i class="las la-angle-down text-xs"></i>
                </button>

                <!-- Print Dropdown Menu -->
                <div id="printDropdown"
                    class="hidden absolute right-0 mt-2 w-56 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 z-50">

                    @php $printDocs = [
                        'APPLICATION FORM',
                        'EMI SCHEDULE CHART',
                        'SANCTION LETTER',
                        'LOAN AGREEMENT',
                        'DISBURSE LETTER',
                        'PROMISSORY NOTE',
                        'LETTER OF UNDERTAKING',
                        'LETTER OF EVIDENCING',
                        'GUARANTOR AGREEMENT',
                        'JURISDICTION ACK LETTER',
                        'INDEMNIFICATION LETTER'
                    ]; @endphp

                    <div class="py-1">
                        @foreach($printDocs as $doc)
                            <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="las la-print text-secondary"></i> {{ $doc }}
                            </a>
                        @endforeach
                    </div>

                </div>

            </div>
        @endif

    </div>


    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <!-- Left: Details -->
        <div class=" w-full  overflow-hidden">
            <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                <div class="text-end p-3">
                   <a href="{{ route('gold-loan.applications.edit', $application->id) }}" class="p-2 btn-primary">
                        <i class="las la-pencil-alt"></i>
                    </a>
                    <!-- <a href="#" class=" p-2 btn-error">
                        <i class="las la-trash-alt"></i>
                    </a> -->
                </div>
                

                <table class="min-w-full text-sm text-left border-collapse">
                    <tbody class="divide-y divide-gray-200">
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3 uppercase">Customer</td>
                            <td class="px-4 py-2">
                                <a href="{{ url('members/member/'. $application->member->id) }}" 
                                class="text-primary capitalize hover:underline">
                                {{ $application->member->member_no }} - {{ $application->member->member_info_first_name }}
                                </a>
                            </td>
                        </tr>
                        @if($application->status == 1)
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3 uppercase">1st Co-Applicant Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->coApplicant1)->member_no }} - {{ optional($application->coApplicant1)->member_info_first_name }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 w-1/3 uppercase">2nd Co-Applicant Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->coApplicant2)->member_no }} - {{ optional($application->coApplicant2)->member_info_first_name }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Guarantor 1 Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->guarantor1)->member_no }} - {{ optional($application->guarantor1)->member_info_first_name }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Guarantor 2 Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->guarantor2)->member_no }} - {{ optional($application->guarantor2)->member_info_first_name }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Guarantor 3 Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->guarantor3)->member_no }} - {{ optional($application->guarantor3)->member_info_first_name }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2">Guarantor 4 Customer</td>
                            <td class="px-4 py-2 capitalize text-primary">
                                {{ optional($application->guarantor4)->member_no }} - {{ optional($application->guarantor4)->member_info_first_name }}
                            </td>
                        </tr>
                        @endif

                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Application No.</td>
                            <td class="px-4 py-2">{{ $application->id }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Application Date</td>
                            <td class="px-4 py-2">
                                {{ \Carbon\Carbon::parse($application->application_date)->format('d-m-Y') }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Loan Account No.</td>
                            <td class="px-4 py-2 text-primary">-</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Gold Loan Scheme</td>
                           <td class="text-start !py-5 px-6">
                                {{ $application->scheme->scheme_name ?? 'N/A' }}
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-semibold px-4 py-2 uppercase">Amount Approved</td>
                            <td class="px-4 py-2">₹ {{ $application->approved_loan_amount ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold px-4 py-2 uppercase">Status</td>
                            <td class="px-4 py-2">
                                @if($application->status == 0)
                                    <span class="block w-32 rounded-[30px] border border-yellow-400 bg-yellow-100 py-2 text-center text-xs text-yellow-600">
                                        PENDING
                                    </span>
                                @elseif($application->status == 1)
                                    <span class="block w-32 rounded-[30px] border border-green-400 bg-green-100 py-2 text-center text-xs text-green-600">
                                        APPROVED
                                    </span>
                                @elseif($application->status == 2)
                                    <span class="block w-32 rounded-[30px] border border-blue-400 bg-blue-100 py-2 text-center text-xs text-blue-600">
                                        DISBURSED
                                    </span>
                                @elseif($application->status == 3)
                                    <span class="block w-32 rounded-[30px] border border-red-400 bg-red-100 py-2 text-center text-xs text-red-600">
                                        CANCELLED
                                    </span>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>


            <!--Cibil Info-->
            <div class="box shadow-md mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 text-black justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black uppercase">Cibil Info</h3>
                    <div class=" flex gap-3">
                       
                        <!-- Modal Background (hidden by default) -->
                        <div id="creditScoreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <!-- Modal Container -->
                            <div class="bg-white rounded-lg shadow-xl min-w-full max-w-5xl mx-4">

                                <!-- Modal Header -->
                                <div class="flex items-center justify-between px-4 py-3 bg-blue-600 rounded-t-lg">
                                    <h2 class="text-white text-lg font-semibold ">Credit Score</h2>
                                    <button class="text-white hover:text-gray-200" onclick="closeModal()">
                                        ✕
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="p-6">
                                    <x-credit-score-details />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'cibilInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4 overflow-x-auto" id="cibilInfo">
                    <table class="min-w-full border border-gray-300 text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 font-semibold border">CIBIL Type</th>
                                <th class="px-4 py-2 font-semibold border">CIBIL Score</th>
                                <th class="px-4 py-2 font-semibold border">Report Date</th>
                                <th class="px-4 py-2 font-semibold border">View Report</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @if($application->creditScores && $application->creditScores->isNotEmpty())
                            @foreach($application->creditScores as $score)
                                @if($score)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2 border">{{ $score->cibil_type ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border">{{ $score->cibil_score ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border">
                                            {{ $score->report_date ? \Carbon\Carbon::parse($score->report_date)->format('d-m-Y') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 border">
                                            @if(!empty($score->report_file_path))                               
                                                <a href="{{ asset('storage/'.$score->report_file_path) }}" target="_blank" class="text-blue-500 underline text-sm">View File</a>                                           
                                            @else
                                                <span class="text-gray-500">No File Available</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-gray-500">No CIBIL Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                    </table>
                </div>
            </div>

            <div class="overflow-x-auto  md:block box mt-4 shadow-md rounded-lg">
                <table class="w-full text-md  whitesapce-nowrap">
                    <thead class="bg-gray-100  text-start">
                        <tr class="text-start">
                            <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase">Status</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase">Remarks</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase">Updated at</th>
                            <th class="px-2 py-2 font-semibold text-start text-gray-700 uppercase">Approved By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-b">
                            <td class="px-2 py-2 text-gray-800 uppercase"> approved</td>
                            <td class="px-2 py-2 text-gray-800 capitalize">—</td>
                            <td class="px-2 py-2 text-gray-800">21/08/2025 </td>
                            <td class="px-2 py-2 text-gray-800 uppercase">Test Test</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!--Security Deposits-->
            <div class="box shadow-md dark:bg-bg3  mt-5 rounded-lg overflow-hidden">

                <div
                    class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer">
                    <h3 class="text-lg font-semibold capitalize">Security Deposits</h3>
                    <div class="">


                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'SecurityDeposits')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-4" id="SecurityDeposits">
                    <div class="overflow-x-auto text-center mt-5">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full  rounded-lg text-sm">
                                <thead class="bg-secondary/5">
                                    <tr>
                                        <th class="px-3 py-2 text-left uppercase">Item Type</th>
                                        <th class="px-3 py-2 text-left uppercase">Name</th>
                                        <th class="px-3 py-2 text-center uppercase">Qty</th>
                                        <th class="px-3 py-2 text-center uppercase">Val./gm (₹)</th>
                                        <th class="px-3 py-2 text-center uppercase">Gross Weight (gm)</th>
                                        <th class="px-3 py-2 text-center uppercase">Net Weight (gm)</th>
                                        <th class="px-3 py-2 text-center uppercase">Tunch (%)</th>
                                        <th class="px-3 py-2 text-center uppercase">Fine Weight (gm)</th>
                                        <th class="px-3 py-2 text-center uppercase">Total Val. (₹)</th>
                                        <th class="px-3 py-2 text-center uppercase">Image</th>
                                        <th class="px-3 py-2 text-center uppercase">Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    @if($application->loanOrnaments->isNotEmpty())
                                        @foreach($application->loanOrnaments as $ornament)
                                            <tr>
                                                <td class="px-3 py-2">{{ $ornament->item_type ?? 'N/A' }}</td>
                                                <td class="px-3 py-2">{{ $ornament->item_name ?? 'N/A' }}</td>
                                                <td class="px-3 py-2 text-center">{{ $ornament->no_of_items ?? '0' }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->value_per_gram, 2) }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->gross_weight, 2) }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->net_weight, 2) }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->tunch, 2) }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->fine_weight, 2) }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($ornament->total_value, 2) }}</td>
                                                <td class="px-3 py-2 text-center">
                                                    @if(!empty($ornament->image_path))
                                                        <a href="{{ asset('storage/' . $ornament->image_path) }}" target="_blank" class="text-blue-500 underline">
                                                            View
                                                        </a>
                                                    @else
                                                        <span class="text-gray-400">No Image</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-2">
                                                    {{ $ornament->status == 0 ? 'RELEASED' : 'MORTGAGE' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center py-3 text-gray-500">
                                                No security deposits available.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>



            <!--documents-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  capitalize">
                        Documents

                    </h3>
                    <div class="">
                        <a href="{{route('gold-loan.applications.upload_documents')}}" class="btn-primary p-1 pointer">
                            <i class="las la-upload y"></i>
                        </a>

                        <button type="button" class="p-1 rounded transition" onclick="toggleSection(this, 'Documents')">
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
        </div>
        <!-- Right: Settings -->
        <div class=" w-full ">


            <div class="flex flex-row gap-4 p-3 dark:bg-bg3  mt-4 rounded-10">
                <div class="w-full bg-white dark:bg-bg3 p-4 rounded-10 shadow-md border border-gray-200">
                    <div class="flex justify-center gap-2  border-gray-200 px-4 py-3 bg-gray-50 rounded-t-2xl border-b">
                        <h3 class="font-semibold  text-center sm:text-lg">
                            CIBIL SCORE
                        </h3>
                    </div>

                    <div
                        class="flex justify-center items-center mt-3 px-4 py-6 text-2xl sm:text-3xl font-semibold text-red-500">
                        <label class="cursor-pointer">
                            @if($application->creditScores->isNotEmpty())
                                @foreach($application->creditScores as $score)
                                    <div class="flex justify-center items-center mt-3 px-4 py-6 text-2xl sm:text-3xl font-semibold text-red-500">
                                        <label class="cursor-pointer">
                                            {{ $score->cibil_score ?? 'N/A' }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-gray-500 mt-3">No CIBIL score available.</div>
                            @endif
                        </label>
                    </div>
                </div>
                <div class="w-full bg-white dark:bg-bg3 p-4 rounded-10 shadow-md border border-gray-200">
                    <div class="flex justify-center gap-2 border-b border-gray-200 px-4 py-3 bg-gray-50 rounded-t-2xl">

                        <h3 class="font-semibold  text-center sm:text-lg">
                            PROCESSING FEE
                        </h3>
                    </div>

                    <div class="flex justify-center items-center px-4 py-6 mt-3 text-2xl sm:text-3xl font-semibold ">
                        <label class="cursor-pointer">
                            <h3>0.0</h3>
                        </label>
                    </div>
                </div>
            </div>

            <!--SMS SETTINGS-->
            <div class="box dark:bg-bg3 mt-3 border-gray-200 shadow-md rounded-lg">
                <!-- Header -->
                <div class="px-4 py-3">
                    <h3 class="text-lg border-b font-semibold text-black">SMS SETTINGS</h3>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <tbody class="divide-y divide-gray-200">

                            <!-- SMS Toggle -->
                            <tr>
                                <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">SMS</td>
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
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Gold Loan Scheme Info-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">

                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black  uppercase">
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
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Scheme Name</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->scheme_name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Scheme Code</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->scheme_code ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Maximum Loan Amount</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->scheme->max_loan_amount ?? 0 }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Maximum Loan Limit</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->max_loan_limit ?? 0 }} %
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Interest Type</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->interest_type ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2 uppercase">Interest Rate</td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    {{ $application->scheme->annual_interest_rate ?? 0 }} %
                                </td>
                            </tr>

                        </tbody>
                   </table>
                </div>
            </div>


            <!--Gold Loan Application Info-->
            <div class="box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
                <div class="border-b flex items-center bg-secondary/5 justify-between px-4 py-2 rounded-10 ">
                    <h3 class="text-lg font-semibold text-black uppercase">
                        Gold Loan Application Info
                    </h3>
                    <div class="">
                        <button type="button" class="p-1 rounded transition"
                            onclick="toggleSection(this, 'goldLoanAppInfo')">
                            <span class="toggle-icon text-lg font-bold">−</span>
                        </button>
                    </div>
                </div>
                <!-- Body -->
                <div class="overflow-x-auto mt-5 " id="goldLoanAppInfo">
                    <table class="w-full border-collapse rounded-lg overflow-hidden  bg-white dark:bg-bg3">
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">
                                    Branch
                                </td>
                                <td class="px-4 py-2 text-right md:text-left uppercase">
                                    {{ $application->branch->branch_name ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2 uppercase">Amount Requested</td>
                                <td class="px-4 py-2 text-right md:text-left">₹ {{ $application->net_loan_amount }}</td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approvable
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->maximum_approvable_amount }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-semibold px-4 py-2">
                                    Amount Approved
                                </td>
                                <td class="px-4 py-2 text-right md:text-left">
                                    ₹ {{ $application->approved_loan_amount }}
                                </td>
                            </tr>

                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Interest Amount
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    ₹ 0.0
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Annual Interest Rate
                                </td>
                                <td class="px-4 py-2  text-right md:text-left">
                                    {{ $application->scheme->annual_interest_rate ?? 0 }} %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Annualized Percentage Rate (APR)
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    0 % | %
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Credit Period
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    {{ $application->credit_period }} Days
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Total Amount to Recover
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    ₹ 00.00
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Tenure of Loan
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    {{ $application->tenure_value }} MONTHS
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    EMI Payout
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    {{ $application->emi_collection }}
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="font-bold px-4 py-2">
                                    Insurance Fee
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    ₹ {{ $application->insurance_amount }} (Incl. 0.0 % GST)
                                </td>
                            </tr>
                            <tr class="">
                                <td class="font-bold px-4 py-2">
                                    Purpose of Loan
                                </td>
                                <td class="px-4 py-2   text-right md:text-left">
                                    {{ $application->purpose_of_loan }}
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown(id) {
            document.getElementById(id).classList.toggle("hidden");
        }

        // Close dropdown if clicked outside
        window.addEventListener("click", function(e) {
            const dropdown = document.getElementById("printDropdown");
            if (!e.target.closest("button") && !e.target.closest("#printDropdown")) {
                dropdown.classList.add("hidden");
            }
        });
    </script>





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