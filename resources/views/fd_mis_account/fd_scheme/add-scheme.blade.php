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

    .tableWidth {
        width: 90%;
        margin: auto;

    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-center flex-col  gap-2">
            <h1 class="text-xl font-semibold">New FD Account Scheme</h1>
            <!-- <p class="text-gray-500">
                <a href="#" class="text-gray-500">Fd Scheme</a> >
                <a href="#" class="text-gray-500"> New</a>
            </p> -->
        </div>
    </div>

    <div class="col-span-12 box lg:col-span-12">
        <form method="POST" action="{{ route('fd-mis-schemes.store') }}" class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
            @csrf
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Scheme Name
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="scheme_name" name="scheme_name"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Scheme Name " value="">
                @error('scheme_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Scheme Code
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" id="scheme_code" name="scheme_code"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Scheme Code" value="">

                @error('scheme_code')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="city" class="md:text-lg font-medium block mb-4">
                    Min. FD/ MIS Amount
                    <span class="text-red-500">*</span>
                </label>

                <input type="number" id="min_amount" name="min_amount"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Minimum FD Amount" value="">
                @error('min_amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    FD/ MIS Lock In Period
                    <span class="text-red-500">*</span>
                </label>
                <select name="lock_in_period" id="lock_in_period"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="0">0 months</option>
                    <option value="1">1 month</option>
                    <option value="3" selected>3 months</option>
                    <option value="6">6 months</option>
                    <option value="9">9 months</option>
                    <option value="12">12 months</option>
                    <option value="15">15 months</option>
                    <option value="18">18 months</option>
                    <option value="21">21 months</option>
                    <option value="24">24 months</option>
                    <option value="25">25 Months</option>
                    <option value="27">27 Months</option>
                    <option value="30">30 months</option>
                    <option value="33">33 Months</option>
                    <option value="36">36 months</option>
                    <option value="39">39 Months</option>
                    <option value="42">42 Months</option>
                    <option value="45">45 Months</option>
                    <option value="48">48 months</option>
                    <option value="51">51 Months</option>
                    <option value="54">54 Months</option>
                    <option value="57">57 Months</option>
                    <option value="60">60 months</option>
                </select>
                @error('lock_in_period')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="pincode" class="md:text-lg font-medium block mb-4">
                    Interest Lock In Period
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-1 ">
                    <select name="interest_lock_in" id="interest_lock_in"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="0">0 months</option>
                        <option value="3">3 months</option>
                        <option selected="selected" value="6">6 months</option>
                        <option value="9">9 months</option>
                        <option value="12">12 Months</option>
                        <option value="15">15 Months</option>
                        <option value="16">16 Months</option>
                        <option value="18">18 Months</option>
                        <option value="21">21 Months</option>
                        <option value="24">24 Months</option>
                        <option value="25">25 Months</option>
                        <option value="27">27 Months</option>
                        <option value="30">30 Months</option>
                        <option value="33">33 Months</option>
                        <option value="36">36 Months</option>
                        <option value="39">39 Months</option>
                        <option value="42">42 Months</option>
                        <option value="45">45 Months</option>
                        <option value="48">48 Months</option>
                        <option value="51">51 Months</option>
                        <option value="54">54 Months</option>
                        <option value="57">57 Months</option>
                        <option value="60">60 Months</option>
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
                <label for="" class="md:text-lg font-medium block mb-4">
                    Bonus Rate
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-2">
                    <select name="bonus_type" id="bonus_type"
                        class=" text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">(%)</option>
                        <option value="" class="uppercase">fixed</option>
                    </select>
                    <input type="number" id="bonus_rate" name="bonus_rate"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0">
                    @error('bonus_rate')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="" class="md:text-lg font-medium block mb-4">
                    Cancellation Charges (if any)
                </label>
                <div class="flex gap-2">
                    <select name="cancellation_type" id="cancellation_type"
                        class=" text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">(%)</option>
                        <option value="" class="uppercase">fixed</option>
                    </select>
                    <input type="number" id="" name="cancellation_charge"
                        class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="0.0">
                </div>

            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    Penal Charges (%)
                </label>

                <select name="penal_charge" id="penal_charge"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    <option value="">0.0%</option>
                </select>
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    Effective Date
                    <span class="text-red-500">*</span>
                </label>
                <input type="text" id="date2" name="effective_date" value="{{ date('D M d Y') }}"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    Stationary Fee
                </label>
                <input type="number" id="stationary_fee" name="stationary_fee"
                    class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="0.0">
            </div>
            <div class="col-span-2 md:col-span-1">
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    App Type
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row pt-3 mt-5 gap-6">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="admin" class="w-6 h-6 accent-green-500" checked>
                        <span>Admin</span>
                    </label>

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
                <label for="contact_email" class="md:text-lg font-medium block mb-4">
                    Active
                    <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2">
                        <input type="radio" name="active" value="1">
                        <span>Yes</span>
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="radio" name="active" value="0" checked>
                        <span>No</span>
                    </label>
                </div>
            </div>
            <div class="col-span-2 mt-8">
                <div class="tableWidth mt-8 px-4">
                    <div class="overflow-x-auto">
                        <table class="">
                            <thead class="bg-green-500  text-white">
                                <tr>
                                    <th colspan="2" class="text-center py-3 ">DAYS</th>
                                    <th rowspan="2" class="text-center">ANNUAL INTEREST <br> RATE (%)</th>
                                    <th rowspan="2" class="text-center py-3  w-[15%]">
                                        SR CTZN INTEREST <br> RATE (%)
                                        <strong class="text-black cursor-pointer"
                                            title="In the case of SR. Citizen, Total Interest will be (INTEREST RATE + SR CTZN INTEREST RATE)">
                                            <i class="fa fa-info-circle fa-lg"></i>
                                        </strong>
                                    </th>
                                    <th rowspan="2" class="text-center py-3 ">INTEREST PAYOUT TYPE</th>
                                </tr>
                                <tr class="">
                                    <th class="text-center ">FROM</th>
                                    <th class="text-center  ">TO</th>
                                </tr>
                            </thead>


                            <tbody>
                                @for ($i = 0; $i < 10; $i++)
                                    <tr>
                                    <td class="border border-gray-300 p-1">
                                        <input type="number" min="0" step="0" class="w-full border border-gray-300 rounded p-1">
                                    </td>
                                    <td class="border border-gray-300 p-1">
                                        <input type="number" min="0" step="0" class="w-full border border-gray-300 rounded p-1">
                                    </td>
                                    <td class="border border-gray-300 p-1">
                                        <input type="number" min="0" step="0.01" class="w-full border border-gray-300 rounded p-1">
                                    </td>
                                    <td class="border border-gray-300 p-1">
                                        <input type="number" min="0" step="0.01" class="w-full border border-gray-300 rounded p-1">
                                    </td>
                                    <td class="border border-gray-300 p-1">
                                        <select class="w-full border border-gray-300 rounded p-1">
                                            <option value="">Select Interest Payout</option>
                                            <option value="Cumulative Yearly">Cumulative Yearly</option>
                                            <option value="Cumulative Half Yearly">Cumulative Half Yearly</option>
                                            <option value="Cumulative Monthly">Cumulative Monthly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
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
                <button type="submit"
                    class="bg-green-500 p-2 border border-green-500 text-white uppercase rounded  sm:w-auto">
                    SAVE SCHEME
                </button>

                <button type="submit"
                    class="bg-red-500 p-2 border border-red-500 text-white uppercase rounded  sm:w-auto">
                    Cancel
                </button>

                <button type="submit"
                    class="bg-yellow p-2 border text-white uppercase rounded sm:w-auto">
                    Reset
                </button>
            </div>
        </form>
    </div>
    @endsection