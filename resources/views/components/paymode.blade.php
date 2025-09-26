<div class="col-span-2 md:col-span-1  @if($bgColor) bg-secondary/5 @endif p-4 rounded-lg shadow">

    <!-- Section Title -->
    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 @if($hiddenheading) hidden @endif   ">
        Pay Mode
    </h4>

    <!-- Amount Field -->

    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center @if($amountClass) hidden @endif ">
        <label class="text-sm font-medium text-gray-700 ">
            {{$label ?? 'Amount'}} <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-2">
            <input type="number" id="{{ $id}}" name="{{$name ?? 'amount'}}" placeholder="Enter Amount"
                class="w-full border rounded-10 px-3 py-3 text-sm bg-white/5"
                value="{{ old('amount', $amount) }}"
                @if($readonly ?? false) readonly @endif>
            <x-number-to-word for="{{ $id}}" />

        </div>
    </div>


    <!-- Pay Mode -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start mt-3">
        <label class="text-sm font-medium text-gray-700 ">
            Pay Mode
            <span class="text-red-500">*</span>
        </label>
        <div class="md:col-span-2 flex flex-wrap gap-4">
            <label class="flex items-center gap-2">
                <input type="radio" name="pay_mode" value="cash" class="text-green-500 focus:ring-green-500" checked>
                <span class="text-sm text-gray-700">Cash</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="radio" name="pay_mode" value="cheque" class="text-green-500 focus:ring-green-500">
                <span class="text-sm text-gray-700">Cheque</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="radio" name="pay_mode" value="online" class="text-green-500 focus:ring-green-500">
                <span class="text-sm text-gray-700">Online Tr.</span>
            </label>
            @if($showSaving)
            <label class="flex items-center gap-2">
                <input type="radio" name="pay_mode" value="saving" class="text-green-500 focus:ring-green-500">
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
            <label class="block text-sm font-medium text-gray-700">Bank Name <span class="text-red-500">*</span></label>
            {{-- <select name="bank_id" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
                <option value="">Select Bank</option>
                @foreach($banks as $bank)
                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
            @endforeach
            </select> --}}
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
            <label class="block text-sm font-medium text-gray-700">Cheque No. <span class="text-red-500">*</span></label>
            <input type="text" name="cheque_no" placeholder="Enter Cheque No."
                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
        </div>
        @error('cheque_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <div>
            <label class="block text-sm font-medium text-gray-700">Cheque Date <span class="text-red-500">*</span></label>
            <input type="text" id="date4" name="cheque_date"
                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                placeholder="DD/MM/YYYY">
        </div>
        @error('cheque_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Online Transaction Fields -->
    <div id="onlineFields" class="space-y-4 hidden">
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Transfer Date <span class="text-red-500">*</span></label>
            <input type="text" id="date3" name="transfer_date"
                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                placeholder="DD/MM/YYYY">
        </div>
        @error('transfer_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        
        <div>
            <label class="block text-sm font-medium text-gray-700">UTR / Transaction No. <span class="text-red-500">*</span></label>
            <input type="text" name="utr_no" placeholder="Enter Transaction No."
                class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3">
        </div>
        @error('utr_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <div>
            <label class="block text-sm font-medium text-gray-700">Transfer Mode <span class="text-red-500">*</span></label>
            <div class="flex gap-4 mt-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="transfer_mode" value="imps" class="text-green-500 focus:ring-green-500">
                    <span>IMPS</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="transfer_mode" value="vpa" class="text-green-500 focus:ring-green-500">
                    <span>VPA</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="transfer_mode" value="neft_rtgs" class="text-green-500 focus:ring-green-500">
                    <span>NEFT/RTGS</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Credited in Company Account <span class="text-red-500">*</span></label>
            <div class="flex gap-4 mt-2">
                <label class="flex items-center gap-2">
                    <input type="radio" name="credited" value="yes" class="text-green-500 focus:ring-green-500">
                    <span>Yes</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="credited" value="no" class="text-green-500 focus:ring-green-500">
                    <span>No</span>
                </label>
            </div>
        </div>
        @error('credited') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <!-- Saving Fields -->
    <div id="savingFields" class="space-y-4 mt-3 hidden">
        <label class="block text-sm font-medium text-gray-700">Select Saving Account <span class="text-red-500">*</span></label>
        <select id="savingAccountSelect" name="saving_account_id"
            class="w-full border rounded-10 px-3 py-3 text-sm bg-white mt-3">
            <option value="">Select Account</option>
            @foreach($banks as $bank)
            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
            @endforeach
        </select>
        <div id="accountBalanceDiv" class="mt-3 hidden">
            <label class="block text-sm font-medium text-gray-700">Account Balance</label>
            <div id="accountBalance" class="p-3 text-sm font-semibold text-primary"></div>
        </div>
    </div>
</div>

{{-- Scripts --}}
{{-- @push('scripts') --}}
<script>
    const payModeRadios = document.querySelectorAll('input[name="pay_mode"]');
    const onlineFields = document.getElementById('onlineFields');
    const chequeFields = document.getElementById('chequeFields');
    const savingFields = document.getElementById('savingFields');

    payModeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            onlineFields.classList.add('hidden');
            chequeFields.classList.add('hidden');
            savingFields.classList.add('hidden');

            if (radio.value === 'online') onlineFields.classList.remove('hidden');
            if (radio.value === 'cheque') chequeFields.classList.remove('hidden');
            if (radio.value === 'saving') savingFields.classList.remove('hidden');
        });
    });

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
{{-- @endpush --}}