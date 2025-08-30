@extends('layout.main') <style>
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

    .widthleftcol {
        width: 70%;
    }
</style>
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-center flex-col gap-2">
            <h1 class="text-xl font-semibold">{{ $fdScheme->scheme_name}}</h1><small>FD Scheme</small>

        </div>
    </div>
    <div class="flex flex-col lg:flex-row w-full gap-6">
        <div class="lg:w-[70%] w-full bg-white dark:bg-bg3 p-4 rounded-lg shadow">
            <div class="text-end"> <a href="#" class=" p-2 btn-outline">
                    <i class="las la-pen"></i>

                </a> </div>
            <div class="mt-7 overflow-x-auto">
                <table class="w-full table-auto text-sm text-gray-700">
                    <tbody>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2 w-1/2">Scheme Code</td>
                            <td class="px-4 py-2">{{ $fdScheme->scheme_code}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Scheme Name</td>
                            <td class="px-4 py-2">{{ $fdScheme->scheme_name}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Min. Amount</td>
                            <td class="px-4 py-2">{{ $fdScheme->min_amount}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">FD Lock in Period</td>
                            <td class="px-4 py-2">{{ $fdScheme->lock_in_period}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Effective / Start Date</td>
                            <td class="px-4 py-2">{{ $fdScheme->effective_date}}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Bonus Rate</td>
                            <td class="px-4 py-2">{{ $fdScheme->bonus_rate}} %</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Cancellation Charges</td>
                            <td class="px-4 py-2">{{ $fdScheme->cancellation_charge	}} ₹</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Penal Charges (%)</td>
                            <td class="px-4 py-2">{{ $fdScheme->penal_charge }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Stationery Charges</td>
                            <td class="px-4 py-2">{{ $fdScheme->stationary_fee }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Interest Lock in Period</td>
                            <td class="px-4 py-2"> {{ $slab->months ?? '0' }} Months</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Active</td>
                            <td class="px-4 py-2">
                                @if($fdScheme->is_active==1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                    Yes
                                </span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                    No
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Sweep In Scheme</td>
                            <td class="px-4 py-2">
                                @if($fdScheme->is_active==1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                    Yes
                                </span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">No</span>
                                @endif
                            </td>

                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Created at</td>
                            <td class="px-4 py-2">{{ optional($fdScheme->created_at)->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Updated at</td>
                            <td class="px-4 py-2">{{ optional($fdScheme->updated_at)->format('d-m-Y') }}</td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Admin Type Scheme</td>
                            <td class="px-4 py-2">
                                @if($fdScheme->admin==1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">Yes</span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr class="border-b">
                            <td class="font-bold px-4 py-2">Agent Type Scheme</td>
                            <td class="px-4 py-2">
                                @if($fdScheme->associate==1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">Yes</span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">No</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold px-4 py-2">Member Type Scheme</td>
                            <td class="px-4 py-2">
                                @if($fdScheme->member==1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">Yes</span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-warning/10 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">No</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Right Column -->
        <div class="lg:w-[30%] w-full flex flex-col gap-6">
            <div class="bg-white p-4 dark:bg-bg3 rounded-lg shadow">
                <table class="w-full text-sm text-black">
                    <tbody>
                        <tr class="border-b">
                            <td class="font-bold text-center px-4 py-2">Current Chart</td>
                            <td class="px-4 py-2">none</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-center px-4 py-2">Commission Chart</td>
                            <td class="px-4 py-2">
                                <form class="flex flex-col sm:flex-row gap-2" action="#" method="post"> <select
                                        class="w-full bg-secondary/5 border border-green-500 rounded-10 px-3 py-3 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <option>Select Chart</option>
                                        <option>FD COMISSION CHART (Tenure - 6 M)</option>
                                        <option>FIXED DEPOSIT (Tenure - 6 M)</option>
                                        <option>6 MONTH (Tenure - 1 M)</option>
                                        <option>AK (Tenure - 1 M)</option>
                                        <option>BUDH TESTING (Tenure - 1 M)</option>
                                        <option>Manikaran Commision Chart (Tenure - 6 M)</option>
                                        <option>Ultima 10 (Tenure - 60 M)</option>
                                        <option>FD 6 MONTH (Tenure - 6 M)</option>
                                    </select>
                                    <button type="submit"
                                        class="btn-primary justify-center">
                                        UPDATE </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-3 dark:bg-bg3 rounded-lg overflow-hidden shadow">
                <div class="px-4 py-4">
                    <h3 class="text-black font-bold text-lg">INTEREST CHART</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-primary text-black">
                            <tr>
                                <th class="px-4 py-2 text-center " colspan="2">DAYS</th>
                                <th rowspan="2" class="px-4 py-2 text-center ">ANNUAL INTEREST<br>RATE (%)</th>
                                <th rowspan="2" class="px-4 py-2 text-center ">SR CTZN INTEREST<br>RATE (%)</th>
                                <th rowspan="2" class="px-4 py-2 text-center ">INTEREST PAYOUT TYPE</th>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 text-center bg-primary rounded-none" style="border-radius:0px;">FROM</th>
                                <th class="px-4 py-2 text-center bg-primary rounded-none" style="border-radius:0px;">TO</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($fdScheme->fdslabs as $slab)
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $slab->day_from }}</td>
                                <td class="px-4 py-2 border-b">{{ $slab->day_to }}</td>
                                <td class="px-4 py-2 border-b">{{ number_format($slab->interest_rate, 2) }} %</td>
                                <td class="px-4 py-2 border-b">{{ number_format($slab->sr_citizen_rate, 2) }} %</td>
                                <td class="px-4 py-2 border-b">
                                    <ul>
                                        @foreach(explode(',', $slab->payout_type) as $payout)
                                        <li>{{ strtoupper(trim($payout)) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="box mt-3 dark:bg-bg3 shadow-md rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between rounded-10 px-4 py-3 border-b bg-secondary/5 text-black">
            <h3 class="text-lg font-semibold">FD ACCOUNT SETTING AUDIT TRAIL</h3>

        </div>

        <!-- Body -->
        <div class="w-full p-4">
            <div class="w-full overflow-x-auto">
                <table class="w-full min-w-[600px]   text-sm md:text-base">
                    <thead class="bg-gray-100 text-start text-gray-700">
                        <tr>
                            <th class="px-4 py-2  border-b whitespace-nowrap">Creator</th>
                            <th class="px-4 py-2  border-b whitespace-nowrap">Event</th>
                            <th class="px-4 py-2  border-b whitespace-nowrap">Create On</th>
                            <th class="px-4 py-2  border-b whitespace-nowrap">Change Logs</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        <!-- Add more rows here -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection