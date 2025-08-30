@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <h2 class="text-xl font-semibold mb-4">
            GUARANTEED MONTHLY DEPOSIT SCHEME FOR GENERAL & SR CITIZEN - 5YRS PERIOD (LESS THAN 3 CRORES)
        </h2>
        <p class="text-sm text-gray-500 mb-6">
            <a href="{{route('rdschemes.index')}}">RD/ DD Scheme</a> &gt; GUARANTEED MONTHLY DEPOSIT SCHEME...
        </p>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <!-- Left Section -->
                <div class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
                    <div class="text-end ">
                        <a href="{{ route('rdschemes.edit', $scheme->id) }}" class=" p-2 btn-outline">
                            <i class="las la-pen"></i>
                        </a>
                    </div>
                    <table class="min-w-full border-separate border-spacing-y-2">
                        <tbody>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Scheme Code</td>
                                <td class="text-gray-700 px-4 py-2 border-b uppercase">{{ $scheme->scheme_code??'NA' }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Scheme Name</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->scheme_name ??'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Deposit Frequency</td>
                                <td class="text-gray-700 px-4 py-2 border-b">{{ $scheme->rd_dd_frequency??'NA' }}</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Min. Amount</td>
                                <td class="text-gray-700 px-4 py-2 border-b">{{ $scheme->min_rd_dd_amount ??'NA'}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Minimum Lock in Period</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->rd_dd_lock_in_period??'NA' }} months
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Interest (%)</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->anuual_interest_rate ??'NA'}}%
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Senior Citizen Add-on Interest Rate (%)</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->sr_citizen_add_on_interest_rate??'NA' }} %
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Interest Compounding</td>
                                <td class="text-gray-700 px-4 py-2 border-b uppercase">
                                    {{ $scheme->interest_compounding_interval??'NA' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Interest Lock in Period</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->interest_lock_in_period ?? 0}} Months

                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Tenure of RD</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->tenure_of_rd_dd_value }}
                                    {{ $scheme->tenure_of_rd_dd_type }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Cancellation Charges</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->cancellation_charges_value }}
                                    {{ $scheme->cancellation_charges_type === 'percentage' ? '%' : 'fixed'}}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Penal Charges (%)</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->penal_charges ??0}}%
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Stationery Charges</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->stationary_charges ??'NA'}}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Bonus Rate</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->bonus_rate_value }}
                                    {{ $scheme->bonus_rate_type === 'percentage' ? '%' : 'fixed'}}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Penalty Charges (After Grace Period)</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->penalty_charges_value }}
                                    {{ $scheme->penalty_charges_type === 'percentage' ? '%' : 'fixed'}}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Active</td>
                                <td class="px-4 py-2 border-b">
                                    <span class="px-3 py-1 text-xs font-semibold text-white rounded-full capitalize 
                                 {{ $scheme->active === 'yes' ? 'bg-green-500' : 'bg-red-500' }}">
                                        {{ $scheme->active }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Created at</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->created_at }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Updated at</td>
                                <td class="text-gray-700 px-4 py-2 border-b">
                                    {{ $scheme->updated_at }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Admin Type Scheme</td>
                                <td class="px-4 py-2 border-b">
                                    <span class="px-3 py-1 text-xs font-semibold text-white  rounded-full  {{ $scheme->app_type_admin === '1' ? 'bg-primary' : 'bg-red-500' }}">
                                        {{ $scheme->app_type_admin  === '1' ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Agent Type Scheme</td>
                                <td class="px-4 py-2 border-b">
                                    <span
                                        class="px-3 py-1 text-xs font-semibold text-white  rounded-full {{ $scheme->app_type_associate === '1' ? 'bg-primary' : 'bg-red-500' }}">
                                        {{ $scheme->app_type_associate  === '1' ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium px-4 py-2 border-b">Member Type Scheme</td>
                                <td class="px-4 py-2 border-b">
                                    <span
                                        class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full {{ $scheme->app_type_member === '1' ? 'bg-primary' : 'bg-red-500' }}">
                                        {{ $scheme->app_type_member  === '1' ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-span-2 md:col-span-1">
                <div class="p-6 bg-white dark:bg-bg3 rounded-lg shadow-md">
                  <form action="{{ route('rdschemes.update-commission', $scheme->id) }}" method="POST">
    @csrf
    @method('PUT')

    <table class="min-w-full">
        <tbody>
            <tr>
                <td class="font-medium px-4 py-2 border-b">Current Chart</td>
                <td class="text-gray-700 px-4 py-2 border-b">
                    {{ $scheme->commission_chart ?? 'None' }}
                </td>
            </tr>
            <tr>
                <td class="font-medium px-4 py-2 border-b">Commission Chart</td>
                <td class="text-gray-700 px-4 py-2 border-b">
                    <div class="flex items-center gap-3">
                        <select id="commission_chart" name="commission_chart"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                            <option value="">Select Chart</option>
                            <option value="hsdh(Tenure-6M)" {{ old('commission_chart', $scheme->commission_chart) == 'hsdh(Tenure-6M)' ? 'selected' : '' }}>hsdh (Tenure-6M)</option>
                            <option value="hs(Tenure-12M)" {{ old('commission_chart', $scheme->commission_chart) == 'hs(Tenure-12M)' ? 'selected' : '' }}>hs (Tenure-12M)</option>
                            <option value="rd(Tenure-2M)" {{ old('commission_chart', $scheme->commission_chart) == 'rd(Tenure-2M)' ? 'selected' : '' }}>rd (Tenure-2M)</option>
                            <option value="fd(Tenure-1M)" {{ old('commission_chart', $scheme->commission_chart) == 'fd(Tenure-1M)' ? 'selected' : '' }}>fd (Tenure-1M)</option>
                        </select>
                        <button class="btn-primary" type="submit">Update</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>

                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- Header -->
            <div id="toggleAuditTrail"
                class="bg-secondary/5 text-black font-semibold px-4 py-2 rounded-10 flex justify-between items-center cursor-pointer">
                <span>RD ACCOUNT SETTING AUDIT TRAIL</span>
                <button id="auditToggleBtn" class="text-white text-xl font-bold">-</button>
            </div>

            <!-- Collapsible Table -->
            <div id="auditTrailSection"
                class="bg-white dark:bg-bg3 border border-gray-200 rounded-b-md shadow overflow-hidden transition-all duration-500 max-h-screen opacity-100">
                <table class="w-full text-start border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 border-b">Creator</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 border-b">Event</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 border-b">Create On</th>
                            <th class="px-4 py-2 font-semibold text-start text-gray-700 border-b">Change Logs</th>
                        </tr>
                    </thead>
                    <tbody>
                     </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const toggleHeader = document.getElementById("toggleAuditTrail");
        const section = document.getElementById("auditTrailSection");
        const toggleBtn = document.getElementById("auditToggleBtn");

        let isOpen = true;

        toggleHeader.addEventListener("click", () => {
            isOpen = !isOpen;

            if (isOpen) {
                section.style.maxHeight = "1000px";
                section.style.opacity = "1";
                toggleBtn.textContent = "-";
            } else {
                section.style.maxHeight = "0";
                section.style.opacity = "0";
                toggleBtn.textContent = "+";
            }
        });
    </script>
@endsection