@php
$sections = config('promoter_form');
@endphp
@extends('layout.main')
@section('page-title', isset($promoter) ? (!empty($show) ? 'VIEW ' . $promoter->first_name . ' PROMOTER' : 'EDIT ' .
$promoter->first_name . ' PROMOTER') : 'ADD PROMOTER')

@push('style')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .slider .switch-on,
    .slider .switch-off {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider .switch-on {
        left: 0;
        font-size: 12px;

    }

    button[type="reset"]:active {
        transform: scale(0.95);
        opacity: 0.7;
        transition: 0.1s;
    }

    .slider .switch-off {
        right: 0;
        font-size: 12px;

    }
</style>
@endpush

@section('content')

<head>
    <style>
        input[type="radio"] {

            width: 24px;

            height: 24px;

            accent-color: green;

        }
    </style>
</head>
@include('fields.errormessage')

<div class="box mb-4 xxxl:mb-6">
    @if($errors->has('error'))
        <div class="text-red-600 text-sm mb-3">
            {{ $errors->first('error') }}
        </div>
    @endif
    <form id="companyForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
        @csrf
        @if ($method == 'PUT')
        @method('PUT')
        @endif

        @foreach ($sections as $sectionName => $fields)
        @php
        $cleanSectionName = trim($sectionName ?? '');
        $formattedSectionName = $cleanSectionName
        ? ucwords(str_replace('_', ' ', $cleanSectionName))
        : '';
        @endphp

        @if ($sectionName)
        <div class="col-span-2">
            <h4 class="pb-2 mt-4  font-semibold text-center text-gray-800  capitalize">
                {{ $formattedSectionName }}
            </h4>
        </div>
        @endif
        @foreach ($fields as $field)
        @php
        $name = $field['name'] ?? null;
        $type = $field['type'] ?? 'text';
        $label = $field['label'];
        $id = $field['id'] ?? $name;
        $required = $field['required'] ?? false;

        // Extract nominee field name by removing 'nominee_' prefix:
        $nomineeField = null;
        if (str_starts_with($name, 'nominee_')) {
        $nomineeField = substr($name, strlen('nominee_')); // e.g. 'name', 'relation'
        }

        if (
        isset($promoter?->kyc) &&
        in_array($name, [
        'aadhaar_no',
        'voter_id_no',
        'pan_no',
        'ration_card_no',
        'meter_no',
        'ci_no',
        'ci_relation',
        'dl_no',
        ])
        ) {
        $value = old($name, $promoter?->kyc?->$name ?? ($field['default'] ?? ''));
        } elseif (
        $nomineeField !== null &&
        $promoter?->nominees?->isNotEmpty() &&
        in_array($nomineeField, [
        'name',
        'relation',
        'mobile_no',
        'aadhaar_no',
        'voter_id_no',
        'pan_no',
        'address',
        ])
        ) {
        $firstNominee = $promoter?->nominees?->first();
        $value = old($name, $firstNominee?->$nomineeField ?? ($field['default'] ?? ''));
        } elseif ($name === 'enrollment_date' || $name === 'date_of_birth') {
        $value = old(
        $name,
        $promoter?->$name instanceof \Carbon\Carbon
        ? $promoter?->$name->format('d-m-Y')
        : $promoter?->$name ?? ($field['default'] ?? ''),
        );
        } else {
        $value = old($name, $promoter?->$name ?? ($field['default'] ?? ''));
        }
        @endphp

        <div class="col-span-2 md:col-span-1">
            @include('fields.label', [
            'id' => $id,
            'label' => $label,
            'required' => $required,
            ])

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

            @error($name)
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror
        </div>
        @endforeach
        @endforeach

        <div class="col-span-2 md:col-span-1">
            <div class="mb-4">
                <label for="" class="block font-medium mb-2">Transaction Date <span
                        class="text-red-500">*</span></label>
                <input type="text" id="date" name="transaction_date"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" value="{{ old('transaction_date',
                        optional($charge)->transaction_date
                            ? \Carbon\Carbon::parse($charge->transaction_date)->format('d-m-Y')
                            : ''
                    ) }}">
            </div>
            <div class="mb-4">
                <label for="" class="block font-medium mb-2">
                    Membership Fee
                </label>
              
                      <div class="flex gap-3">
                         <div class="w-full">
                           <p  class="w-full text-start px-2 uppercase">
                             Amount
                           </p>
                        </div>
                        <div class="w-full">
                            <p class="w-full text-start px-2 uppercase">
                                M. GST Rate (%)
                            </p>
                        </div>
                        <div class="w-full" >
                            <p class=" w-full text-start px-2 uppercase">T. Amount</p>
                        </div>
                      </div> 
                  
                 
                       <div class="flex gap-3 mt-3 w-full">
                         <div >
                            <input type="number" id="" name="amount"
                                value="{{ old('amount', $charge->amount ?? $membershipAmt ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" readonly>
                        </div>
                        <div>
                            <input type="number" id="" name="gst_rate"
                                value="{{ old('gst_rate', $charge->gst_rate ?? 0) }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" readonly>
                        </div>
                        <div>
                             <input type="number" id="membership_fee" name="membership_fee"
                                value="{{ old('membership_fee', $charge->total_amount ?? $membershipAmt ?? '') }}"
                                class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                        </div>
                       </div>
                   
            </div>
            <div class="mb-4">
                <label for="" class="block font-medium mb-2">Net Fee to Collect <span
                        class="text-red-500">*</span></label>
                <input type="number" id="net_fee" name="net_fee"
                    value="{{ old('net_fee', $charge->net_fee ?? $membershipAmt ?? '') }}"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3" readonly>
                    @error('net_fee')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
            </div>
            <div class="mb-4">
                <label for="" class="block font-medium mb-2">
                    Remarks (if any)
                </label>
                <input type="text" id="" name="remarks" placeholder="Enter  Remarks (if any)"
                    value="{{ old('remarks', $charge->remarks ?? '') }}"
                    class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
            </div>
            <div class="col-span-2 md:col-span-1 bg-secondary/5 p-4 rounded-lg shadow">



                <!-- Pay Mode -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-start">
                    <label class="text-sm font-medium text-gray-700 uppercase">
                        Pay Mode <span class="text-red-500">*</span>
                    </label>
                    @php
    $payMode = old('pay_mode', optional($charge)->pay_mode ?? 'cash');
@endphp
                    <div class="md:col-span-2 flex flex-wrap gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="pay_mode" value="cash"  {{ $payMode == 'cash' ? 'checked' : '' }}
                            class="text-green-500 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Cash</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="pay_mode" value="cheque" id="payMode"
                                class="text-green-500 focus:ring-green-500" {{ $payMode == 'cheque' ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Cheque</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="pay_mode" value="online" id="payMode" {{ $payMode == 'online' ? 'checked' : '' }}
                            class="text-green-500 focus:ring-green-500">
                            <span class="text-sm text-gray-700">Online Tr.</span>
                        </label>

                    </div>
                </div>

                <!-- Cheque Fields -->
                <div id="chequeFields" class="space-y-4 hidden">
                    <div class="mt-3">
                        {{-- <label class="block text-sm font-medium text-gray-700 uppercase">Bank Name <span
                                class="text-red-500">*</span></label> --}}

                        {{--
                        <x-searchable-dropdown :items="$banks" label="Bank Name" name="pay1_bank" display-field="name"
                            value-field="id" :selected="old('pay1_bank')" /> --}}
                        <div id="bankDropdownWrapper" class="mt-3 ">

                            <select name="bank_id" id="bank_id" class="w-full rounded-10 border px-3 py-3 text-sm">
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
                        @error('pay1_bank')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        @error('pay1_bank')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 uppercase">Cheque No.<span
                                class="text-red-500">*</span></label>
                        <input type="text" name="cheque_no"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3"
                            value="{{ old('cheque_no', $charge->cheque_no ?? '') }}" placeholder="Enter Cheque No.">
                        @error('pay1_cheque_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 uppercase">Cheque Date <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="date4" name="cheque_date" value="{{ old('cheque_date',
    optional($charge)->cheque_date
        ? \Carbon\Carbon::parse($charge->cheque_date)->format('d-m-Y')
        : ''
) }}" class="w-full border rounded-10 px-3 py-3 text-sm bg-white dark:bg-bg3" placeholder="DD/MM/YYYY">
                        @error('pay1_cheque_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Online Transaction Fields -->
                <div id="onlineFields" class="space-y-4 hidden">
                    <div class="mt-3">
                        <label class="block text-sm font-medium text-gray-700 uppercase">Transfer Date <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="date3" name="transfer_date"
                            class="w-full border rounded-10 px-3 py-3 dark:bg-bg3 text-sm bg-white" value="{{ old('transfer_date',
    optional($charge)->transfer_date
        ? \Carbon\Carbon::parse(optional($charge)->transfer_date)->format('d-m-Y')
        : ''
) }}" placeholder="DD/MM/YYYY">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 uppercase">UTR / Transaction No.
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="utr_no"
                            class="w-full border rounded-10 px-3 py-3 text-sm dark:bg-bg3 bg-white"
                            value="{{ old('transfer_mode', optional($charge)->transfer_mode) == 'imps' ? 'checked' : '' }}"
                            placeholder="Enter Transaction No.">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 uppercase">Transfer Mode <span
                                class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="transfer_mode" value="imps"
                                    class="text-green-500 focus:ring-green-500" {{ old('transfer_mode',
                                    optional($charge)->transfer_mode) == 'imps' ? 'checked' : '' }}>
                                <span>IMPS</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="transfer_mode" value="vpa"
                                    class="text-green-500 focus:ring-green-500" {{ old('transfer_mode',
                                    optional($charge)->transfer_mode) == 'vpa' ? 'checked' : '' }}>
                                <span>VPA</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="transfer_mode" value="neft_rtgs"
                                    class="text-green-500 focus:ring-green-500" {{ old('transfer_mode',
                                    optional($charge)->transfer_mode) == 'neft_rtgs' ? 'checked' : '' }}>
                                <span>NEFT/RTGS</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 uppercase">Credited in Company
                            Account <span class="text-red-500">*</span></label>
                        <div class="flex gap-4 mt-2">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="credited" value="yes"
                                    class="text-green-500 focus:ring-green-500" {{ old('credited',
                                    optional($charge)->credited ? 'yes' : 'no') == 'yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="credited" value="no"
                                    class="text-green-500 focus:ring-green-500" {{ old('credited',
                                    optional($charge)->credited ? 'yes' : 'no') == 'no' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Saving Account Fields -->
                <div id="savingFields" class="space-y-4 hidden mt-3">

                </div>
            </div>
        </div>


        <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
            @if (empty($show))
            <button class="btn-primary" type="submit" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                {{ $method === 'PUT' ? 'UPDATE' : 'SAVE' }} PROMOTER
            </button>

            @if ($method === 'POST')
            <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                RESET
            </button>
            @endif
            @endif

            <a href="{{ route('promotor.index') }}" class="btn-outline inline-flex items-center justify-center" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                BACK
            </a>
        </div>

    </form>
</div>


<script>
    const members = @json($membersData);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

   const memberSelect = document.getElementById('memberDropdown');


    if (!memberSelect) return;

    memberSelect.addEventListener('change', function () {
        const member = members[this.value];
        if (!member) return;

        // Text inputs
        document.getElementById('first_name').value = member.member_info_first_name ?? '';
        document.getElementById('middle_name').value = member.member_info_middle_name ?? '';
        document.getElementById('last_name').value = member.member_info_last_name ?? '';
        document.getElementById('occupation').value = member.member_info_occupation ?? '';
        document.getElementById('father_name').value = member.member_info_father_name ?? '';
        document.getElementById('mother_name').value = member.member_info_mother_name ?? '';
        document.getElementById('spouse').value = member.member_info_spouse_name ?? '';
        document.getElementById('mobile').value = member.member_info_mobile_no ?? '';
        document.getElementById('email').value = member.member_info_email ?? '';

        // Date
       if (member.member_info_dob) {
    const dob = new Date(member.member_info_dob);

    const day = String(dob.getDate()).padStart(2, '0');
    const month = String(dob.getMonth() + 1).padStart(2, '0');
    const year = dob.getFullYear();

    document.getElementById('datep').value = `${day}-${month}-${year}`;
}

        // Selects
        // document.getElementById('marital_statuses_id').value = member.member_info_marital_status ?? '';
      const maritalSelect = document.getElementById('marital_statuses_id');
const maritalText = (member.member_info_marital_status || '').toLowerCase();

[...maritalSelect.options].forEach(option => {
    option.selected = option.text.toLowerCase() === maritalText;
});

// trigger spouse enable/disable logic
maritalSelect.dispatchEvent(new Event('change'));
        document.getElementById('religions_id').value = member.member_info_religion ?? '';
       
        // Radio buttons (Title)
        document.querySelectorAll('input[name="title"]').forEach(r => {
            r.checked = (r.value === member.member_info_title);
        });

        // Radio buttons (Gender)
       document.querySelectorAll('input[name="gender"]').forEach(r => {
    r.checked = r.value.toLowerCase() === (member.member_info_gender ?? '').toLowerCase();
});
    });

});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

              const titleRadios = document.querySelectorAll('input[name="title"]');
              const genderRadios = document.querySelectorAll('input[name="gender"]');

              titleRadios.forEach(radio => {
                  radio.addEventListener('change', function() {
                      const title = this.value;
                      let genderToSelect = '';

                      // Matching your options: MD, Mr, Ms, Mrs
                      if (title === 'MD' || title === 'Mr') {
                          genderToSelect = 'Male';
                      } else if (title === 'Ms' || title === 'Mrs') {
                          genderToSelect = 'Female';
                      } else {
                          genderToSelect = '';
                      }

                      genderRadios.forEach(genderRadio => {
                          genderRadio.checked = (genderRadio.value === genderToSelect);
                      });
                  });
              });

          });
</script>

@endsection
@push('script')

<script>
    document.addEventListener('DOMContentLoaded', () => {

              const applyDigitValidation = (id, maxLength, exactLength = false) => {
                  const input = document.getElementById(id);
                  if (!input) return;

                  input.addEventListener('input', () => {
                      input.value = input.value.replace(/\D/g, '').slice(0, maxLength);
                  });

                  if (exactLength) {
                      input.addEventListener('blur', () => {
                          if (input.value.length !== maxLength) {
                            //   alert(`${formatLabel(id)} must be exactly ${maxLength} digits.`);
                            //   input.focus();
                          }
                      });
                  }
              };

              const applyPANValidation = (id) => {
                  const input = document.getElementById(id);
                  if (!input) return;

                  const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

                  input.addEventListener('input', () => {
                      input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
                  });
              };

              const applyAlphaNumValidation = (id, maxLength = null) => {
                  const input = document.getElementById(id);
                  if (!input) return;

                  input.addEventListener('input', () => {
                      input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                      if (maxLength) {
                          input.value = input.value.slice(0, maxLength);
                      }
                  });
              };

              const formatLabel = (id) =>
                  id.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());

              // Mobile Numbers (10 digits)
              ['mobile', 'nominee_mobile_no'].forEach(id => applyDigitValidation(id, 10));

              // Aadhaar Numbers (12 digits exactly)
              applyDigitValidation('aadhaar_no', 12, true);
              applyDigitValidation('nominee_aadhaar_no', 12, true);

              // PAN Numbers (Format: AAAAA9999A)
              applyPANValidation('pan_no');
              applyPANValidation('nominee_pan_no');

              // Voter ID (alphanumeric, max 10)
              applyAlphaNumValidation('voter_id_no', 10);

              // nominee Voter ID (added now) ✔️
              applyAlphaNumValidation('nominee_voter_id_no', 10);

              // Ration Card No. (alphanumeric, max 16)
              applyAlphaNumValidation('ration_card_no', 16);
              applyAlphaNumValidation('meter_no', 16);
              applyAlphaNumValidation('ci_no', 16);
              applyAlphaNumValidation('dl_no', 16);
              applyAlphaNumValidation('ci_relation', 20);
          });
</script>
<!--payment mode1-->
<script>
    //payment mode1
        const payModeRadios = document.querySelectorAll('input[name="pay_mode"]');
        const onlineFields = document.getElementById('onlineFields');
        const chequeFields = document.getElementById('chequeFields');

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
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const membership = document.getElementById("membership_fee");
    const net = document.getElementById("net_fee");

    membership.addEventListener("input", function () {
        net.value = this.value;
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const maritalSelect = document.getElementById('marital_statuses_id');
    const spouseField = document.getElementById('spouse');

    function toggleSpouseField() {
        if (!maritalSelect || !spouseField) return;

        const text = maritalSelect.options[maritalSelect.selectedIndex]?.text?.toLowerCase();

        if (text === 'single' || text === 'unmarried') {
            spouseField.value = '';
            spouseField.setAttribute('disabled', true);
            spouseField.classList.add('bg-gray-100');
        } else {
            spouseField.removeAttribute('disabled');
            spouseField.classList.remove('bg-gray-100');
        }
    }

    // run on load (edit mode support)
    toggleSpouseField();

    // run on change
    maritalSelect?.addEventListener('change', toggleSpouseField);
});
</script>

@endpush