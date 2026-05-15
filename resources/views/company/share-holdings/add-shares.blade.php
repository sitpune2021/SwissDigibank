@extends('layout.main')

@section('page-title',
isset($shareholding)
? (!empty($show)
? 'VIEW ' .
$shareholding->promotor->first_name .
'
ALLOCATED SHARES'
: 'EDIT ALLOCATED SHARES')
: 'ALLOCATE NEW SHARE TO PROMOTER')

@section('content')

<head>
    <style>
        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
        }
    </style>

</head>

@include('fields.errormessage')

<div class="box mb-4 xxxl:mb-6">

    <form id="companyForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
        @csrf
        @if ($method == 'PUT')
        @method('PUT')
        @endif

        @foreach ($formFields as $field)
        @php
        $name = $field['name'];
        $type = $field['type'] ?? 'text';
        $label = $field['label'];
        $id = $field['id'] ?? $field['name'];
        $required = $field['required'] ?? false;
        $value = old($name, $shareholding[$name] ?? ($field['default'] ?? ''));

        // Format date fields
        if ($name == 'allotment_date' || $name == 'transaction_date') {
        $value = old(
        $name,
        $shareholding?->$name instanceof \Carbon\Carbon
        ? $shareholding?->$name->format('d-m-Y')
        : $shareholding?->$name ?? ($field['default'] ?? ''),
        );
        }

        // Assign conditional classes only to conditional fields
        $conditionalClass = '';
        if (in_array($name, ['transfer_date', 'utr_no', 'transfer_mode'])) {
        $conditionalClass = 'conditional online_tr';
        } elseif (in_array($name, ['bank_name', 'cheque_no', 'cheque_date'])) {
        $conditionalClass = 'conditional cheque';
        } elseif ($name === 'saving_account_id') {
        $conditionalClass = 'conditional saving_ac';
        }

        $style = $conditionalClass ? 'display:none;' : '';
        @endphp

        <div class="col-span-2 md:col-span-1 {{ $conditionalClass }}" style="{{ $style }}">
            @include('fields.label', [
            'id' => $id,
            'label' => $label,
            'required' => $required,
            ])

            @if ($name === 'saving_account_id')
            <select name="saving_account_id" id="saving_account_id"
                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                <option value="">Select Account</option>
                @foreach ($dynamicOptions['savingAccounts'] as $id => $account_no)
                <option value="{{ $id }}" {{ old('saving_account_id', $shareholding->saving_account_id ?? '') == $id ?
                    'selected' : '' }}>
                    {{ $account_no }}
                </option>
                @endforeach
            </select>
            @elseif ($name === 'bank_name')
            {{--
            <x-searchable-dropdown :items="$banks" label="Select Bank" name="bank_name" display-field="name"
                value-field="id" event="Bank-selected" :selected="old('bank_name', $shareholding->bank_id ?? null)" />
            --}}

            <div id="bankDropdownWrapper" class="mt-3 ">

                <select name="bank_id" id="bank_id" class="w-full bg-secondary/5 rounded-10 border px-3 py-3 text-sm">
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
                        placeholder="Enter Cheque No" value="  {{ old('cheque_no', $application->cheque_no ?? '') }}">
                </div> --}}

                <!-- Cheque Date -->
                {{-- <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Cheque Date</label>
                    <input type="text" id="cheque_date" name="cheque_date"
                        value="{{ old('cheque_date', isset($application->cheque_date) ? \Carbon\Carbon::parse($application->cheque_date)->format('d-m-Y') : '') }}"
                        class="w-64 rounded-10 border px-3 py-2 text-sm bg-secondary/5 dark:bg-bg3">
                </div> --}}
            </div>
            @else
            @include('fields.inputs', [
            'id' => $id,
            'label' => $label,
            'required' => $required,
            'type' => $type,
            'name' => $name,
            'value' => $value,
            'readonly' => empty($show) ? '' : 'readonly',
            'field' => $field,
            ])
            @endif

            @error($name)
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror

            @if ($id === 'amount')
            <x-number-to-word for="amount" />
            @endif
            @if (in_array($id, ['first_share', 'share_no']))
            <small class="text-primary text-sm">Enter Value between : 1 - 50000</small>
            @endif

        </div>
        @endforeach

        <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
            @if (empty($show))
            <button class="btn-primary" type="submit" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                {{ $method === 'PUT' ? 'UPDATE SHARE' : 'ALLOCATE SHARE' }}
            </button>
            @endif
            @if ($method === 'POST')
            <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                RESET
            </button>
            @endif
            <button class="btn-outline" type="button" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;"
                onclick="window.location.href='{{ route('shareholding.index') }}'">BACK</button>
        </div>
    </form>
</div>

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Hide success/error alerts after 5 seconds
        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            var errorAlert = document.getElementById('error-alert');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 5000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Calculate shares and amount logic
            const firstShareInput = document.getElementById('first_share');
            const lastShareInput = document.getElementById('share_no');
            const totalShareHeldInput = document.getElementById('total_share_held');
            const totalValueInput = document.getElementById('total_share_value');
            const shareNominalInput = document.getElementById('share_nominal');
            const amountInput = document.getElementById('amount');

            function calculateSharesAndValue() {
                const first = parseInt(firstShareInput.value) || 0;
                const last = parseInt(lastShareInput.value) || 0;
                const nominal = parseFloat(shareNominalInput.value) || 0;

                if (last >= first) {
                    const totalShares = last - first + 1;
                    const totalValue = totalShares * nominal;
                    amountInput.value = totalValue.toFixed(2);

                    totalShareHeldInput.value = totalShares;
                    totalValueInput.value = totalValue.toFixed(2);
                } else {
                    totalShareHeldInput.value = 0;
                    totalValueInput.value = '';
                    amountInput.value = '';
                }
            }

            firstShareInput.addEventListener('input', calculateSharesAndValue);
            lastShareInput.addEventListener('input', calculateSharesAndValue);

            // Pay mode conditional fields toggle
            function togglePayModeFields() {
                const payMode = document.querySelector('input[name="pay_mode"]:checked')?.value;

                // Hide all conditional first
                document.querySelectorAll('.conditional').forEach(el => {

                    el.style.display = 'none';

                    // hidden field values clear karo
                    el.querySelectorAll('input, select').forEach(field => {

                        field.value = '';

                        if(field.type === 'radio' || field.type === 'checkbox'){
                            field.checked = false;
                        }

                    });

                });

                if (payMode === 'online_tr') {
                    document.querySelectorAll('.online_tr').forEach(el => el.style.display = 'block');
                } else if (payMode === 'cheque') {
                    document.querySelectorAll('.cheque').forEach(el => el.style.display = 'block');
                } else if (payMode === 'saving_ac') {
                    document.querySelectorAll('.saving_ac').forEach(el => el.style.display = 'block');
                }
            }

            // Run toggle on page load (if a pay mode is preselected)
            togglePayModeFields();

            // Add event listeners to pay_mode radios
            document.querySelectorAll('input[name="pay_mode"]').forEach(radio => {
                radio.addEventListener('change', togglePayModeFields);
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
@endpush