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
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
                                {{ str_replace('_', ' ', $sectionName) }}
                            </h3>
                        </div>
                    @endif



                    {{-- Handle Correspondence and Permanent Address checkbox toggles --}}
                    @if (in_array($sectionName, ['CUSTOMER_CORRESPONDENCE_ADDRESS', 'CUSTOMER_PERMANENT_ADDRESS']))
                        {{-- Checkbox to toggle this address section --}}
                        <div class="col-span-2  flex items-center gap-2">
                            <input type="checkbox" id="toggle_{{ strtolower($sectionName) }}"
                                class="toggle-address-checkbox">
                            <label for="toggle_{{ strtolower($sectionName) }}"
                                class="font-medium cursor-pointer select-none">
                                {{ str_replace('_', ' ', $sectionName) }}
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
                            <x-searchable-dropdown :items="$banks" label="BANK NAME" name="bank_id" display-field="name"
                                value-field="id" :selected="old('bank_id')" />
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
                    </div>
                @endforeach
                @endif
                @endforeach

                {{-- Save button and other controls --}}
                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    @if (isset($method))
                        <button class="btn-primary" type="submit"> {{ $method === 'PUT' ? 'Update' : 'Save' }} Customer
                        </button>
                    @endif <a href="{{ route('member.index') }}"
                        class="btn-outline inline-flex items-center justify-center"> Back </a>
                    @if ($method !== 'PUT')
                        <!-- Only show Reset button if not 'Update' --> <button class="btn-outline" type="reset"
                            onclick="document.getElementById('companyForm').reset();"> Reset </button>
                    @endif
                </div>
            </div>
        </form>
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
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Checkbox for "Same as Correspondence Address"
            const sameAddressCheckbox = document.createElement('div');
            sameAddressCheckbox.innerHTML = `
        <label class="flex items-center gap-2 mt-2">
            <input type="checkbox" id="sameAsCorrespondence" class="cursor-pointer">
            <span class="text-sm font-medium cursor-pointer">Same as Correspondence Address</span>
        </label>
    `;
            // Append the checkbox just above permanent address section
            const permSection = document.querySelector('.customer_permanent_address');
            if (permSection) {
                permSection.parentNode.insertBefore(sameAddressCheckbox, permSection);
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
    </script> --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Find Permanent Address section heading ---
            const permSectionHeading = Array.from(document.querySelectorAll('h3'))
                .find(h3 => h3.textContent.trim().toUpperCase() === 'CUSTOMER PERMANENT ADDRESS');

            if (permSectionHeading) {
                // Create tiny checkbox and label
                const sameAddressDiv = document.createElement('div');
                sameAddressDiv.className = 'flex items-center justify-end gap-2 mt-1 mb-2 text-xs';
                sameAddressDiv.innerHTML = `
            <label class="flex items-center gap-1 text-gray-600 cursor-pointer">
                <input type="checkbox" id="sameAsCorrespondence" class="h-3 w-3 cursor-pointer">
                <span>Same as Correspondence Address</span>
            </label>
        `;

                // Insert just above the "Permanent Address" heading
                permSectionHeading.parentNode.insertBefore(sameAddressDiv, permSectionHeading);
            }

            // Map of correspondence → permanent fields
            const fieldsMap = {
                'address_line_1': 'address',
                'city_district': 'city',
                'stateDropdown': 'state',
                'address_pincode': 'perm_address_pincode'
            };

            function copyAddress() {
                for (const [currId, permId] of Object.entries(fieldsMap)) {
                    const curr = document.getElementById(currId);
                    const perm = document.getElementById(permId);
                    if (curr && perm) perm.value = curr.value;
                }
            }

            function clearAddress() {
                for (const permId of Object.values(fieldsMap)) {
                    const perm = document.getElementById(permId);
                    if (perm) perm.value = '';
                }
            }

            // Toggle logic
            document.addEventListener('change', (e) => {
                if (e.target.id === 'sameAsCorrespondence') {
                    if (e.target.checked) {
                        copyAddress();
                    } else {
                        clearAddress();
                    }
                }
            });

            // Auto-update if correspondence fields change
            Object.keys(fieldsMap).forEach(currId => {
                const curr = document.getElementById(currId);
                if (curr) {
                    curr.addEventListener('input', () => {
                        const check = document.getElementById('sameAsCorrespondence');
                        if (check && check.checked) copyAddress();
                    });
                }
            });
        });
    </script> --}}


@endsection
