@extends('layout.main')
@section('content')
    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
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
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-col  gap-2">
                <h1 class="text-xl font-semibold">
                    {{ isset($fdScheme) ? 'EDIT FD SCHEME' : 'ADD FD SCHEME' }}
                </h1>
                <!-- <p class="text-gray-500">
                        <a href="#" class="text-gray-500">Fd Scheme</a> >
                        <a href="#" class="text-gray-500"> New</a>
                    </p> -->
            </div>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form method="POST"
                action="{{ isset($fdScheme) ? route('fd-mis-schemes.update', $fdScheme->id) : route('fd-mis-schemes.store') }}"
                class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                @csrf
                @if (isset($fdScheme))
                    @method('PUT')
                @endif
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                        Scheme Name
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="scheme_name" name="scheme_name"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Scheme Name " value="{{ old('scheme_name', $fdScheme->scheme_name ?? '') }}">
                    @error('scheme_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                        Scheme Code
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" id="scheme_code" name="scheme_code"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Scheme Code" value="{{ old('scheme_code', $fdScheme->scheme_code ?? '') }}">

                    @error('scheme_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="city" class="md:text-lg font-medium block mb-4 uppercase">
                        Min. FD/ MIS Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" id="min_amount" name="min_amount"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Minimum FD Amount" value="{{ old('min_amount', $fdScheme->min_amount ?? '') }}">

                    <x-number-to-word for="min_amount" />
                    @error('min_amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="" class="md:text-lg font-medium block mb-4 uppercase">
                        FD/ MIS Lock In Period
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="lock_in_period" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        @foreach ([0, 1, 3, 6, 9, 12, 15, 18, 21, 24, 25, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 60] as $month)
                            <option value="{{ $month }}"
                                {{ old('lock_in_period', $fdScheme->lock_in_period ?? '') == $month ? 'selected' : '' }}>
                                {{ $month }} months
                            </option>
                        @endforeach
                    </select>

                    @error('lock_in_period')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="pincode" class="md:text-lg font-medium block mb-4 uppercase">
                        Interest Lock In Period
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-1 ">
                        <select name="interest_lock_in" id="interest_lock_in"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                            @foreach ([0, 3, 6, 9, 12, 15, 16, 18, 21, 24, 25, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 60] as $month)
                                <option value="{{ $month }}"
                                    {{ old('interest_lock_in', $fdScheme->interest_lock_in ?? '') == $month ? 'selected' : '' }}>
                                    {{ $month }} {{ Str::plural('Month', $month) }}
                                </option>
                            @endforeach
                        </select>
                        @error('interest_lock_in')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1 pt-3">
                    <p class="text-blue-500">
                        10.0 % TDS will be deducted, if the Interest exceeds ₹ 40000 per annually.</p>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label for="bonus_rate" class="md:text-lg font-medium block mb-4 uppercase">
                        Bonus Rate
                    </label>
                    <div class="flex gap-2">
                        {{-- Bonus Type --}}
                        <select name="bonus_type" id="bonus_type"
                            class="text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Type</option>
                            <option value="percentage"
                                {{ old('bonus_type', $fdScheme->bonus_type ?? '') == 'percentage' ? 'selected' : '' }}>(%)
                            </option>
                            <option value="fixed"
                                {{ old('bonus_type', $fdScheme->bonus_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed
                            </option>
                        </select>

                        {{-- Bonus Rate --}}
                        <input type="number" id="bonus_rate" name="bonus_rate"
                            value="{{ old('bonus_rate', $fdScheme->bonus_rate ?? '') }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0" step="0.01">
                    </div>

                    {{-- Error Message --}}
                    @error('bonus_rate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="cancellation_type" class="md:text-lg font-medium block mb-4 uppercase">
                        Cancellation Charges (if any)
                    </label>
                    <div class="flex gap-2">
                        <select name="cancellation_type" id="cancellation_type"
                            class="text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="percent"
                                {{ old('cancellation_type', $fdScheme->cancellation_type ?? '') == 'percent' ? 'selected' : '' }}>
                                (%)</option>
                            <option value="fixed"
                                {{ old('cancellation_type', $fdScheme->cancellation_type ?? '') == 'fixed' ? 'selected' : '' }}>
                                Fixed</option>
                        </select>

                        <input type="number" name="cancellation_charge" step="0.01"
                            value="{{ old('cancellation_charge', $fdScheme->cancellation_charge ?? '') }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0">
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="contact_email" class="md:text-lg font-medium block mb-4 uppercase">
                        Penal Charges (%)
                    </label>
                    <select name="penal_charge" id="penal_charge"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">0.0</option>
                        <option value="0.5">0.5%</option>
                        <option value="1">1%</option>
                        <option value="1.5">1.5%</option>
                        <option value="2">2%</option>
                        <option value="3">3%</option>
                        <option value="4">4%</option>
                        <option value="5">5%</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <x-datepicker-disabled label="EFFECTIVE DATE" name="effective_date"
                        value="{{ old('effective_date') }}" inputId="effective_date" />
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="stationary_fee" class="md:text-lg font-medium block mb-4 uppercase">
                        Stationary Fee
                    </label>
                    <input type="number" id="stationary_fee" name="stationary_fee"
                        value="{{ old('stationary_fee', $fdScheme->stationary_fee ?? '0.0') }}"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0">
                    <x-number-to-word for="stationary_fee" />
                </div>
<br>
                <div class="col-span-2 md:col-span-1"> <label for="contact_email"
                        class="md:text-lg font-medium block mb-4 uppercase"> App Type <span class="text-red-500">*</span>
                    </label>
                    <div class="flex flex-row pt-3 mt-5 gap-6"> <label class="flex items-center gap-3">
                            <input type="checkbox" name="admin" class="w-6 h-6 accent-green-500" checked>
                            <span>Admin</span> </label>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="associate" class="w-6 h-6 accent-green-500" checked>
                            <span>Associate</span>
                        </label>
                        <label class="flex items-center gap-3">
                            <input type="checkbox" name="member" class="w-6 h-6 accent-green-500">
                            <span>Member</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="active" class="md:text-lg font-medium block mb-4 uppercase">
                        Active
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="active" value="1"
                                {{ old('active', $item->active ?? 0) == 1 ? 'checked' : '' }}>
                            <span>Yes</span>
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="active" value="0"
                                {{ old('active', $item->active ?? 0) == 0 ? 'checked' : '' }}>
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div class="col-span-2 mt-8">
                    <div class="tableWidth mt-8 px-4">
                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300">
                                <thead class="bg-green-500 text-white">
                                    <tr>
                                        <th colspan="2" class="text-center py-3">DAYS</th>
                                        <th rowspan="2" class="text-center">ANNUAL INTEREST <br> RATE (%)</th>
                                        <th rowspan="2" class="text-center py-3 w-[15%]">
                                            SR CTZN INTEREST <br> RATE (%)
                                            <strong class="text-black cursor-pointer"
                                                title="In the case of SR. Citizen, Total Interest will be (INTEREST RATE + SR CTZN INTEREST RATE)">
                                                <i class="fa fa-info-circle fa-lg"></i>
                                            </strong>
                                        </th>
                                        <th rowspan="2" class="text-center py-3">INTEREST PAYOUT TYPE</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">FROM</th>
                                        <th class="text-center">TO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // if editing, use existing slabs, else make empty rows
                                        $slabs = isset($fdScheme) ? $fdScheme->fdslabs : collect([]);
                                        $rowCount = max(10, $slabs->count());
                                    @endphp

                                    @for ($i = 0; $i < $rowCount; $i++)
                                        @php
                                            $slab = $slabs[$i] ?? null;
                                        @endphp
                                        <tr>
                                            <td class="border border-gray-300 p-1">
                                                <input type="number" name="rows[{{ $i }}][day_from]"
                                                    min="0" step="1"
                                                    class="w-full border border-gray-300 rounded p-1"
                                                    value="{{ old('rows.' . $i . '.day_from', $slab->day_from ?? '') }}">
                                            </td>
                                            <td class="border border-gray-300 p-1">
                                                <input type="number" name="rows[{{ $i }}][day_to]"
                                                    min="0" step="1"
                                                    class="w-full border border-gray-300 rounded p-1"
                                                    value="{{ old('rows.' . $i . '.day_to', $slab->day_to ?? '') }}">
                                            </td>
                                            <td class="border border-gray-300 p-1">
                                                <input type="number" name="rows[{{ $i }}][interest_rate]"
                                                    min="0" step="0.01"
                                                    class="w-full border border-gray-300 rounded p-1"
                                                    value="{{ old('rows.' . $i . '.interest_rate', $slab->interest_rate ?? '') }}">
                                            </td>
                                            <td class="border border-gray-300 p-1">
                                                <input type="number" name="rows[{{ $i }}][sr_citizen_rate]"
                                                    min="0" step="0.01"
                                                    class="w-full border border-gray-300 rounded p-1"
                                                    value="{{ old('rows.' . $i . '.sr_citizen_rate', $slab->sr_citizen_rate ?? '') }}">
                                            </td>
                                            <td class="border border-gray-300 p-1">
                                                <select class="w-full border border-gray-300 rounded p-1"
                                                    name="rows[{{ $i }}][payout_type]">
                                                    <option value="">Select Interest Payout</option>
                                                    <option value="Cumulative Yearly"
                                                        {{ old('rows.' . $i . '.payout_type', $slab->payout_type ?? '') == 'Cumulative Yearly' ? 'selected' : '' }}>
                                                        Cumulative Yearly</option>
                                                    <option value="Cumulative Half Yearly"
                                                        {{ old('rows.' . $i . '.payout_type', $slab->payout_type ?? '') == 'Cumulative Half Yearly' ? 'selected' : '' }}>
                                                        Cumulative Half Yearly</option>
                                                    <option value="Cumulative Monthly"
                                                        {{ old('rows.' . $i . '.payout_type', $slab->payout_type ?? '') == 'Cumulative Monthly' ? 'selected' : '' }}>
                                                        Cumulative Monthly</option>
                                                    <option value="Monthly"
                                                        {{ old('rows.' . $i . '.payout_type', $slab->payout_type ?? '') == 'Monthly' ? 'selected' : '' }}>
                                                        Monthly</option>
                                                    <option value="Quarterly"
                                                        {{ old('rows.' . $i . '.payout_type', $slab->payout_type ?? '') == 'Quarterly' ? 'selected' : '' }}>
                                                        Quarterly</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                    <button type="submit" class="btn-primary uppercase justify-center">
                        SAVE FD SCHEME
                    </button>
                    <button type="reset" class="btn-outline">
                        RESET
                    </button>
                    <a href="{{ route('fd-mis-schemes.index') }}" class="btn-outline uppercase justify-center">
                        CANCEL
                    </a>


                </div>
            </form>
        </div>
    @endsection
