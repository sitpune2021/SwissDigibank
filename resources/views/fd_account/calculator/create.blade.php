@extends('layout.main')

@section('content')
    <div class="main-inner">
        {{-- Success Alert --}}
        @if (session('success'))
            <div id="success-alert"
                style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Success:</strong> {{ session('success') }}
                <span onclick="document.getElementById('success-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
            </div>
        @endif

        {{-- Error Alert --}}
        @if (session('error'))
            <div id="error-alert"
                style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
                <strong>Error:</strong> {{ session('error') }}
                <span onclick="document.getElementById('error-alert').style.display='none';"
                    style="position: absolute; top: 5px; right: 10px; cursor: pointer;">&times;</span>
            </div>
        @endif

        <div class="box mb-4 xxxl:mb-6">
            <form id="companyForm" action="{{ route('calculator.store') }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                {{-- Open Date --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="open_date" class="md:text-lg font-medium block mb-4">
                        Open Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="open_date" id="date"
                        value="{{ old('open_date', \Carbon\Carbon::today()->toDateString()) }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('open_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Amount --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="amount" class="md:text-lg font-medium block mb-4">Amount ( ₹ ) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter amount" oninput="updateAmountInWords()">
                    <div id="amount-in-words" class="text-xs text-red-500 mt-1"></div>
                    @error('amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Interest Payout Type --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="interest_payout_type" class="md:text-lg font-medium block mb-4">
                        Interest Payout Type <span class="text-red-500">*</span>
                    </label>
                    <select name="interest_payout_type" id="interest_payout_type"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="" disabled {{ old('interest_payout_type') ? '' : 'selected' }}>Select Interest
                            Payout Cycle</option>
                        <optgroup label="Cumulative (Paid at Maturity)">
                            <option value="cumulative_yearly"
                                {{ old('interest_payout_type') == 'cumulative_yearly' ? 'selected' : '' }}>Cumulative Yearly
                            </option>
                            <option value="cumulative_half_yearly"
                                {{ old('interest_payout_type') == 'cumulative_half_yearly' ? 'selected' : '' }}>Cumulative
                                Half Yearly</option>
                            <option value="cumulative_quarterly"
                                {{ old('interest_payout_type') == 'cumulative_quarterly' ? 'selected' : '' }}>Cumulative
                                Quarterly</option>
                            <option value="cumulative_monthly"
                                {{ old('interest_payout_type') == 'cumulative_monthly' ? 'selected' : '' }}>Cumulative
                                Monthly</option>
                        </optgroup>
                        <optgroup label="Periodic Payout (Paid during tenure)">
                            <option value="monthly" {{ old('interest_payout_type') == 'monthly' ? 'selected' : '' }}>
                                Monthly</option>
                            <option value="quarterly" {{ old('interest_payout_type') == 'quarterly' ? 'selected' : '' }}>
                                Quarterly</option>
                            <option value="half_yearly"
                                {{ old('interest_payout_type') == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>
                            <option value="yearly" {{ old('interest_payout_type') == 'yearly' ? 'selected' : '' }}>Yearly
                            </option>
                        </optgroup>
                    </select>
                    @error('interest_payout_type')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Annual Interest Rate --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="annual_interest_rate" class="md:text-lg font-medium block mb-4">Annual Interest Rate (%)
                        <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="annual_interest_rate" id="annual_interest_rate"
                        value="{{ old('annual_interest_rate') }}"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Annual Interest Rate (%)">
                    @error('annual_interest_rate')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Tenure Period <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-3">
                        <input type="number" name="tenure_year" placeholder="Year" value="{{ old('tenure_year') }}"
                            class="w-1/3 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-1 py-1 md:py-3"
                            oninput="calculateTenure()">
                        <input type="number" name="tenure_month" placeholder="Month" value="{{ old('tenure_month') }}"
                            class="w-1/3 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-1 py-1 md:py-3"
                            oninput="calculateTenure()">
                        <input type="number" name="tenure_day" placeholder="Days" value="{{ old('tenure_day') }}"
                            class="w-1/3 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-1 py-1 md:py-3"
                            oninput="calculateTenure()">
                    </div>
                    @if ($errors->has('tenure_year') || $errors->has('tenure_month') || $errors->has('tenure_day'))
                        <span class="text-red-500 text-xs">Please enter a valid tenure (year/month/day).</span>
                    @endif
                </div>

                {{-- Bonus --}}
                <div class="col-span-2 md:col-span-1">
                    <label for="bonus" class="md:text-lg font-medium block mb-4">Bonus <span
                            class="text-red-500">*</span></label>
                    <div class="flex gap-3 items-center">
                        <select name="bonus_type" id="bonus_type"
                            class="w-1/3 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 py-2 md:py-3">
                            <option value="%" {{ old('bonus_type') == '%' ? 'selected' : '' }}>(%)</option>
                            <option value="fixed" {{ old('bonus_type') == 'fixed' ? 'selected' : '' }}>FIXED</option>
                        </select>

                        <div class="relative w-full">
                            <input type="number" step="0.01" name="bonus" id="bonus"
                                value="{{ old('bonus') }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 pr-10"
                                placeholder="Enter Bonus">
                            <i class="fa fa-info-circle text-gray-500 absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer"
                                onclick="document.getElementById('bonusModal').classList.remove('hidden')"
                                title="Bonus Information"></i>
                        </div>
                    </div>

                    @error('bonus')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- TDS Deduction --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">TDS Deduction <span
                            class="text-red-500">*</span></label>
                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center">
                            <input type="radio" name="tds_deduction" value="1"
                                {{ old('tds_deduction') === '1' ? 'checked' : '' }}
                                class="form-radio text-primary focus:ring-primary" />
                            <span class="ml-2 text-sm">Yes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="tds_deduction" value="0"
                                {{ old('tds_deduction', '0') === '0' ? 'checked' : '' }}
                                class="form-radio text-primary focus:ring-primary" />
                            <span class="ml-2 text-sm">No</span>
                        </label>
                    </div>
                    @error('tds_deduction')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Senior Citizen --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4">Senior Citizen <span
                            class="text-red-500">*</span></label>
                    <div class="flex items-center">
                        <input type="hidden" name="is_senior_citizen" value="0">
                        <input type="checkbox" name="is_senior_citizen" id="is_senior_citizen" value="1"
                            {{ old('is_senior_citizen') == '1' ? 'checked' : '' }}
                            class="form-checkbox text-primary focus:ring-primary" />
                        <label for="is_senior_citizen" class="ml-2 text-sm">Yes</label>
                    </div>
                    @error('is_senior_citizen')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">Calculate</button>
                </div>
            </form>

            <div x-data="{ activeTab: 'tab_result' }" class="col-xs-12">
                <div class="bg-white rounded-lg shadow-md">
                    <ul class="flex border-b">
                        <!-- Final Payment Tab -->
                        <li :class="{ 'border-b-2 border-blue-500': activeTab === 'tab_result' }" class="cursor-pointer">
                            <a @click="activeTab = 'tab_result'"
                                class="px-4 py-2 text-lg font-semibold text-gray-600 hover:text-blue-500">FINAL PAYMENT</a>
                        </li>
                        <!-- 1 Year Tab -->
                        <li :class="{ 'border-b-2 border-blue-500': activeTab === 'tab_0' }" class="cursor-pointer">
                            <a @click="activeTab = 'tab_0'"
                                class="px-4 py-2 text-lg font-semibold text-gray-600 hover:text-blue-500">1 Year</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-4">
                        <!-- FINAL PAYMENT TAB -->
                        <div x-show="activeTab === 'tab_result'">
                            @if (session('fdStatement'))
                                @php
                                    $fd = session('fdStatement');

                                    function formatINR($amount)
                                    {
                                        return 'INR ' .
                                            (floor($amount) == $amount
                                                ? number_format($amount, 0)
                                                : number_format($amount, 2));
                                    }
                                @endphp
                                <!-- Full Width Table -->
                                <table class="min-w-full table-auto bg-lgrey text-gray-600">
                                    <tbody>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Principal Amount (A)</td>
                                            <td class="px-6 py-3 text-right">{{ formatINR($fd->principal_amount) }}</td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Interest Earned (B)</td>
                                            <td class="px-6 py-3 text-right">{{ formatINR($fd->interest_earned) }}</td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">TDS Deducted (C)</td>
                                            <td class="px-6 py-3 text-right">{{ formatINR($fd->tds_deducted) }}</td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Net Interest Earned (D = B - C)</td>
                                            <td class="px-6 py-3 text-right">{{ formatINR($fd->net_interest_earned) }}
                                            </td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Maturity Bonus Amount (E)</td>
                                            <td class="px-6 py-3 text-right">INR
                                                {{ number_format(session('fdStatement')->maturity_bonus_amount, 2) }}
                                            </td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Maturity Amount (A + D + E)</td>
                                            <td class="px-6 py-3 text-right ">
                                                {{ formatINR($fd->maturity_amount) }}</td>
                                        </tr>
                                        <tr class="border-t">
                                            <td class="px-6 py-3 font-semibold">Maturity Date</td>
                                            <td class="px-6 py-3 text-right">
                                                {{ \Carbon\Carbon::parse($fd->maturity_date)->format('d/m/Y') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <!-- 1 YEAR TAB -->
                        <div x-show="activeTab === 'tab_0'">
                            @if (session('interestPeriods'))
                                @php
                                    $interestPeriods = session('interestPeriods');
                                @endphp

                                <div class="overflow-x-auto">
                                    <table class="min-w-full  text-center">
                                        <thead class="" style="background-color:#3c8dbc; color:white;">
                                            <tr>
                                                <th class="px-4 py-2 font-semibold">PERIOD</th>
                                                <th class="px-4 py-2 font-semibold">DAYS</th>
                                                <th class="px-4 py-2 font-semibold">PRINCIPAL</th>
                                                <th class="px-4 py-2 font-semibold">INTEREST (A)</th>
                                                <th class="px-4 py-2 font-semibold">TDS (B)</th>
                                                <th class="px-4 py-2 font-semibold">NET INTEREST (A - B)</th>
                                                <th class="px-4 py-2 font-semibold">NET INTEREST on DUE DATE</th>
                                                <th class="px-4 py-2 font-semibold">PRINCIPAL AT EOY</th>
                                                <th class="px-4 py-2 font-semibold">DUE BY</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($interestPeriods as $period)
                                                <tr class="border-t">
                                                    <td class="px-4 py-2">
                                                        {{ \Carbon\Carbon::parse($period['period_from'])->format('d/m/Y') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($period['period_to'])->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-4 py-2">{{ $period['days'] }}</td>
                                                    <td class="px-4 py-2">{{ number_format($period['principal'], 2) }}
                                                    </td>
                                                    <td class="px-4 py-2">{{ number_format($period['interest'], 2) }}</td>
                                                    <td class="px-4 py-2">{{ number_format($period['tds'], 2) }}</td>
                                                    <td class="px-4 py-2">{{ number_format($period['net_interest'], 2) }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ isset($period['cumulative_net_interest']) ? number_format($period['cumulative_net_interest'], 2) : '-' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ isset($period['principal_at_eoy']) ? number_format($period['principal_at_eoy'], 2) : '-' }}
                                                    </td>
                                                    <td class="px-4 py-2">
                                                        {{ isset($period['due_by']) ? \Carbon\Carbon::parse($period['due_by'])->format('d/m/Y') : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function numberToWords(n) {
        const a = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten",
            "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen"
        ];
        const b = ["", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety"];

        if (n < 20) return a[n];
        if (n < 100) return b[Math.floor(n / 10)] + (n % 10 ? " " + a[n % 10] : "");
        if (n < 1000) return a[Math.floor(n / 100)] + " Hundred " + (n % 100 ? numberToWords(n % 100) : "");
        if (n < 100000) return numberToWords(Math.floor(n / 1000)) + " Thousand " + (n % 1000 ? numberToWords(n %
            1000) : "");
        if (n < 10000000) return numberToWords(Math.floor(n / 100000)) + " Lakh " + (n % 100000 ? numberToWords(n %
            100000) : "");
        return numberToWords(Math.floor(n / 10000000)) + " Crore " + (n % 10000000 ? numberToWords(n % 10000000) : "");
    }

    function updateAmountInWords() {
        const amountInput = document.getElementById('amount');
        const amountInWordsDiv = document.getElementById('amount-in-words');

        const amount = parseInt(amountInput.value, 10);
        if (!isNaN(amount) && amount >= 0) {
            amountInWordsDiv.textContent = numberToWords(amount);
        } else {
            amountInWordsDiv.textContent = '';
        }
    }
    document.getElementById('amount').addEventListener('input', updateAmountInWords);
</script>



<script>
    function showBonusInfo() {
        document.getElementById('bonusModal').classList.remove('hidden');
    }

    function closeBonusModal() {
        document.getElementById('bonusModal').classList.add('hidden');
    }
</script>
<script>
    // Auto-hide the success alert after 5 seconds (5000ms)
    setTimeout(() => {
        const alertBox = document.getElementById('success-alert');
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }, 5000);
</script>

<script>
    // JavaScript for dynamically switching tabs
    document.querySelectorAll('a[data-toggle="tab"]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('active');
                });
                target.classList.add('active');
            }
        });
    });
</script>






