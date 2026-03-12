@extends('layout.main')
@section('page-title', isset($misaccount) ? (!empty($show) ? 'VIEW ' . $misaccount->name . ' MIS ACCOUNT' : 'EDIT ' .
$misaccount->name . ' MIS ACCOUNT') : 'ADD MIS ACCOUNT')
@section('content')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

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

    button[type="reset"]:active {
        transform: scale(0.95);
        opacity: 0.7;
        transition: 0.1s;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-start  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <!-- <h1 class="text-xl font-semibold">NEW MIS ACCOUNT</h1> -->
            <!-- <p class="text-gray-500">
                        <a href="{{ route('misaccount.index') }}" class="text-gray-500 text-sm">MIS Accounts</a> >
                        @if (isset($misaccount))
    <a href="#" class="text-gray-500  text-sm"> edit</a>
@else
    <a href="#" class="text-gray-500  text-sm"> New</a>
    @endif
                    </p> -->

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">

        @if (isset($misaccount))
        {{-- Update form --}}
        <form action="{{ route('misaccount.update', $misaccount->id) }}" method="POST">
            @csrf
            @method('PUT')
            @else
            {{-- Create form --}}
            <form action="{{ route('misaccount.store') }}" method="POST">
                @csrf
                @endif
                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="member_id" name="member_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                            <option value="">Select Customer name</option>
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id', $misaccount->member_id ?? '') ==
                                $member->id ? 'selected' : '' }}
                                data-fullname="{{ $member->full_name }}"
                                data-address="{{ $member->address->member_address_line_1 ?? '' }}"
                                data-branch="{{ $member->general_branch }}"
                                data-mobile="{{ $member->member_info_mobile_no ?? '' }}"
                                {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->full_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('member_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="member_name" class="md:text-lg font-medium block mb-4 uppercase">Customer
                            Name</label>
                        <input type="text" id="selected_member_name" name="member_name"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize"
                            placeholder="Customer Name" readonly>
                    </div>
                    @error('member_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    <div class="col-span-2 md:col-span-1">
                        <label for="city" class="md:text-lg font-medium block mb-4 uppercase">
                            Customer Address
                        </label>

                        <input type="text" id="selected_member_address" name="member_address"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize"
                            placeholder="Customer Address" value="" readonly>
                        @error('member_address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Mobile No.
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="text" name="" id=""
                                class=" text-sm bg-secondary/5 w-20 dark:bg-bg3 border  rounded-10 px-3 md:px-6  py-3 md:py-3"
                                value="+91" disabled>

                            <input type="text" id="selected_member_mobile" name="member_mobile"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6  py-3 md:py-3"
                                placeholder="Enter Mobile No " readonly>
                        </div>
                        @error('member_mobile')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label for="minor_id" class="md:text-lg font-medium block mb-4 uppercase">
                            Minor

                        </label>
                        <div class="flex items-center gap-1 ">

                            <select id="minor_id" name="minor_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                                <option value="">Select minor</option>
                                @foreach ($minors as $minor)
                                <option value="{{ $minor->id }}" data-member="{{ $minor->member_id }}"
                                    style="display:none;">
                                    {{ $minor->first_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('minor_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1 pt-3">
                        <label for="fd_scheme_id" class="md:text-lg font-medium block mb-4 uppercase">
                            Schemes
                        </label>
                        <div class="flex items-center gap-1">
                            <select name="fd_scheme_id" id="fd_scheme_id"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                                <option value="">Select Scheme</option>
                                @foreach ($schemes as $scheme)
                                <option value="{{ $scheme->id }}" data-min_amount="{{ $scheme->min_amount }}" {{
                                    old('fd_scheme_id', $misaccount->fd_scheme_id ?? '') == $scheme->id ? 'selected' :
                                    '' }}>
                                    {{ $scheme->scheme_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('fd_scheme_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Branch
                            <span class="text-red-500">*</span>
                        </label>

                        <select id="branch_id" name="branch_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 capitalize">
                            <option value="">Select branch</option>
                            @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ (old('branch_id') ?? ($misaccount->branch_id ?? '')) ==
                                $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                            @endforeach
                        </select>

                        @error('branch_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Advisor/ Staff

                        </label>

                        <select name="advisor_id" id="advisor_id"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3 capitalize">
                            <option value="">Select advisor</option>
                            <option value="1" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 1 ? 'selected' : ''
                                }}>Rahul Mehra
                            </option>
                            <option value="2" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 2 ? 'selected' : ''
                                }}>Priya Sharma
                            </option>
                            <option value="3" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 3 ? 'selected' : ''
                                }}>Ankit Verma
                            </option>
                            <option value="4" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 4 ? 'selected' : ''
                                }}>Neha Iyer
                            </option>
                            <option value="5" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 5 ? 'selected' : ''
                                }}>Amit Joshi
                            </option>
                            <option value="6" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 6 ? 'selected' : ''
                                }}>Sneha Reddy
                            </option>
                            <option value="7" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 7 ? 'selected' : ''
                                }}>Ravi Kapoor
                            </option>
                            <option value="8" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 8 ? 'selected' : ''
                                }}>Kavita Nair
                            </option>
                            <option value="9" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 9 ? 'selected' : ''
                                }}>Arjun Desai
                            </option>
                            <option value="10" {{ old('advisor_id', $misaccount->advisor_id ?? '') == 10 ? 'selected' :
                                '' }}>
                                Pooja Singh</option>
                        </select>
                        @error('advisor_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <x-datepicker-disabled label="OPEN DATE" name="open_date" value="{{ old('open_date') }}"
                            inputId="open_date" />
                    </div>

                    @if (!isset($misaccount))
                    <!-- Show Tenure fields ONLY in Create form -->
                    <!-- <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            Tenure Period
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="md:w-2/3 flex flex-row gap-2 my-2 space-y-2 md:flex-row md:space-y-0 md:space-x-2">
                            <input type="number" name="tenure_year" placeholder="Year"
                                class="w-full md:w-1/3 border bg-secondary/5 rounded-10 px-3 py-3">
                            <input type="number" name="tenure_month" placeholder="Month"
                                class="w-full md:w-1/3 border bg-secondary/5 rounded-10 px-3 py-3">
                            <input type="number" name="tenure_day" placeholder="Days"
                                class="w-full md:w-1/3 border bg-secondary/5 rounded-10 px-3 py-3">
                        </div>
                    </div> -->
                    @else
                    <!-- Show another div ONLY in Edit form -->
                    <!-- <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">

                        </label>
                        <div class="p-3">
                            <p class="text-sm text-gray-700">

                            </p>
                        </div>
                    </div> -->
                    @endif
                    <!-- @error('tenure_year')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @error('tenure_month')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    @error('tenure_day')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror -->

                    <div class="col-span-2 md:col-span-1">
                        <label for="misAmount" class="md:text-lg font-medium block mb-4 uppercase">
                            MIS Amount <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="misAmount" name="mis_amount"
                            value="{{ old('mis_amount', $misaccount->mis_amount ?? '') }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="0.0">

                        <p id="misAmountError" class="text-red-500 text-sm mt-1 hidden"></p>
                        <x-number-to-word for="misAmount" />
                        @error('mis_amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    @if (!isset($misaccount))
                    <div class="col-span-2 md:col-span-1">
                        <label for="interest_payout_type" class="md:text-lg font-medium block mb-4 uppercase">
                            Interest Payout Type
                            <span class="text-error ">*</span>
                        </label>

                        <select name="interest_payout_type" id="interest_payout_type"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">

                            <option value="monthly" selected>Monthly</option>

                        </select>

                    </div>
                    @else
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">

                        </label>
                        <div class="p-3">
                            <p class="text-sm text-gray-700">

                            </p>
                        </div>
                    </div>
                    @endif
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                            TDS Deduction
                            <span class="text-red-500">*</span>
                        </label>

                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="tds_deduction" value="yes" {{ old('tds_deduction',
                                    $misaccount->tds_deduction ?? '') == 'yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="tds_deduction" checked value="no" {{ old('tds_deduction',
                                    $misaccount->tds_deduction ?? '') == 'no' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>

                        @error('tds_deduction')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (!isset($misaccount))
                    <div class="col-span-2 md:col-span-1">
                        <label class="md:w-1/3 font-medium uppercase">Senior Citizen</label>
                        <div class="md:w-2/3 my-2">
                            <!-- Hidden ensures "no" is submitted if unchecked -->
                            <input type="hidden" name="senior_citizen" value="no" checked>
                            <input type="checkbox" name="senior_citizen" value="yes" class="w-5 h-5">
                        </div>
                    </div>
                    @else
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">

                        </label>
                        <div class="p-3">
                            <p class="text-sm text-gray-700">

                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="col-span-2 md:col-span-1">
                        <!--  Account Type -->
                        <label class="md:text-lg font-medium block mb-4 uppercase">
                            Account Type <span class="text-red-500">*</span>
                        </label>

                        <div class="flex items-center gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_type" value="single" checked
                                    onclick="toggleSelect(false)" {{ old('account_type', $misaccount->account_type ??
                                '') == 'single' ? 'checked' : '' }}>
                                Single
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="radio" name="account_type" value="joint" onclick="toggleSelect(true)" {{
                                    old('account_type', $misaccount->account_type ?? '') == 'joint' ? 'checked' : '' }}>
                                Joint A/C
                            </label>
                        </div>

                        <!-- Select list (shown only if Joint A/C) -->
                        <div id="accountSelect"
                            class="{{ isset($misaccount) && $misaccount->joint_member_id ? '' : 'hidden' }} mt-4">
                            <label for="joint_member_id" class="md:text-lg font-medium block mb-4 uppercase">
                                Joint A/C Customer <span class="text-red-500">*</span>
                            </label>

                            <select name="joint_member_id"
                                class="text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 w-full">
                                <option value="">Select customer or name</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}" data-fullname="{{ $member->full_name }}"
                                    data-address="{{ $member->address->member_address_line_1 ?? '' }}"
                                    data-branch="{{ $member->general_branch }}"
                                    data-mobile="{{ $member->member_info_mobile_no ?? '' }}" {{ old('joint_member_id',
                                    $misaccount->joint_member_id ?? '') == $member->id ? 'selected' : '' }}>
                                    {{ $member->full_name }}
                                </option>
                                @endforeach
                            </select>

                            @error('joint_member_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        @error('account_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <!--  Nominee  -->
                    <div class="mt-4 col-span-2 md:col-span-1">
                        <p class="font-medium uppercase">
                            Nominee <span class="text-red-500">*</span>
                        </p>

                        <div class="flex items-center gap-2">
                            <label class="mt-2 flex items-center gap-2">
                                <input type="radio" name="nominee" value="yes" onclick="toggleAddMore(true)" {{
                                    isset($misaccount) && $misaccount->nominee == 'yes' ? 'checked' : '' }}> Yes
                            </label>

                            <label class="mt-2 flex items-center gap-2">
                                <input type="radio" name="nominee" checked value="no" onclick="toggleAddMore(false)" {{
                                    isset($misaccount) && $misaccount->nominee == 'no' ? 'checked' : '' }}> No
                            </label>
                        </div>


                        <!-- Add More Button -->
                        <div id="addMoreText"
                            class="{{ old('nominee', $misaccount->nominee ?? '') == 'yes' ? '' : 'hidden' }} mt-3">
                            <p class="text-blue-600 underline cursor-pointer uppercase" onclick="addNomineeInputs()">
                                + ADD MORE NOMINEE
                            </p>
                        </div>
                    </div>
                </div>

                <div id="extraInputs" class="mt-4 space-y-3">
                    @if (isset($misaccount) && $misaccount->nominees->count() > 0)
                    {{-- ✅ Show saved nominees --}}
                    @foreach ($misaccount->nominees as $nominee)
                    <div class="nominee-item flex flex-wrap gap-4 items-end bg-gray-50 p-3 rounded-md shadow">

                        <!-- Relation -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="font-medium mb-2 block uppercase">Relation <span
                                    class="text-red-500">*</span></label>
                            <select name="nominee_relation[]"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3 capitalize">
                                <option value="">Select Relation</option>
                                <option value="mother" {{ $nominee->nominee_relation == 'mother' ? 'selected' : '' }}>
                                    Mother</option>
                                <option value="son" {{ $nominee->nominee_relation == 'son' ? 'selected' : '' }}>Son
                                </option>
                                <option value="daughter" {{ $nominee->nominee_relation == 'daughter' ? 'selected' : ''
                                    }}>Daughter</option>
                                <option value="spouse" {{ $nominee->nominee_relation == 'spouse' ? 'selected' : '' }}>
                                    Spouse (Husband/Wife)</option>
                                <option value="husband" {{ $nominee->nominee_relation == 'husband' ? 'selected' : ''
                                    }}>Husband</option>
                                <option value="wife" {{ $nominee->nominee_relation == 'wife' ? 'selected' : '' }}>
                                    Wife
                                </option>
                                <option value="brother" {{ $nominee->nominee_relation == 'brother' ? 'selected' : ''
                                    }}>Brother</option>
                                <option value="sister" {{ $nominee->nominee_relation == 'sister' ? 'selected' : '' }}>
                                    Sister</option>
                                <option value="daughter_in_law" {{ $nominee->nominee_relation == 'daughter_in_law' ?
                                    'selected' : '' }}>
                                    Daughter in Law</option>
                                <option value="brother_in_law" {{ $nominee->nominee_relation == 'brother_in_law' ?
                                    'selected' : '' }}>
                                    Brother in Law</option>
                                <option value="grand_daughter" {{ $nominee->nominee_relation == 'grand_daughter' ?
                                    'selected' : '' }}>
                                    Grand Daughter</option>
                                <option value="grand_son" {{ $nominee->nominee_relation == 'grand_son' ? 'selected' : ''
                                    }}>Grand Son
                                </option>
                                <option value="nephew" {{ $nominee->nominee_relation == 'nephew' ? 'selected' : '' }}>
                                    Nephew</option>
                                <option value="niece" {{ $nominee->nominee_relation == 'niece' ? 'selected' : '' }}>
                                    Niece</option>
                                <option value="other" {{ $nominee->nominee_relation == 'other' ? 'selected' : '' }}>
                                    Other</option>
                            </select>
                        </div>

                        <!-- Name -->
                        <div class="flex-1 min-w-[200px]">
                            <label class="font-medium mb-2 block uppercase">Name <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nominee_name[]" value="{{ $nominee->nominee_name }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3 capitalize">
                        </div>

                        <!-- Address -->
                        <div class="flex-1 min-w-[250px]">
                            <label class="font-medium mb-2 block uppercase">Address <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nominee_address[]" value="{{ $nominee->nominee_address }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 py-3 capitalize">
                        </div>

                        <!-- Remove button -->
                        <div class="flex items-center">
                            <button type="button" onclick="removeNominee(this)"
                                class="text-error font-bold text-lg hover:text-red-700">✕</button>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>


                {{-- previous transaction table --}}
                @if (isset($misaccount) && $misaccount->transactions->count() > 0)
                <div id="transactions-fields" class="w-full mt-6">
                    <h4 class="text-lg font-semibold mb-3 uppercase">Previous Transactions:</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse min-w-[600px]">
                            <thead>
                                <tr class="bg-gray-100 border-b text-center text-sm">
                                    <th class="px-3 py-2  text-center">Pay Mode</th>
                                    <th class="px-3 py-2  text-center">Amount</th>
                                    <th class="px-3 py-2  text-center">Transaction Date</th>
                                    <th class="px-3 py-2  text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($misaccount->transactions as $transaction)
                                <tr class="border-b  border-gray-200">
                                    <td class="px-3 py-2 text-center">{{ ucfirst($transaction->pay_mode) }}</td>
                                    <td class="px-3 py-2 text-center">{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-3 py-2 text-center">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium ">
                                            @if ($misaccount->status == 0)
                                            <span class="text-warning">Pending</span>
                                            @elseif ($misaccount->status == 1)
                                            <span class="text-primary"> Approve</span>
                                            @elseif ($misaccount->status == 2)
                                            <span class="text-error  "> Not Approve</span>
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                    @if (!isset($misaccount))
                    <div class="col-span-2 md:col-span-1">
                        <label for="finalAmount" class="md:text-lg font-medium block mb-4 uppercase">
                            Final Amount
                        </label>
                        <input type="text" id="finalAmount" name="final_amount"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-3 md:py-3"
                            placeholder="0" readonly>
                    </div>
                    @endif
                    <div class="col-span-2 md:col-span-1">
                        <x-datepicker-disabled label="T.Date" name="transaction_date"
                            value="{{ old('transaction_date') }}" inputId="transaction_date" />
                    </div>

                    @if (isset($misaccount))
                    <div class="col-span-2 md:col-span-1">
                        <label for="" class="md:text-lg font-medium block mb-4">

                        </label>
                        <div class="p-3">
                            <p class="text-sm text-gray-700">

                            </p>
                        </div>
                    </div>
                    @endif
                    <!--Pay Mode-->
                    <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">

                        <!-- Section Title -->
                        <h4 class="md:text-lg font-semibold text-gray-800 dark:text-white mb-2 uppercase">Pay Mode </h4>

                        <!-- Amount Field -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
                            <label for="" class="text-sm font-medium text-gray-700">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="amount" name="amount" placeholder="Enter Amount"
                                    class="w-full border rounded-10 px-3 py-3 text-sm bg-white/5" readonly
                                    value="{{ old('amount', default: isset($misaccount) ? $misaccount->amount : '') }}">
                            </div>
                        </div>


                        <!-- Pay Mode -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                            <label class="text-sm font-medium text-gray-700 uppercase">
                                Pay Mode <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2 flex flex-wrap gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="cash"
                                        class="text-green-500 focus:ring-green-500" checked>
                                    <span class="text-sm text-gray-700">Cash</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="cheque"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Cheque</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="online"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Online Tr.</span>
                                </label>
                                @if (!isset($misaccount))
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="pay_mode" value="saving"
                                        class="text-green-500 focus:ring-green-500">
                                    <span class="text-sm text-gray-700">Saving Ac.</span>
                                </label>
                                @endif
                            </div>
                        </div>
                        @error('pay_mode')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Cheque Fields -->
                        <div id="chequeFields" class="space-y-4 hidden">
                            <div class="mt-3">
                                {{-- <label class="block text-sm font-medium text-gray-700">Bank Name <span
                                        class="text-red-500">*</span></label>
                                <x-searchable-dropdown :items="$banks" label="Bank Name" name="bank_id"
                                    display-field="name" value-field="id" :selected="old('bank_id')" /> --}}
                                <div id="bankDropdownWrapper" class="mt-3 ">

                                    <select name="bank_id" id="bank_id"
                                        class="w-full rounded-10 border px-3 py-3 text-sm">
                                        <option value="">-- Select Bank --</option>

                                        @foreach($banks as $id => $name)
                                        <option value="{{ $id }}" {{ old('bank_id')==$id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('bank_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror

                                    <!-- Cheque No -->
                                    {{-- <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque No.</label>
                                        <input type="text" name="cheque_no"
                                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3"
                                            placeholder="Enter Cheque No"
                                            value="  {{ old('cheque_no', $application->cheque_no ?? '') }}">
                                    </div> --}}

                                    <!-- Cheque Date -->
                                    {{-- <div class="mt-3">
                                        <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                                        <input type="text" id="cheque_date" name="cheque_date"
                                            value="{{ old('cheque_date', isset($application->cheque_date) ? \Carbon\Carbon::parse($application->cheque_date)->format('d-m-Y') : '') }}"
                                            class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                                    </div> --}}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cheque No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                                    name="cheque_no" placeholder="Enter Cheque No.">
                            </div>
                            @error('cheque_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div>
                                <x-datepicker-disabled label="Cheque Date" name="cheque_date"
                                    value="{{ old('cheque_date') }}" inputId="cheque_date" />
                            </div>

                        </div>

                        <!-- Online Transaction Fields -->
                        <div id="onlineFields" class="space-y-4 hidden">
                            <div class="mt-3">
                                <x-datepicker-disabled label="Transfer Date" name="transfer_date"
                                    value="{{ old('transfer_date') }}" inputId="transfer_date" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span
                                        class="text-red-500">*</span></label>
                                <input type="text"
                                    class="w-full border rounded-10 px-3 py-3 text-sm dark:bg-bg3 bg-white"
                                    name="utr_no" placeholder="Enter Transaction No.">
                            </div>
                            @error('utr_no')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Transfer Mode <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="imps"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>IMPS</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="vpa"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>VPA</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="transfer_mode" value="neft_rtgs"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>NEFT/RTGS</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Credited in Company Account <span
                                        class="text-red-500">*</span></label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="yes"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>Yes</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="radio" name="credited" value="no"
                                            class="text-green-500 focus:ring-green-500">
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                            @error('credited')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div id="savingFields" class="space-y-4 mt-3 hidden">
                            <label class="block text-sm font-medium text-gray-700">
                                Select Saving Account <span class="text-red-500">*</span>
                            </label>

                            <!-- Saving Account Select -->
                            <select id="savingAccountSelect" name="saving_account_id"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-white mt-3">
                                <option value="">Select Account</option>
                            </select>

                            <!-- Balance Display -->
                            <div id="accountBalanceDiv" class="mt-3 hidden">
                                <label class="block text-sm font-medium text-gray-700">Account Balance</label>
                                <div id="accountBalance" class="p-3 text-sm font-semibold text-primary"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="flex flex-col sm:flex-row justify-center   gap-3 mt-5 w-full">
                    {{-- <button type="submit" class=" sm:w-auto  justify-center btn-primary  uppercase " name="save">
                        open Mis
                    </button> --}}
                    <button type="submit" class="sm:w-auto justify-center  btn-primary uppercase">
                        {{ isset($misaccount) ? 'Update MIS' : 'Open MIS' }}
                    </button>
                    @if (!isset($misaccount))
                    <button type="reset" class="sm:w-auto  justify-center uppercase btn-outline">
                        Reset
                    </button>
                    @endif
                    <button type="button" class=" sm:w-auto justify-center uppercase btn-outline"
                        onclick="window.location.href='{{ route('misaccount.index') }}'">
                        Back
                    </button>
                </div>
            </form>
    </div>

</div>



<!--Scripts here-->
<!--nomine -->
<script>
    //nomine
        function toggleSelect(show) {
            document.getElementById(" accountSelect").classList.toggle("hidden", !show);
        }

        function toggleAddMore(show) {
            document.getElementById("addMoreText").classList.toggle("hidden", !show);
            if (!show) {
                document.getElementById("extraInputs").innerHTML = "";
            }
        }

        function addNomineeInputs() {
            const container = document.getElementById("extraInputs");
            const nomineeBlock = document.createElement("div");

            nomineeBlock.className = "nominee-item grid grid-cols-4 gap-2 tems-center bg-gray-50 p-2 rounded-md shadow";
            nomineeBlock.innerHTML = `
                        <div class="nominee-row flex flex-wrap items-start gap-6">
                        <div class="flex-center flex-1 min-w-[200px] max-w-full">
                            <label class="font-medium mb-2">Relation
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="nominee_relation[]" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                                <option value="">Select Relation</option>
                                <option value="mother">Mother</option>
                                <option value="son">Son</option>
                                <option value="daughter">Daughter</option>
                                <option value="spouse">Spouse (Husband/ Wife)</option>
                                <option value="husband">Husband</option>
                                <option value="wife">Wife</option>
                                <option value="brother">Brother</option>
                                <option value="sister">Sister</option>
                                <option value="daughter_in_law">Daughter in Law</option>
                                <option value="brother_in_law">Brother in Law</option>
                                <option selected="selected" value="grand_daughter">Grand Daughter</option>
                                <option value="grand_son">Grand Son</option>
                                <option value="nephew">Nephew</option>
                                <option value="niece">Niece</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[200px] max-w-full">
                            <label class="font-medium mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nominee_name[]" placeholder="Enter Nominee Name" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                        </div>
                        <div class="flex-1 min-w-[200px] max-w-full">
                            <label class="font-medium mb-2">Address <span class="text-red-500">*</span></label>
                            <input type="text" name="nominee_address[]" placeholder="Enter Nominee Address" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border  rounded-10 px-3 md:px-6   py-3 md:py-3 capitalize">
                        </div>

                        <div class="flex-1 min-w-[60px] max-w-full flex justify-end items-center">
                            <button type="button" onclick="removeNominee(this)" class="text-error font-bold text-lg hover:text-red-700">✕</button>
                        </div>
                </div>`;
            container.appendChild(nomineeBlock);
        }

        function removeNominee(button) {
            const item = button.closest(".nominee-item");
            if (item) item.remove();

            const container = document.getElementById("extraInputs");

            // ✅ Keep container visible, just clear content if empty
            if (container.children.length === 0) {
                container.innerHTML = "";
            }
        }
</script>
<!--payment mode1-->
<script>
    //payment mode1
        const payModeRadios = document.querySelectorAll('input[name="pay_mode"]');
        const onlineFields = document.getElementById('onlineFields');
        const chequeFields = document.getElementById('chequeFields');
        const savingFields = document.getElementById('savingFields');

        payModeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                // hide all first
                onlineFields.classList.add('hidden');
                chequeFields.classList.add('hidden');
                savingFields.classList.add('hidden');

                // show based on selected
                if (radio.value === 'online') onlineFields.classList.remove('hidden');
                if (radio.value === 'cheque') chequeFields.classList.remove('hidden');
                if (radio.value === 'saving') savingFields.classList.remove('hidden');
            });
        });
</script>


<!--saving account amount show here-->
<script>
    //saving account amount show here
        document.getElementById('savingAccountSelect').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let balance = selectedOption.getAttribute('data-balance');
            let balanceDiv = document.getElementById('accountBalanceDiv');
            let balanceText = document.getElementById('accountBalance');

            if (balance) {
                balanceText.textContent = "₹ " + balance;
                balanceDiv.classList.remove('hidden');
            } else {
                balanceText.textContent = "";
                balanceDiv.classList.add('hidden');
            }
        });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('member_id');
            const nameInput = document.getElementById('selected_member_name');
            const addressInput = document.getElementById('selected_member_address');
            const mobileInput = document.getElementById('selected_member_mobile');

            function updateFields(option) {
                nameInput.value = option.getAttribute('data-fullname') || '';
                addressInput.value = option.getAttribute('data-address') || '';
                mobileInput.value = option.getAttribute('data-mobile') || '';
            }

            select.addEventListener('change', function() {
                updateFields(this.options[this.selectedIndex]);
            });

            // On load (e.g. after validation error)
            updateFields(select.options[select.selectedIndex]);
        });
</script>



<script>
    //branch
        document.addEventListener('DOMContentLoaded', function() {
            const memberSelect = document.getElementById('member_id');
            const minorSelect = document.getElementById('minor_id');
            const allMinorOptions = Array.from(minorSelect.querySelectorAll('option[data-member]'));

            function filterAndSelectMinor(memberId) {
                minorSelect.value = ''; // reset

                // Hide and disable all minors
                allMinorOptions.forEach(option => {
                    option.style.display = 'none';
                    option.disabled = true;
                });

                // Show minors for selected member
                const relatedMinors = allMinorOptions.filter(option => option.getAttribute('data-member') ===
                    memberId);

                if (relatedMinors.length > 0) {
                    relatedMinors.forEach(option => {
                        option.style.display = 'block';
                        option.disabled = false;
                    });
                    // Automatically select the first minor
                    minorSelect.value = relatedMinors[0].value;
                }
            }

            memberSelect.addEventListener('change', function() {
                filterAndSelectMinor(this.value);
            });

            // Optional: If member already selected on page load, run once
            if (memberSelect.value) {
                filterAndSelectMinor(memberSelect.value);
            }
        });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
            const memberSelect = document.getElementById('member_id');
            const branchSelect = document.getElementById('branch_id');

            const allBranchOptions = Array.from(branchSelect.options).filter(opt => opt.value !== "");

            function updateBranchFromMember() {
                const selectedMember = memberSelect.options[memberSelect.selectedIndex];
                const branchId = selectedMember.getAttribute('data-branch');

                // Reset all options
                branchSelect.value = "";
                allBranchOptions.forEach(opt => {
                    opt.style.display = 'none';
                });

                // Show and select the matching branch
                if (branchId) {
                    const match = branchSelect.querySelector(`option[value="${branchId}"]`);
                    if (match) {
                        match.style.display = 'block';
                        branchSelect.value = branchId;
                    }
                }
            }

            memberSelect.addEventListener('change', updateBranchFromMember);

            // Optional: pre-fill on page load
            if (memberSelect.value) {
                updateBranchFromMember();
            }
        });
</script>

<!--same amount chnage at misamount , final and amount-->
<script>
    const misAmount = document.getElementById('misAmount');
        const finalAmount = document.getElementById('finalAmount');
        const amount = document.getElementById('amount');

        function syncAmounts() {
            const misValue = misAmount.value || 0;
            if (finalAmount) finalAmount.value = misValue;
            if (amount) amount.value = misValue;
        }

        // Sync on page load
        syncAmounts();

        // Sync when user changes
        misAmount.addEventListener('input', syncAmounts);
</script>

<!--Show/hide  Rdios section based on radio-->
<script>
    const radios = document.querySelectorAll('input[name="pay_mode"]');
        const savingFields = document.getElementById('savingFields');
        const savingSelect = document.getElementById('savingAccountSelect');
        const balanceDiv = document.getElementById('accountBalanceDiv');
        const balanceText = document.getElementById('accountBalance');

        // Show/hide Saving Account section based on radio
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'saving') {
                    savingFields.classList.remove('hidden');

                    // Restore previous selection if exists
                    let savedBalance = localStorage.getItem('selected_balance');
                    let savedAccount = localStorage.getItem('selected_account');

                    if (savedBalance && savedAccount) {
                        savingSelect.value = savedAccount;
                        balanceText.textContent = "₹ " + savedBalance;
                        balanceDiv.classList.remove('hidden');
                    }
                } else {
                    savingFields.classList.add('hidden');
                    balanceDiv.classList.add('hidden');
                }
            });
        });

        // Handle saving account select
        savingSelect.addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let balance = selectedOption.getAttribute('data-balance');

            if (balance) {
                balanceText.textContent = "₹ " + balance;
                balanceDiv.classList.remove('hidden');
                localStorage.setItem('selected_balance', balance);
                localStorage.setItem('selected_account', this.value);
            } else {
                balanceText.textContent = "";
                balanceDiv.classList.add('hidden');
                localStorage.removeItem('selected_balance');
                localStorage.removeItem('selected_account');
            }
        });

        // Restore on page reload
        window.addEventListener('DOMContentLoaded', function() {
            let savedPayMode = document.querySelector('input[name="pay_mode"]:checked');
            let savedBalance = localStorage.getItem('selected_balance');
            let savedAccount = localStorage.getItem('selected_account');

            if (savedPayMode && savedPayMode.value === 'saving') {
                savingFields.classList.remove('hidden');
                if (savedBalance && savedAccount) {
                    savingSelect.value = savedAccount;
                    balanceText.textContent = "₹ " + savedBalance;
                    balanceDiv.classList.remove('hidden');
                }
            }
        });
</script>


<script>
    // saving account selection by members

        document.getElementById('member_id').addEventListener('change', function() {
            let memberId = this.value;
            let accountSelect = document.getElementById('savingAccountSelect');
            accountSelect.innerHTML = '<option value="">Select Account</option>'; // reset

            if (memberId) {
                fetch(`/misaccount/member/${memberId}/accounts`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(account => {
                            let option = document.createElement('option');
                            option.value = account.id;
                            option.textContent = account.account_no;
                            option.setAttribute('data-balance', account.amount_deposit);
                            accountSelect.appendChild(option);
                        });
                    });
            }
        });

        // Show balance when account is selected
        document.getElementById('savingAccountSelect').addEventListener('change', function() {
            let balanceDiv = document.getElementById('accountBalanceDiv');
            let balanceSpan = document.getElementById('accountBalance');
            let selectedOption = this.options[this.selectedIndex];
            let balance = selectedOption.getAttribute('data-balance');

            if (balance) {
                balanceDiv.classList.remove('hidden');
                balanceSpan.textContent = balance;
            } else {
                balanceDiv.classList.add('hidden');
            }
        });
</script>

<!-- selected scheme amount scheme and mis/*Amount should be greater than or equal*/-->
<script>
    // selected scheme amount scheme and mis/Amount should be greater than or equal/
        document.addEventListener("DOMContentLoaded", function() {
            const fdScheme = document.getElementById("fd_scheme_id");
            const misAmount = document.getElementById("misAmount");
            const errorMsg = document.getElementById("misAmountError");
            const form = misAmount.closest("form");

            form.addEventListener("submit", function(e) {
                const selectedOption = fdScheme.options[fdScheme.selectedIndex];
                const minAmount = parseFloat(selectedOption.getAttribute("data-min_amount")) || 0;
                const enteredAmount = parseFloat(misAmount.value) || 0;

                if (enteredAmount < minAmount) {
                    e.preventDefault(); // ❌ stop form submit
                    errorMsg.textContent = `Amount should be greater than or equal to ${minAmount}`;
                    errorMsg.classList.remove("hidden");
                    misAmount.focus();
                } else {
                    errorMsg.classList.add("hidden");
                }
            });

            // Optional: live validation on input
            misAmount.addEventListener("input", function() {
                const selectedOption = fdScheme.options[fdScheme.selectedIndex];
                const minAmount = parseFloat(selectedOption.getAttribute("data-min_amount")) || 0;
                const enteredAmount = parseFloat(misAmount.value) || 0;

                if (enteredAmount < minAmount) {
                    errorMsg.textContent = `Amount should be greater than or equal to ${minAmount}`;
                    errorMsg.classList.remove("hidden");
                } else {
                    errorMsg.classList.add("hidden");
                }
            });
        });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const radios = document.querySelectorAll('input[name="fee_mode"]');
        const bankDropdownWrapper = document.getElementById("bankDropdownWrapper");
        const onlineFields = document.getElementById("onlineFields");

        radios.forEach(radio => {
            radio.addEventListener("change", () => {
                bankDropdownWrapper.classList.add("hidden");
                onlineFields.classList.add("hidden");

                if (radio.value === "cheque" && radio.checked) {
                    bankDropdownWrapper.classList.remove("hidden");
                }
                if (radio.value === "online" && radio.checked) {
                    onlineFields.classList.remove("hidden");
                }
            });
        });

            // ---- FIX: Set default date as d-m-Y ----
            function getDMY() {
                const d = new Date();
                let day = String(d.getDate()).padStart(2, '0');
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let year = d.getFullYear();
                return `${day}-${month}-${year}`;
            }

            const chequeDateInput = document.getElementById("cheque_date");
            if (chequeDateInput && !chequeDateInput.value) {
                chequeDateInput.value = getDMY();
            }

            const transferDateInput = document.getElementById("transfer_date");
            if (transferDateInput && !transferDateInput.value) {
                transferDateInput.value = getDMY();
            }

        });
</script>
@endsection