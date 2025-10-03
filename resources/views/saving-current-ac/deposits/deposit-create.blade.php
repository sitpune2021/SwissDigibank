@extends('layout.main')

@section('content')

<head>
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
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
    </style>
</head>
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h3 class="h3">DEPOSIT</h3>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Deposit Form: col-7 -->
        <div class="col-span-12 lg:col-span-7">
            <div class="mb-4 box" x-data="{ payMode: '' }">

                <form class="grid grid-cols-2 gap-6" method="POST" action="{{  route('deposit.money', base64_encode($id)) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="col-span-2 md:col-span-1">
                        <label for="pan_no" class="block mb-1 font-semibold text-gray-700 uppercase">Customer's PAN No</label>
                        <div class="px-2 py-1 mt-2 text-sm text-green-700 border border-green-500 rounded w-fit">Yes</div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-1 font-semibold text-gray-700 uppercase">Customer's Sign</label>
                        <div class="p-2 text-sm text-gray-500 border border-yellow-300 rounded bg-yellow-50">
                            No Signature Present<br>(Upload in Customer Documents)
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-1 font-semibold text-gray-700 uppercase">Customer's Photo</label>
                        <div class="p-2 text-sm text-gray-500 border border-yellow-300 rounded bg-yellow-50">
                            No Photo Present<br>(Upload in Customer Documents)
                        </div>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="amount" class="block mb-1 font-semibold text-gray-700 uppercase">Amount to Deposit <span class="text-red-500">*</span></label>
                        <input type="number" id="amount" name="amount"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter Amount">
                    </div>

                    <div class="col-span-2">
                        <label for="remarks" class="block mb-1 font-semibold text-gray-700 uppercase">Remarks (if any)</label>
                        <textarea id="remarks" name="remarks" rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter Remarks"></textarea>
                    </div>

                    <div class="col-span-2 md:col-span-1">

                        <label for="transaction_date" class="md:text-lg font-medium block mb-4 uppercase">Transaction Date <span

                                class="text-red-500">*</span></label>

                        <div class="relative">
                            <input name="transaction_date" id="date2" type="text" placeholder="DD/MM/YYYY"
                                value=""
                                class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" autocomplete="off">
                            <i

                                class="las la-calendar absolute ltr:right-4 rtl:left-4 top-1/2 -translate-y-1/2 cursor-pointer"></i>

                        </div>

                        @error('transaction_date')

                        <span class="text-red-500 text-xs">{{ $message }}</span>

                        @enderror

                    </div>
                    <div class="col-span-2">
                        <label class="block mb-1 font-semibold text-gray-700 uppercase">Pay Mode <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-6 mt-1">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cash" x-model="payMode" class="text-blue-600 focus:ring-blue-500" checked> Cash
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="online" x-model="payMode" class="text-blue-600 focus:ring-blue-500"> Online Tr.
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="pay_mode" value="cheque" x-model="payMode" class="text-blue-600 focus:ring-blue-500"> Cheque
                            </label>
                        </div>
                    </div>

                    <!-- Online Transfer Fields -->
                    <div class="grid grid-cols-2 col-span-2 gap-6 p-4 border rounded-lg bg-blue-50" x-show="payMode === 'online'">
                        <div>
                            <!-- <label class="block mb-1 font-semibold text-gray-700">Transfer Date <span class="text-red-500">*</span></label> -->
                            <!-- <input type="text" name="transfer_date" id="date2"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"> -->

                            <div class="col-span-2 md:col-span-1">
                                <x-datepicker-disabled
                                    label="TRANSFER DATE"
                                    name="transfer_date"
                                    value="{{ old('transfer_date') }}"
                                    inputId="transfer_date" />
                            </div>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700 uppercase">UTR/ Transaction No <span class="text-red-500">*</span></label>
                            <input type="text" name="utr_no"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @error('utr_no')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-1 font-semibold text-gray-700 uppercase">Transfer Mode <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="imps" class="text-blue-600"> IMPS
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="vpa" class="text-blue-600"> VPA
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="transfer_mode" value="neft" class="text-blue-600"> NEFT/RTGS
                                </label>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <label class="block mb-1 font-semibold text-gray-700 uppercase">Credited in Account <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="1" class="text-blue-600"> Yes
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="credited" value="0" class="text-blue-600"> No
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Cheque Fields -->
                    <div class="grid grid-cols-2 col-span-2 gap-6 p-4 border rounded-lg bg-green-50" x-show="payMode === 'cheque'">
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700 uppercase">Bank Name <span class="text-red-500">*</span></label>

                            <!-- <select name="bank_name"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Select Bank</option>
                                <option value="SBI">State Bank of India (SBI)</option>
                                <option value="HDFC">HDFC Bank</option>
                                <option value="ICICI">ICICI Bank</option>
                                <option value="BOB">Bank of Baroda</option>
                                <option value="PNB">Punjab National Bank</option>
                            </select> -->

                            <x-searchable-dropdown
                                :items="$banks"
                                label="Select Bank"
                                name="bank_name"
                                display-field="name"
                                value-field="id"
                                event="Bank-selected"
                                :selected="null" />

                        </div>

                        <div>
                            <label class="block mb-1 font-semibold text-gray-700 uppercase">Cheque Number <span class="text-red-500">*</span></label>
                            <input type="text" name="cheque_number" placeholder="Enter Cheque No"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('cheque_number')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <!-- <label class="block mb-1 font-semibold text-gray-700">Cheque Date <span class="text-red-500">*</span></label>
                            <input type="date2" name="cheque_date"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"> -->
                            <div class="col-span-2 md:col-span-1">
                                <x-datepicker-disabled
                                    label="CHEQUE DATE"
                                    name="cheque_date"
                                    value="{{ old('cheque_date') }}"
                                    inputId="cheque_date" />
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit" class="btn-primary">Deposit</button>
                        <button type="button" class="btn-outline"
                            onclick="window.location.href='{{ route('accounts.show', base64_encode($id)) }}'">
                            Back
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-span-12 lg:col-span-5" x-data="{ open: false }">

            <div class="overflow-hidden border border-green-600 rounded-lg">

                <!-- Full background header (click to toggle) -->
                <div style="background-color:#20b757; color:#fff;"
                    class="flex items-center justify-between px-4 py-3 font-bold text-white cursor-pointer"
                    @click="open = !open">
                    <span class="uppercase">Saving Account Info</span>
                    <span x-text="open ? '-' : '+'"
                        class="text-lg font-bold"></span>
                </div>

                <!-- Content -->
                <div x-show="open" x-transition class="p-4 text-sm bg-white">
                    <ul class="space-y-2">
                        <li class="flex justify-between"><strong class="uppercase">Customer:</strong><span>{{ $member->accounts->members->member_no 
    ?? ($member->accounts->members->id ? str_pad($member->accounts->members->id, 6, '0', STR_PAD_LEFT) : 'NA') }}-{{ $member->accounts->members->member_info_first_name ?? "NA"}}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">PAN No.:</strong><span>{{$member->accounts->members?->kyc?->member_kyc_pan_no??'NA'}}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">Account No.:</strong><span>{{$member->accounts?->account_no??'NA'}}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">Scheme:</strong><span>{{$member->accounts->scheme->scheme_name}}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">Open Date:</strong><span>{{ $member->accounts?->open_date ? \Carbon\Carbon::parse($member->accounts->open_date)->format('d-m-Y') : 'NA' }}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">Status:</strong><span>Active</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between"><strong class="uppercase">Available Balance (C):</strong><span>{{$member->accounts?->deposit_amount??'NA'}}</span></li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between">
                            <strong class="uppercase">Joint Account:</strong>
                            @if(optional($member->accounts)->account_holder_type === 'joint')
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Yes
                            </span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                No
                            </span>
                            @endif
                        </li>
                        <hr class="my-2 border-gray-300">
                        <li class="flex justify-between">
                            <strong class="uppercase">Special Account:</strong>
                            @if(optional($member->accounts)->special_account === 'yes')
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                Yes
                            </span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                No
                            </span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection