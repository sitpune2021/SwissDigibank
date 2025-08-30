@extends('layout.main')

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
</style>

@section('content')


<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-center flex-col  gap-2">
            <h1 class="text-xl font-semibold">New RD/ DD Scheme</h1>
            <p class="text-gray-500">
                <a href="{{route('rdschemes.index')}}" class="text-gray-500">RD/ DD Scheme</a> >
                <a href="" class="text-gray-500"> Edit</a>
            </p>

        </div>

    </div>

    <div class="col-span-12 box lg:col-span-12">
        @if(session('success'))
        <div class="text-primary">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="text-error">{{ session('error') }}</div>
        @endif

        <form class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6" action="{{ route('rdschemes.update', $scheme->id) }}"
            method="POST">

            @csrf
            @method('PUT')
            <div class="col-span-2 md:col-span-1">
                <label for="scheme_name" class="md:text-lg font-medium block mb-4">
                    Scheme Name
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="" name="scheme_name" value="{{ old('scheme_name', $scheme->scheme_name) }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Scheme Name " disabled>
                @error('scheme_name')
                <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="scheme_code" class="md:text-lg font-medium block mb-4">
                    Scheme Code
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" name="scheme_code" value="{{ old('scheme_name', $scheme->scheme_code) }}" class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                                                      rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase"
                    placeholder="Enter Scheme Code" disabled>
                @error('scheme_code') <span class="text-red-500">{{ $message }}</span> @enderror

            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="min_rd_dd_amount" class="md:text-lg font-medium block mb-4">
                    Min. RD/ DD Amount
                    <span class="text-red-500">*</span>
                </label>

                <input type="number" id="" name="min_rd_dd_amount"
                    value="{{ old('scheme_name', $scheme->min_rd_dd_amount) }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Min Opening Amount">
                @error('min_rd_dd_amount') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="rd_dd_frequency" class="md:text-lg font-medium block mb-4">
                    RD/ DD Frequency
                    <span class="text-red-500">*</span>
                </label>

                <select id="rd_dd_frequency" name="rd_dd_frequency"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select frequency</option>
                    <option value="daily" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'daily' ? 'selected' :
                        '' }}>
                        DAILY
                    </option>
                    <option value="weekly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'weekly' ? 'selected'
                        : '' }}>
                        WEEKLY
                    </option>
                    <option value="bi_weekly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'bi_weekly' ?
                        'selected' : '' }}>
                        BI_WEEKLY
                    </option>
                    <option value="monthly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'monthly' ?
                        'selected' : '' }}>
                        MONTHLY
                    </option>
                    <option value="quarterly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'quarterly' ?
                        'selected' : '' }}>
                        QUARTERLY
                    </option>
                    <option value="half_yearly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'half_yearly' ?
                        'selected' : '' }}>
                        HALF_YEARLY
                    </option>
                    <option value="yearly" {{ old('rd_dd_frequency', $scheme->rd_dd_frequency) == 'yearly' ? 'selected'
                        : '' }}>
                        YEARLY
                    </option>
                </select>

                @error('rd_dd_frequency') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="anuual_interest_rate" class="md:text-lg font-medium block mb-4">
                    Anuual Interest Rate(%)
                    <span class="text-red-500">*</span>
                </label>

                <input type="number" id="interes-rate" name="anuual_interest_rate"
                    value="{{ old('scheme_name', $scheme->anuual_interest_rate) }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Anuual Interest Rate(%) ">
                @error('anuual_interest_rate') <span class="text-error">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="sr_citizen_add_on_interest_rate" class="md:text-lg font-medium block mb-4">
                    Sr. Citizen Add-on Interest Rate (%)
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="sr-citizen-interest-rate" name="sr_citizen_add_on_interest_rate"
                    value="{{ old('scheme_name', $scheme->sr_citizen_add_on_interest_rate) }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0.0">
                @error('sr_citizen_add_on_interest_rate') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="bonus_rate_type" class="md:text-lg font-medium block mb-4">
                    Bonus Rate
                    <span class="text-red-500">*</span>
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">

                        <!-- Left Select -->
                        <select name="bonus_rate_type" id="bonus-rate-type round-10"
                            class="w-24 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">
                            <option value="percentage" {{ old('bonus_rate_type', $scheme->bonus_rate_type) ==
                                'percentage' ? 'selected' : '' }}>%</option>
                            <option value="fixed" {{ old('bonus_rate_type', $scheme->bonus_rate_type) == 'fixed' ?
                                'selected' : '' }}>FIXED</option>
                        </select>

                        <!-- Main Input -->
                        <input type="number" id="bonus-rate" name="bonus_rate_value"
                            value="{{ old('scheme_name', $scheme->bonus_rate_value) }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="0.0">


                        <!-- Info Toggle 
                                                                <button type="button" onclick="alert('This is your bonus rate information')"
                                                                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                                                                    <i class="las la-info-circle text-lg text-gray-500"></i>
                                                                </button> -->

                    </div>
                    @error('bonus_rate_value') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="interest_compounding_interval" class="md:text-lg font-medium block mb-4">
                    Interest Compounding Interval
                    <span class="text-red-500">*</span>
                </label>

                <select id="frequency" name="interest_compounding_interval"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select frequency</option>
                    <option value="monthly" {{ old('interest_compounding_interval', $scheme->
                        interest_compounding_interval) == 'monthly' ? 'selected' : '' }}>MONTHLY</option>
                    <option value="quarterly" {{ old('interest_compounding_interval', $scheme->
                        interest_compounding_interval) == 'quarterly' ? 'selected' : '' }}>QUARTERLY</option>
                    <option value="half_yearly" {{ old('interest_compounding_interval', $scheme->
                        interest_compounding_interval) == 'half_yearly' ? 'selected' : '' }}>HALF_YEARLY</option>
                    <option value="yearly" {{ old('interest_compounding_interval', $scheme->
                        interest_compounding_interval) == 'yearly' ? 'selected' : '' }}>YEARLY</option>
                </select>

                @error('interest_compounding_interval') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>


            <div class="col-span-2 md:col-span-1">
                <label for="rd_dd_lock_in_period" class="md:text-lg font-medium block mb-4">
                    RD/ DD Lock In Period <span class="text-red-500">*</span>
                </label>

                <select id="rd-dd-lock-in-period" name="rd_dd_lock_in_period"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select RD/ DD Lock In Period</option>

                    @foreach ([0, 3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 60] as $months)
                    <option value="{{ $months }}" {{ old('rd_dd_lock_in_period', $scheme->rd_dd_lock_in_period) ==
                        $months ? 'selected' : '' }}>
                        {{ $months }} months
                    </option>
                    @endforeach
                </select>

                @error('rd_dd_lock_in_period') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="interest_lock_in_period" class="md:text-lg font-medium block mb-4">
                    Interest Lock In Period <span class="text-red-500">*</span>
                </label>

                <select id="interest-lock-in-period" name="interest_lock_in_period"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Interest Lock In Period</option>

                    @foreach ([0, 3, 6, 9, 12, 15, 18, 21, 24, 27, 30, 33, 36, 39, 42, 45, 48, 51, 54, 57, 60] as $months)
                    <option value="{{ $months }}" {{ old('interest_lock_in_period', $scheme->interest_lock_in_period) ==
                        $months ? 'selected' : '' }}>
                        {{ $months }} months
                    </option>
                    @endforeach
                </select>

                @error('interest_lock_in_period') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="tenure_of_rd_dd_type" class="md:text-lg font-medium block mb-4">
                    Tenure of RD/ DD
                    <span class="text-red-500">*</span>
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">
                        <select name="tenure_of_rd_dd_type" id="tenure-type"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                            <option value="days" {{ old('tenure_of_rd_dd_type', $scheme->tenure_of_rd_dd_type ?? '') ==
                                'days' ? 'selected' : '' }}>DAYS</option>
                            <option value="weeks" {{ old('tenure_of_rd_dd_type', $scheme->tenure_of_rd_dd_type ?? '') ==
                                'weeks' ? 'selected' : '' }}>WEEKS</option>
                            <option value="months" {{ old('tenure_of_rd_dd_type', $scheme->tenure_of_rd_dd_type ?? '')
                                == 'months' ? 'selected' : '' }}>MONTHS</option>
                        </select>


                        <input type="number" id="tenure" name="tenure_of_rd_dd_value"
                            value="{{ old('scheme_name', $scheme->tenure_of_rd_dd_value) }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Tenure of RD/ DD">


                        <!-- 
                                                                <button type="button" onclick="alert('This is your bonus rate information')"
                                                                    class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                                                                    <i class="las la-info-circle text-lg text-gray-500"></i>
                                                                </button> -->
                    </div>
                    @error('tenure_of_rd_dd_value') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-span-2">
                <p name="tenure-info" class="text-blue-500"><strong>10.0 % TDS</strong> will be deducted, if the
                    Interest exceeds ₹ 40,000.00 per annum.</p>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="cancellation_charges_type" class="md:text-lg font-medium block mb-4">
                    Cancellation Charges
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">
                        <select name="cancellation_charges_type" id="cancellation-charges-type"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                            <option value="percentage" {{ old('cancellation_charges_type', $scheme->
                                cancellation_charges_type ?? '') == 'percentage' ? 'selected' : '' }}>%</option>
                            <option value="fixed" {{ old('cancellation_charges_type', $scheme->cancellation_charges_type
                                ?? '') == 'fixed' ? 'selected' : '' }}>FIXED</option>
                        </select>


                        <input type="number" id="cancellation-charges" name="cancellation_charges_value"
                            value="{{ old('scheme_name', $scheme->cancellation_charges_value) }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Cancellation Charges">


                        <!-- <button type="button" onclick="alert('This is your bonus rate information')"
                                                                            class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 p-2 hover:bg-primary/10">
                                                                            <i class="las la-info-circle text-lg text-gray-500"></i>
                                                                        </button> -->
                    </div>
                    @error('cancellation_charges_value') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="stationary_charges" class="md:text-lg font-medium block mb-4">
                    Stationary Charges
                </label>

                <input type="number" id="Stationary-charges" name="stationary_charges"
                    value="{{ old('scheme_name', $scheme->stationary_charges) }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0.0">
                @error('stationary_charges') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="penalty_charges" class="md:text-lg font-medium block mb-4">
                    Penalty Charges
                </label>
                <div class="col-sm-7">
                    <div class="flex items-center gap-2">
                        <select name="penalty_charges_type" id="penalty_charges_type"
                            class="w-20 text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-6 py-3 md:py-3">

                            <option value="percentage" {{ old('penalty_charges_type', $scheme->penalty_charges_type ??
                                '') == 'percentage' ? 'selected' : '' }}>%</option>
                            <option value="fixed" {{ old('penalty_charges_type', $scheme->penalty_charges_type ?? '') ==
                                'fixed' ? 'selected' : '' }}>FIXED</option>
                        </select>


                        <input type="number" id="penalty_charges_value" name="penalty_charges_value"
                            value="{{ old('scheme_name', $scheme->penalty_charges_value) }}"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                            placeholder="Enter Penalty Charges">

                    </div>
                    @error('penalty_charges_value') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="penal_charges" class="md:text-lg font-medium block mb-4">
                    Penal Charges (%)
                    <span class="text-red-500">*</span>
                </label>
                <select id="penal_charges" name="penal_charges"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="0.0" {{ old('penal_charges', $scheme->penal_charges ?? '') == '0.0' ? 'selected' : ''
                        }}>0.0%</option>
                    <option value="0.5" {{ old('penal_charges', $scheme->penal_charges ?? '') == '0.5' ? 'selected' : ''
                        }}>0.5%</option>
                    <option value="1" {{ old('penal_charges', $scheme->penal_charges ?? '') == '1' ? 'selected' : ''
                        }}>1%</option>
                    <option value="1.5" {{ old('penal_charges', $scheme->penal_charges ?? '') == '1.5' ? 'selected' : ''
                        }}>1.5%</option>
                    <option value="2" {{ old('penal_charges', $scheme->penal_charges ?? '') == '2' ? 'selected' : ''
                        }}>2%</option>
                    <option value="3" {{ old('penal_charges', $scheme->penal_charges ?? '') == '3' ? 'selected' : ''
                        }}>3%</option>
                    <option value="4" {{ old('penal_charges', $scheme->penal_charges ?? '') == '4' ? 'selected' : ''
                        }}>4%</option>
                    <option value="5" {{ old('penal_charges', $scheme->penal_charges ?? '') == '5' ? 'selected' : ''
                        }}>5%</option>
                </select>

                @error('penal_charges') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="app_type" class="md:text-lg font-medium block mb-4">
                    App Type
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row pt-3 mt-5 gap-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="app_type_admin" value="1" class="w-6 h-6 accent-green-500" {{
                            old('app_type_admin', $scheme->app_type_admin ?? 0) == 1 ? 'checked' : '' }}>
                        <span>Admin</span>
                    </label>


                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="app_type_associate" value="1" class="w-6 h-6 accent-green-500" {{
                            old('app_type_associate', $scheme->app_type_associate ?? 0) == 1 ? 'checked' : '' }}>
                        <span>Associate</span>
                    </label>


                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="app_type_member" value="1" class="w-6 h-6 accent-green-500" {{
                            old('app_type_member', $scheme->app_type_member ?? 0) == 1 ? 'checked' : '' }}>
                        <span>Member</span>
                    </label>

                </div>
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Active
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="active" value="yes" {{ old('active', $scheme->active ?? '') == 'yes' ?
                        'checked' : '' }}>
                        <span>Yes</span>
                    </label>


                    <label class="flex items-center gap-2">
                        <input type="radio" name="active" value="no" {{ old('active', $scheme->active ?? '') == 'no' ?
                        'checked' : '' }}>
                        <span>No</span>
                    </label>

                </div>
            </div>


            <!-- Buttons -->
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button class="btn-primary uppercase justify-center" type="submit" name="update_scheme">
                    Update Scheme
                </button>

                
                <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{route('rdschemes.index')}}" class=" no-underline ">   BAck</a> 
                </button>
                

            </div>
        </form>
    </div>
</div>
@endsection