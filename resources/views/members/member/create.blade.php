@extends('layout.main')
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

        input[type="radio"] {
            width: 24px;
            height: 24px;
            accent-color: green;
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

        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
            class="grid grid-cols-2 gap-4 xxxl:gap-6" enctype="multipart/form-data">
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

                @if ($sectionName == 'member_KYC_documents')
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
                                    current
                                    photo</a>
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
                                    current
                                    signature</a>
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
                                    current ID
                                    Proof</a>
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
                                'value' => old(
                                    'documents.3.type',
                                    $documents['id_proof_back']->document_type ?? ''),
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
                                    current ID
                                    Proof Back</a>
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
                                'value' => old(
                                    'documents.4.type',
                                    $documents['address_proof']->document_type ?? ''),
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
                                    current
                                    Address Proof</a>
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
                                    current
                                    Address Proof Back</a>
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
                @endif
            @endforeach
            <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                @if (isset($method))
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Member
                    </button>
                @endif
                <a href="{{ route('member.index') }}" class="btn-outline inline-flex items-center justify-center">
                    Back
                </a>
                @if ($method !== 'PUT')
                    <!-- Only show Reset button if not 'Update' -->
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>
                @endif
            </div>
        </form>
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

@endsection
