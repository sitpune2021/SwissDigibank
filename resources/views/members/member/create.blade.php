@extends('layout.main')
@push('style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        #sameAsCorrespondence {
            width: 12px;
            height: 12px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
        }

        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
        }

        input[type="checkbox"]:checked {
            background-color: green;
            border: none;
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
        }

        .slider .switch-off {
            right: 0;
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
        }
    </style>
@endpush
@section('page-title',
    isset($member)
    ? (!empty($show)
    ? 'VIEW ' . $member['member_info_first_name'] . 'CUSTOMER'
    : 'EDIT
    ' .
    $member['member_info_first_name'] .
    ' CUSTOMER')
    : 'ADD CUSTOMER')

@section('content')
    @include('fields.errormessage')
    <div class="box mb-4 xxxl:mb-6">
        <div id="overlay"
            style="display:none;
     position:fixed;
     top:0;
     left:0;
     width:100%;
     height:100%;
     background:rgba(0,0,0,0.6);
     z-index:9999;">
        </div>
        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST" class=""
            enctype="multipart/form-data" id="companyForm">
            <div class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if ($method == 'PUT')
                    @method('PUT')
                @endif

                @foreach ($sections as $sectionName => $fields)

                    {{-- Section Heading --}}
                    @if ($sectionName && (!isset($member) || $sectionName != 'member_KYC_documents'))
                        <div class="col-span-2 {{ str_replace('_', ' ', $sectionName) }}">
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-4">
                                {{ strtoupper(str_replace('_', ' ', $sectionName)) }}
                            </h3>
                        </div>
                    @endif

                    {{-- Handle Correspondence and Permanent Address checkbox toggles --}}
                    @if (in_array($sectionName, ['CUSTOMER_CORRESPONDENCE_ADDRESS', 'CUSTOMER_PERMANENT_ADDRESS']))
                        <div class="col-span-2 flex items-center gap-2 mt-6">

                            {{-- Checkbox --}}
                            <input type="checkbox" id="toggle_{{ strtolower($sectionName) }}"
                                {{ strtolower($sectionName) == 'customer_correspondence_address' ? 'checked' : '' }}
                                class="toggle-address-checkbox w-5 h-5 cursor-pointer">

                            {{-- Label with Asterisk --}}
                            <label for="toggle_{{ strtolower($sectionName) }}"
                                class="font-semibold text-lg cursor-pointer select-none">
                                {{ str_replace('_', ' ', $sectionName) }}
                                <span class="text-red-500">*</span>
                            </label>
                        </div>
            </div>

            {{-- Address fields wrapped inside div for toggling --}}
            <div class="w-full grid grid-cols-2 gap-4 mt-4 xl:mt-8 xxxxxl:gap-6 address-section {{ strtolower($sectionName) }}"
                style="display:none;">
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'];
                        $id = $field['id'] ?? $field['name'];
                        $required = $field['required'] ?? false;
                        $value = old($name, $member[$name] ?? ($field['default'] ?? ''));

                        if (
                            $name === 'general_enrollment_date' ||
                            $name === 'member_info_dob' ||
                            $name === 'member_info_spouse_dob' ||
                            $name === 'nominee_dob' ||
                            $name === 'charges_transaction_date'
                        ) {
                            $value = old(
                                $name,
                                isset($member[$name]) && $member[$name] instanceof \Carbon\Carbon
                                    ? $member[$name]->format('d-m-Y')
                                    : $member[$name] ?? ($field['default'] ?? ''),
                            );
                        }

                    @endphp
                    <div class="w-full  col-span-2 md:col-span-1 mb-4 {{ str_replace('_', ' ', $sectionName) }}">
                        @include('fields.label', [
                            'id' => $id,
                            'label' => $label,
                            'required' => $required,
                        ])

                        @if ($type === 'custom' && ($field['component'] ?? '') === 'searchable-dropdown')
                            {{-- ✅ Custom Searchable Dropdown --}}
                            <x-searchable-dropdown :items="$banks" label="BANK NAME" name="bank_id" display-field="name"
                                value-field="id" :selected="old('bank_id')" />
                        @else
                            {{-- Default input rendering --}}
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
                        {{-- @if ($name == 'member_kyc_aadhaar_no')
                            <div id="otpSection" style="display:none; margin-top:10px;">
                                <input type="text" id="otpInput" placeholder="Enter OTP" class="form-control">

                                <button type="button" onclick="verifyOtp()" class="btn btn-success mt-2">
                                    Verify OTP
                                </button>
                            </div>
                        @endif --}}
                        @error($name)
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-4 mt-5 xxxl:gap-6">
            @elseif ($sectionName == 'CUSTOMER_KYC_DOCUMENTS')
                {{-- Your existing CUSTOMER_KYC_DOCUMENTS code (unchanged) --}}
                @if (!isset($member))
                    @php
                        function uploadedFileLink($documents, $key)
                        {
                            return !empty($documents[$key]) && $documents[$key]->file_path
                                ? asset('storage/' . $documents[$key]->file_path)
                                : null;
                        }
                    @endphp

                    {{-- Photo --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'photo',
                            'label' => 'Photo',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'photo',
                            'label' => 'Photo',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[0][file]',
                            'value' => old('documents.0.file', $documents['photo']->file ?? ''),
                        ])
                        @include('fields.inputs', [
                            'id' => 'photo_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.0.category', $documents['photo']->category ?? 'photo'),
                            'name' => 'documents[0][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'photo'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current photo</a>
                        @endif
                        @error('documents.0.file' || 'documents.0.category')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Signature --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'signature',
                            'label' => 'Signature',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'signature',
                            'label' => 'Signature',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[1][file]',
                            'value' => old('documents.1.file', $documents['signature']->file ?? ''),
                        ])
                        @include('fields.inputs', [
                            'id' => 'signature_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old(
                                'documents.1.category',
                                $documents['signature']->category ?? 'signature'),
                            'name' => 'documents[1][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'signature'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current signature</a>
                        @endif
                        @error('documents.1.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ID Proof --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'id_proof',
                            'label' => 'ID Proof',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof_type',
                            'label' => 'ID Proof Type',
                            'required' => false,
                            'type' => 'select',
                            'value' => old('documents.2.type', $documents['id_proof']->document_type ?? ''),
                            'name' => 'documents[2][type]',
                            'field' => [
                                'options' => [
                                    'Aadhaar' => 'Aadhaar Card',
                                    'Passport' => 'Passport',
                                    'Driving' => 'Driving License',
                                    'Voter' => 'Voter ID',
                                ],
                            ],
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof',
                            'label' => 'ID Proof',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[2][file]',
                            'value' => '',
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.2.category', 'id_proof'),
                            'name' => 'documents[2][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'id_proof'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current ID Proof</a>
                        @endif
                        @error('documents.2.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- ID Proof Back --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'id_proof_back',
                            'label' => 'ID Proof Back',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof_back_type',
                            'label' => 'ID Proof Back Type',
                            'required' => false,
                            'type' => 'select',
                            'value' => old('documents.3.type', $documents['id_proof_back']->document_type ?? ''),
                            'name' => 'documents[3][type]',
                            'field' => [
                                'options' => [
                                    'Aadhaar' => 'Aadhaar Card',
                                    'Passport' => 'Passport',
                                    'Driving' => 'Driving License',
                                    'Voter' => 'Voter ID',
                                ],
                            ],
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof_back',
                            'label' => 'ID Proof Back',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[3][file]',
                            'value' => '',
                        ])
                        @include('fields.inputs', [
                            'id' => 'id_proof_back_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.3.category', 'id_proof_back'),
                            'name' => 'documents[3][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'id_proof_back'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current ID Proof Back</a>
                        @endif
                        @error('documents.3.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address Proof --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'address_proof',
                            'label' => 'Address Proof',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof_type',
                            'label' => 'Address Proof Type',
                            'required' => false,
                            'type' => 'select',
                            'value' => old('documents.4.type', $documents['address_proof']->document_type ?? ''),
                            'name' => 'documents[4][type]',
                            'field' => [
                                'options' => [
                                    'Aadhaar' => 'Aadhaar Card',
                                    'Passport' => 'Passport',
                                    'Driving' => 'Driving License',
                                    'Utility Bill' => 'Utility Bill',
                                ],
                            ],
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof',
                            'label' => 'Address Proof',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[4][file]',
                            'value' => '',
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.4.category', 'address_proof'),
                            'name' => 'documents[4][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'address_proof'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current Address Proof</a>
                        @endif
                        @error('documents.4.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address Proof Back --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'address_proof_back',
                            'label' => 'Address Proof Back',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof_back_type',
                            'label' => 'Address Proof Back Type',
                            'required' => false,
                            'type' => 'select',
                            'value' => old(
                                'documents.5.type',
                                $documents['address_proof_back']->document_type ?? ''),
                            'name' => 'documents[5][type]',
                            'field' => [
                                'options' => [
                                    'Aadhaar' => 'Aadhaar Card',
                                    'Passport' => 'Passport',
                                    'Driving' => 'Driving License',
                                    'Utility Bill' => 'Utility Bill',
                                ],
                            ],
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof_back',
                            'label' => 'Address Proof Back',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[5][file]',
                            'value' => '',
                        ])
                        @include('fields.inputs', [
                            'id' => 'address_proof_back_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.5.category', 'address_proof_back'),
                            'name' => 'documents[5][category]',
                        ])
                        @if ($link = uploadedFileLink($documents, 'address_proof_back'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current Address Proof Back</a>
                        @endif
                        @error('documents.5.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- PAN --}}
                    <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                        @include('fields.label', [
                            'id' => 'pan_number',
                            'label' => 'PAN',
                            'required' => false,
                        ])
                        @include('fields.inputs', [
                            'id' => 'pan_number_type',
                            'label' => 'PAN Type',
                            'required' => false,
                            'type' => 'select',
                            'value' => old('documents.6.type', $documents['pan_number']->document_type ?? ''),
                            'name' => 'documents[6][type]',
                            'field' => [
                                'options' => [
                                    'PAN' => 'PAN',
                                ],
                            ],
                        ])
                        @include('fields.inputs', [
                            'id' => 'pan_number',
                            'label' => 'PAN',
                            'required' => false,
                            'type' => 'file',
                            'name' => 'documents[6][file]',
                            'value' => '',
                        ])
                        @include('fields.inputs', [
                            'id' => 'pan_number_category',
                            'type' => 'hidden',
                            'label' => 'File',
                            'value' => old('documents.6.category', 'pan_number'),
                            'name' => 'documents[6][category]',
                        ])

                        @if ($link = uploadedFileLink($documents, 'pan_number'))
                            <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View
                                current
                                PAN</a>
                        @endif
                        @error('documents.6.file')
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            @else
                {{-- Default fields output for all other sections (unchanged) --}}
                @foreach ($fields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'];
                        $id = $field['id'] ?? $field['name'];
                        $required = $field['required'] ?? false;
                        $value = old($name, $member[$name] ?? ($field['default'] ?? ''));

                        if (
                            $name === 'general_enrollment_date' ||
                            $name === 'member_info_dob' ||
                            $name === 'member_info_spouse_dob' ||
                            $name === 'nominee_dob' ||
                            $name === 'charges_transaction_date'
                        ) {
                            $value = old(
                                $name,
                                isset($member[$name]) && $member[$name] instanceof \Carbon\Carbon
                                    ? $member[$name]->format('d-m-Y')
                                    : $member[$name] ?? ($field['default'] ?? ''),
                            );
                        }
                    @endphp
                    <div class="col-span-4 md:col-span-1 {{ str_replace('_', ' ', $sectionName) }}">
                        @include('fields.label', [
                            'id' => $id,
                            'label' => $label,
                            'required' => $required,
                        ])

                        @if ($type === 'custom' && ($field['component'] ?? '') === 'searchable-dropdown')
                            {{--
                <x-searchable-dropdown :items="$banks" label="BANK NAME" name="bank_id" display-field="name"
                    value-field="id" :selected="old('bank_id')" /> --}}
                            <div id="bankDropdownWrapper" class="mt-3 ">

                                <select name="bank_id" id="bank_id"
                                    class="w-full bg-secondary/5 rounded-10 border px-3 py-3 text-sm">
                                    <option value="">-- Select Bank --</option>

                                    @foreach ($banks as $id => $name)
                                        <option value="{{ $id }}" {{ old('bank_id') == $id ? 'selected' : '' }}>
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
                        @else
                            @if ($name == 'member_kyc_aadhaar_no')
                                <div style="display:flex; gap:10px; align-items:center;">

                                    <div style="flex:1;">
                                        @include('fields.inputs', [
                                            'id' => 'member_kyc_aadhaar_no',
                                            'label' => $label,
                                            'required' => $required,
                                            'type' => $type,
                                            'name' => $name,
                                            'value' => $value,
                                            'readonly' => empty($show) ? '' : 'readonly',
                                            'field' => $field,
                                        ])
                                    </div>

                                    <button type="button" onclick="sendAadhaarOtp()"
                                        style="background:#f59e0b; color:white; padding:10px 15px; border-radius:6px;">
                                        VERIFY
                                    </button>

                                </div>
                            @elseif ($name == 'member_kyc_pan_no')
                                <div style="display:flex; gap:10px; align-items:center;">

                                    <div style="flex:1;">
                                        @include('fields.inputs', [
                                            'id' => 'member_kyc_pan_no',
                                            'label' => $label,
                                            'required' => $required,
                                            'type' => $type,
                                            'name' => $name,
                                            'value' => $value,
                                            'readonly' => empty($show) ? '' : 'readonly',
                                            'field' => $field,
                                        ])
                                    </div>

                                    <button type="button" onclick="verifyPAN()"
                                        style="background:#2563eb; color:white; padding:10px 15px; border-radius:6px;">
                                        VERIFY
                                    </button>

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
                        @endif
                        @if ($id === 'monthly_income')
                            <x-number-to-word for="monthly_income" />
                        @endif

                        @error($name)
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
                @endif
                @endforeach

                {{-- Save button and other controls --}}
                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    @if (isset($method))
                        <button class="btn-primary" type="submit"> {{ $method === 'PUT' ? 'UPDATE' : 'SAVE' }} CUSTOMER
                        </button>
                        @if ($method !== 'PUT')
                            <!-- Only show Reset button if not 'Update' --> <button class="btn-outline" type="reset"
                                onclick="document.getElementById('companyForm').reset();"> RESET </button>
                        @endif
                    @endif <a href="{{ route('member.index') }}"
                        class="btn-outline inline-flex items-center justify-center"> BACK </a>
                    {{-- @if ($method !== 'PUT')
                <!-- Only show Reset button if not 'Update' --> <button class="btn-outline" type="reset"
                    onclick="document.getElementById('companyForm').reset();"> RESET </button>
                @endif --}}
                </div>
            </div>
        </form>
        <!-- OTP POPUP -->
        <div id="otpSection"
            style="
    display:none;
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%, -50%);
    background:white;
    padding:20px;
    z-index:10000;
    border-radius:10px;
    width:300px;
    text-align:center;
">
            <h3>Enter OTP</h3>

            <input type="text" id="otpInput" placeholder="Enter OTP"
                style="width:100%; padding:10px; margin-top:10px; border:1px solid #ccc;">

            <button onclick="verifyOtp()"
                style="margin-top:10px; background:green; color:white; padding:10px 15px; border-radius:5px;">
                Verify
            </button>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.online, .cheque').hide();

            $('input[name="charges_pay_mode"]').change(function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'online') {
                    $('.online').show();
                    $('.cheque').hide();
                } else if (selectedValue === 'cheque') {
                    $('.cheque').show();
                    $('.online').hide();
                } else if (selectedValue === 'cash') {
                    $('.online').hide();
                    $('.cheque').hide();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // -----------------------------
            // DIGIT-ONLY FIELDS
            // -----------------------------
            const digitFields = [{
                    id: 'mobile_no',
                    maxLength: 10
                },
                {
                    id: 'nominee_mobile_no',
                    maxLength: 10
                },
                {
                    id: 'address_pincode',
                    maxLength: 6
                },
                {
                    id: 'perm_address_pincode',
                    maxLength: 6
                },
                {
                    id: 'aadhaar_no',
                    maxLength: 12
                },
                {
                    id: 'nominee_aadhaar_no',
                    maxLength: 12
                },

            ];

            digitFields.forEach(({
                id,
                maxLength
            }) => {
                const input = document.getElementById(id);
                if (!input) return;

                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, maxLength);
                });
            });

            // -----------------------------
            // PAN FORMAT VALIDATION
            // -----------------------------
            const panFields = ['member_kyc_pan_no', 'nominee_pan_no'];
            panFields.forEach(id => {
                const input = document.getElementById(id);
                if (!input) return;

                input.addEventListener('input', function() {
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 10);
                });
            });

            // -----------------------------
            // ALPHANUMERIC (A-Z + 0-9) FIELDS
            // -----------------------------
            const alphaNumFields = [{
                    id: 'voter_id_no',
                    maxLength: 10
                },
                {
                    id: 'nominee_voter_id_no',
                    maxLength: 10
                },
                {
                    id: 'ration_card_no',
                    maxLength: 16
                },
                {
                    id: 'nominee_ration_card_no',
                    maxLength: 16
                },
                {
                    id: 'passport_no',
                    maxLength: 8
                },
                {
                    id: 'meter_no',
                    maxLength: 16
                }, // <-- Moved here
                {
                    id: 'ci_no',
                    maxLength: 16
                }, // <-- Moved here
                {
                    id: 'dl_no',
                    maxLength: 16
                },
            ];

            alphaNumFields.forEach(({
                id,
                maxLength
            }) => {
                const input = document.getElementById(id);
                if (!input) return;

                input.addEventListener('input', function() {
                    this.value = this.value
                        .toUpperCase()
                        .replace(/[^A-Z0-9]/g, '')
                        .slice(0, maxLength);
                });
            });
        });
    </script>
    <script>
        const titleRadios = document.querySelectorAll('input[name="member_info_title"]');
        const genderRadios = document.querySelectorAll('input[name="member_info_gender"]');

        titleRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const title = this.value;
                let genderToSelect = '';

                if (title === 'Md' || title === 'Mr') {
                    genderToSelect = 'male';
                } else if (title === 'Ms' || title === 'Mrs') {
                    genderToSelect = 'female';
                } else {
                    genderToSelect = '';
                }

                genderRadios.forEach(genderRadio => {
                    genderRadio.checked = genderRadio.value === genderToSelect;
                });
            });
        });
    </script>
    {{-- JavaScript to toggle address sections --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.toggle-address-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const sectionClass = this.id.replace('toggle_', '');
                    const sectionDiv = document.querySelector('.address-section.' + sectionClass);

                    if (this.checked) {
                        sectionDiv.style.display =
                            'grid'; // shows as grid to maintain your grid layout
                    } else {
                        sectionDiv.style.display = 'none';
                    }
                });

                // Optionally, initialize based on checked state if you want persistence after validation errors
                if (checkbox.checked) {
                    const sectionClass = checkbox.id.replace('toggle_', '');
                    const sectionDiv = document.querySelector('.address-section.' + sectionClass);
                    sectionDiv.style.display = 'grid';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Checkbox for "Same as Correspondence Address"
            const sameAddressCheckbox = document.createElement('div');
            sameAddressCheckbox.innerHTML = `
        <label class="flex items-center gap-2 mt-2">
            <input type="checkbox" id="sameAsCorrespondence" style=" width: 28px;
            height: 28px;
            accent-color: green;" class="cursor-pointer">
            <span class="text-sm font-medium cursor-pointer">Same as Correspondence Address</span>
        </label>
    `;

            // Append the checkbox just below Correspondence Address section
            const corrSection = document.querySelector('.customer_correspondence_address');
            if (corrSection) {
                corrSection.parentNode.insertBefore(sameAddressCheckbox, corrSection.nextSibling);
            }

            const fieldsMap = {
                // Correspondence → Permanent mapping
                'address_line_1': 'address',
                'city_district': 'city',
                'stateDropdown': 'state',
                'address_pincode': 'perm_address_pincode'
            };

            // Function to copy data
            function copyAddress() {
                for (const [currId, permId] of Object.entries(fieldsMap)) {
                    const curr = document.getElementById(currId);
                    const perm = document.getElementById(permId);
                    if (curr && perm) {
                        perm.value = curr.value;
                    }
                }
            }

            // Function to clear permanent address fields
            function clearPermanentAddress() {
                for (const permId of Object.values(fieldsMap)) {
                    const perm = document.getElementById(permId);
                    if (perm) perm.value = '';
                }
            }

            // When checkbox toggled
            document.getElementById('sameAsCorrespondence').addEventListener('change', function() {
                if (this.checked) {
                    copyAddress();
                } else {
                    clearPermanentAddress();
                }
            });

            // Optional: If user edits current address after checking "Same as" → auto-update permanent
            for (const currId of Object.keys(fieldsMap)) {
                const curr = document.getElementById(currId);
                if (curr) {
                    curr.addEventListener('input', function() {
                        const sameCheck = document.getElementById('sameAsCorrespondence');
                        if (sameCheck.checked) {
                            copyAddress();
                        }
                    });
                }
            }
        });
    </script>




    {{-- bank dropdown code --}}
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

    @if (session('success') && str_contains(session('success'), 'OTP Sent'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let otpBox = document.getElementById('otpSection');
                if (otpBox) {
                    otpBox.style.display = 'block';
                }
                document.getElementById('overlay').style.display = 'block';

            });
        </script>
    @endif


    <!-- otp pop pup show after create member on create page -->
    @if (session('otp_success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                document.getElementById('otpSection').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';

            });
        </script>
    @endif

    <!-- verify member otp -->
    <script>
        function verifyOtp() {

            let otp = document.getElementById('otpInput').value;
            let mobile = "{{ session('mobile') }}";
            let userId = "{{ session('userId') }}";
            let localUserId = "{{ session('local_user_id') }}";

            if (!otp) {
                alert("Enter OTP");
                return;
            }

            fetch("{{ url('/members/verify-mobile-otp') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        mobileNumber: mobile,
                        otp: otp,
                        userId: userId,
                        local_user_id: localUserId
                    })
                })
                .then(res => res.json())
                .then(data => {

                    if (data.success) {
                        alert("OTP Verified ✅");
                        window.location.href = "{{ route('member.index') }}";
                    } else {
                        alert(data.message || "OTP Failed");
                    }

                })
                .catch(err => {
                    console.error(err);
                    alert("Something went wrong");
                });
        }
    </script>

@endsection
