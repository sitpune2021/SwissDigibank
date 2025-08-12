@extends('layout.main')

 @section('page-title', isset($promoter) ? (!empty($show) ? 'View ' . $promoter->first_name . ' Promoter' : 'Edit ' .
      $promoter->first_name . ' Promoter') : 'Documents')


@section('content')
    @include('fields.errormessage')
    <div class="box mb-4 xxxl:mb-6">
        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
            class="grid grid-cols-2 gap-4 xxxl:gap-6" enctype="multipart/form-data">
            @csrf

            @include('fields.inputs', [
                'id' => 'member_id',
                'type' => 'hidden',
                'label' => 'member_id',
                'value' => old('member_id', $id ?? ''),
                'name' => 'member_id',
            ])

            @if ($method == 'PUT')
                @method('PUT')
            @endif

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
                @include('fields.label', ['id' => 'photo', 'label' => 'Photo', 'required' => true])
                @include('fields.inputs', [
                    'id' => 'photo',
                    'label' => 'Photo',
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current
                        photo</a>
                @endif
                @error('documents.0.file' || 'documents.0.category')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Signature --}}
            <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                @include('fields.label', ['id' => 'signature', 'label' => 'Signature', 'required' => true])
                @include('fields.inputs', [
                    'id' => 'signature',
                    'label' => 'Signature',
                    'required' => true,
                    'type' => 'file',
                    'name' => 'documents[1][file]',
                    'value' => old('documents.1.file', $documents['signature']->file ?? ''),
                ])
                @include('fields.inputs', [
                    'id' => 'signature_category',
                    'type' => 'hidden',
                    'label' => 'File',
                    'value' => old('documents.1.category', $documents['signature']->category ?? 'signature'),
                    'name' => 'documents[1][category]',
                ])
                @if ($link = uploadedFileLink($documents, 'signature'))
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current
                        signature</a>
                @endif
                @error('documents.1.file')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- ID Proof --}}
            <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                @include('fields.label', ['id' => 'id_proof', 'label' => 'ID Proof', 'required' => true])
                @include('fields.inputs', [
                    'id' => 'id_proof_type',
                    'label' => 'ID Proof Type',
                    'required' => true,
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
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current ID
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
                    'required' => true,
                ])
                @include('fields.inputs', [
                    'id' => 'id_proof_back_type',
                    'label' => 'ID Proof Back Type',
                    'required' => true,
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
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current ID
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
                    'required' => true,
                ])
                @include('fields.inputs', [
                    'id' => 'address_proof_type',
                    'label' => 'Address Proof Type',
                    'required' => true,
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
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current
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
                    'required' => true,
                ])
                @include('fields.inputs', [
                    'id' => 'address_proof_back_type',
                    'label' => 'Address Proof Back Type',
                    'required' => true,
                    'type' => 'select',
                    'value' => old('documents.5.type', $documents['address_proof_back']->document_type ?? ''),
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
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current
                        Address Proof Back</a>
                @endif
                @error('documents.5.file')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- PAN --}}
            <div class="col-span-4 md:col-span-2 mb-4 flex flex-col gap-2">
                @include('fields.label', ['id' => 'pan_number', 'label' => 'PAN', 'required' => true])
                @include('fields.inputs', [
                    'id' => 'pan_number_type',
                    'label' => 'PAN Type',
                    'required' => true,
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
                    'required' => true,
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
                    <a href="{{ $link }}" target="_blank" class="text-blue-600 underline text-sm">View current
                        PAN</a>
                @endif
                @error('documents.6.file')
                    <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Form Buttons --}}
            <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                @if (isset($method))
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Member
                    </button>
                @endif
                <a href="{{ route('member.index') }}" class="btn-outline inline-flex items-center justify-center">
                    Back
                </a>
                <button class="btn-outline" type="reset">
                    Reset
                </button>
            </div>
        </form>


    </div>
@endsection
