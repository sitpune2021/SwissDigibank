@extends('layout.main')
<style>
    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browsers */
    }

    input[type="checkbox"] {

        accent-color: green;
        width: 24px !important;
        height: 24px !important;
        /* Modern browsers */
    }
</style>
@section('page-title', isset($promoter) ? $promoter->first_name : 'Add Promoter')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


<div class="flex flex-wrap gap-4 justify-between mb-2 pb-4 lg:mb-3 lg:pb-3" style="flex-direction: row-reverse;">
    <x-alert />
</div>
<div class="flex flex-wrap gap-3 mb-3 text-center">

    <a href="{{ route('promotor.transactions', ['id' => $promoter]) }}"
        class="btn-primary rounded-10 py-2 px-2 text-sm">
        VIEW TRANSACTIONS
    </a>

    <a href="{{ isset($promoter) ? route('form15g15h.download.promoter', $promoter->id) : '#' }}"
        title="DOWNLOAD 15G/ 15H" class="btn-secondary rounded-10 py-2 px-2 text-sm">
        <i class="fa fa-download"></i> DOWNLOAD 15G/15H
    </a>

    <a href="{{ isset($promoter) ? route('form15g15h.create', ['promoter_id' => $promoter->id, 'type' => 'promoter']) : '#' }}"
        class="btn-warning rounded-10 py-2 px-2 text-sm">
        <i class="fa fa-plus" aria-hidden="true"></i> UPLOAD 15G/ 15H
    </a>
</div>

<div class="grid grid-cols-12 gap-4 xxl:gap-6">
    <div class="col-span-12 lg:col-span-6 overflow-x-hidden">
        <div class="col-span-12 box overflow-x-hidden">
            <table class="w-full whitespace-nowrap text-sm">
                <tbody>

                    <tr class=" border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase gap-3">
                                <span>Branch</span>
                            </div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->branch->branch_name ?? '' }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase text-start gap-3"><span>Enrollment Date</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->enrollment_date ?
                                    \Carbon\Carbon::parse($promoter->enrollment_date)->format('d-m-Y') : 'N/A' }}</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase text-start gap-3"><span>Name</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->title . ' ' . $promoter->first_name . ' ' . $promoter->middle_name .
                                    ' ' . $promoter->last_name }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase text-start gap-3"><span>DOB</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->date_of_birth ?
                                    \Carbon\Carbon::parse($promoter->date_of_birth)->format('d-m-Y') : 'N/A' }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase text-start gap-3"><span>Age</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ \Carbon\Carbon::parse($promoter->date_of_birth)->age }} years</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex items-center uppercase text-start gap-3"><span>Senior Citizen</span></div>
                        </th>
                        @php
                        $dob = \Carbon\Carbon::parse($promoter->date_of_birth);
                        $age = $dob->age;
                        @endphp
                        <td class="p-2">
                            @if ($age >= 60)
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                            @else
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Gender</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->gender }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Folio No.</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->folio_no }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Father Name</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->father_name ?? '' }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Mother Name</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->mother_name ?? '' }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Marital Status</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->maritalStatus?->status }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Religion</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->religion?->name }}</span>
                            </div>
                        </td>
                    </tr>
                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Spouse Name </span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->husband_wife_name }}</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3"><span>Occupation</span></div>
                        </th>
                        <td class="p-2">
                            <div>
                                <span>{{ $promoter->occupation }}</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b dark:even:bg-bg3">
                        <th class=" py-2 px-6">
                            <div class="flex  items-center uppercase text-start gap-3">
                                <span>
                                    Form 15G/ 15H Uploaded<br>(FY 2025 -
                                    2026)
                                </span>
                            </div>
                        </th>
                        <td class="p-2">
                            <div>
                                {{-- <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    {{ $promoter->form15G15H->count() >= 1 ? 'Yes' : 'No' }}
                                </span> --}}
                                @if($promoter->form15G15H->count() >= 1)
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    Yes
                                </span>
                                @else
                                <span
                                    class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                    No
                                </span>
                                @endif

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Member KYC Info --}}
        <div class=" toggle-box mt-4 box rounded-md shadow">
            <!-- Header -->
            <div
                class="toggle-header flex items-center justify-between px-4 py-3 bg-secondary/5 rounded-10 cursor-pointer">
                <span class="font-semibold text-lg uppercase">Member KYC Info</span>
                <i class="toggle-icon las la-minus"></i>
            </div>
            <!-- Content -->
            <div class="toggle-content bg-white rounded-md">
                <table class="w-full text-sm">
                    <tbody>
                        <tr class="border-b">
                            <th class=" px-6 py-2 font-semibold  text-lg text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Aadhaar No.</span>
                                </div>
                            </th>
                            <td class="flex items-center justify-between px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->aadhaar_no ?? '' }}</span>
                                <i class="text-green-600 fa fa-check-circle"></i>
                            </td>
                        </tr> {{-- Added closing </tr> here --}}
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase  text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Voter ID No.</span>
                                </div>
                            </th>
                            <td class="flex items-center justify-between px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->voter_id_no ?? '' }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> PAN No.</span>
                                </div>
                            </th>
                            <td class="flex items-center justify-between px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->pan_no ?? '' }}</span>
                                <i class="text-green-600 fa fa-check-circle"></i>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Ration Card No.</span>
                                </div>
                            </th>
                            <td class="flex items-center justify-between px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->ration_card_no ?? ''}}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Meter No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->meter_no ?? '' }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> CI No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->ci_no ?? '' }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> CI Relation</span>
                                </div>

                            </th>
                            <td class="px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->ci_relation ?? ''}}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold uppercase text-lg text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> DL No</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                <span>{{ $promoter->kyc?->dl_no ?? '' }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Member Nominee Info --}}
        <div class="toggle-box mt-4 rounded-10 box shadow">
            <div
                class="toggle-header flex items-center justify-between px-4 py-3 bg-secondary/5  rounded-10 cursor-pointer">
                <span class="font-semibold text-lg uppercase">Nominee Info</span>
                <i class="toggle-icon las la-minus"></i>
            </div>
            <div class="toggle-content bg-white">
                <table class="w-full  text-sm">
                    <tbody>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> Name</span>
                                </div>
                            </th>
                            <td class="flex items-center justify-between px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->name }}</span>
                            </td>
                        </tr>

                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Relation</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->relation }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Mobile No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->mobile_no }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Aadhaar No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->aadhaar_no }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> Voter ID No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->voter_id_no }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold  text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> PAN No.</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->pan_no }}</span>
                            </td>
                        </tr>
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> Address</span>
                                </div>
                            </th>
                            <td class="px-6 py-2">
                                <span>{{ $promoter->nominees->first()?->address }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="toggle-box mt-4 rounded shadow box">
            <!-- Header -->
            <div
                class="toggle-header flex items-center justify-between px-4 py-2 bg-secondary/5 rounded-10 cursor-pointer">
                <span class="font-semibold uppercase py-2 text-lg">Documents</span>
                <div class="flex gap-4 space-x-2 items-center">
                    {{-- <i class="cursor-pointer fa fa-pencil"></i> --}}
                    <a class="btn-primary p-1 "
                        href="{{ isset($promoter) ? route('promotor.document', ['id' => $promoter->id, 'type' => 'promoter']) : '#' }}">
                        <i class="cursor-pointer las la-pencil-alt "></i>
                    </a>

                    <i class="toggle-icon las la-minus"></i>
                </div>
            </div>

            <!-- Content -->
            <div class="toggle-content bg-white">
                <table class="w-full text-sm ">
                    <tbody>
                        {{-- Photo --}}
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Photo (Photo).</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @php
                                $photo = $documents->get('photo'); // use keyBy for easy access
                                @endphp

                                @if ($photo && $photo->file_path)
                                {{-- View Button --}}
                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $photo->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Signature --}}
                        @php
                        $signature = $documents->get('signature'); // use keyBy for easy access
                        @endphp
                        {{-- @php $signature = $documents->where('document_category', 'signature')->first(); @endphp
                        --}}
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Signature (Signature)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($signature && $signature->file_path)
                                <button type="button" class="text-primary underline" {{--
                                    onclick="previewDoc('{{ asset('storage/' . addslashes($signature->file_path)) }}','Signature')"
                                    --}}
                                    onclick="window.open('{{ asset('storage/' . $signature->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- ID Proof --}}
                        @php $idProof = $documents->where('document_category', 'id_proof')->first(); @endphp
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> ID Proof (Passport)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($idProof && $idProof->file_path)
                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $idProof->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- ID Proof Back --}}
                        @php $idProofBack = $documents->where('document_category', 'id_proof_back')->first(); @endphp
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> ID Proof Back (Aadhar Card)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($idProofBack && $idProofBack->file_path)
                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $idProofBack->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Address Proof --}}
                        @php $addressProof = $documents->where('document_category', 'address_proof')->first(); @endphp
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span>Address Proof (Passport)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($addressProof && $addressProof->file_path)
                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $addressProof->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Address Proof Back --}}
                        @php $addressProofBack = $documents->where('document_category', 'address_proof_back')->first();
                        @endphp
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">
                                <div class="flex items-center uppercase gap-3">
                                    <span> Address Proof Back (Aadhar Card)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($addressProofBack && $addressProofBack->file_path)
                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $addressProofBack->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>

                        {{-- PAN --}}
                        @php $pan = $documents->where('document_category', 'pan_number')->first(); @endphp
                        <tr class="border-b">
                            <th class="px-6 py-2 font-semibold text-start">

                                <div class="flex items-center uppercase gap-3">
                                    <span> PAN Number (PAN)</span>
                                </div>
                            </th>
                            <td class="px-6 py-2 text-start">
                                @if ($pan && $pan->file_path)


                                <button type="button" class="text-primary underline"
                                    onclick="window.open('{{ asset('storage/' . $pan->file_path) }}','_blank')">
                                    View
                                </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="col-span-12 lg:col-span-6" x-data="{
                showMobile: true,
                showAddress: true,
                showBank: true,
                showMember: true
            }">


        <div class="px-4 space-y-6">
            <div class="flex gap-4 lg:flex-row flex-col overflow-x-auto ">
                <!-- Total Deposits -->
                <div class="flex items-center box overflow-hidden  bg-white rounded shadow">
                    <div class="flex items-center justify-center w-20 h-20 bg-primary  rounded-10">
                        <i class="text-3xl text-white fa fa-money"></i>
                    </div>
                    <div class="pl-6">
                        <span class="block text-sm font-medium text-gray-700 uppercase">Total Deposits</span>
                        <span class="text-xl font-bold text-black">0.00</span>
                    </div>
                </div>

                <!-- Loan Outstanding -->
                <div class="flex items-center box overflow-hidden bg-white rounded shadow">
                    <div class="flex items-center justify-center w-20 h-20 bg-secondary rounded-10 px-6">
                        <i class="text-3xl text-white fa fa-money"></i>
                    </div>
                    <div class="pl-6">
                        <span class="block text-sm font-medium text-gray-700 uppercase">Loan Outstanding</span>
                        <span class="text-xl font-bold text-black">0.00</span>
                    </div>
                </div>
            </div>

            <!-- KYC Status Section -->
            <div class="mt-4 overflow-hidden box border rounded shadow">

                <div class="flex items-center justify-between px-4 py-2 border-b">
                    <span class="font-semibold text-gray-700 uppercase">Current KYC Status</span>
                    <span class="px-2 py-2 text-xs font-bold rounded
    @if($promoter->kyc?->kyc_status === 'pending') bg-warning text-white
    @elseif($promoter->kyc?->kyc_status === 'in_progress') bg-primary text-white
    @elseif($promoter->kyc?->kyc_status === 'completed') bg-primary text-white
    @elseif($promoter->kyc?->kyc_status === 'rejected') bg-error text-white
    @else bg-gray-100 text-gray-600
    @endif
">
                        {{ strtoupper(str_replace('_', ' ', $promoter->kyc?->kyc_status ?? 'not submitted')) }}
                    </span>

                </div>
                <div class=" flex items-center justify-between p-4">
                    <form action="{{ route('promotor-kyc.updateStatus', $promoter->id) }}" method="POST">
                        @csrf

                        <label class="font-semibold text-gray-700 uppercase">KYC Status</label>

                        <div class="flex gap-2 mt-3">
                            <select name="kyc_status"
                                class="w-full px-3 py-3 bg-secondary/5 text-sm border rounded-10 focus:outline-none">

                                @php
                                $currentStatus = $promoter->kyc?->kyc_status;
                                @endphp

                                <option value="pending" {{ $currentStatus==='pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="in_progress" {{ $currentStatus==='in_progress' ? 'selected' : '' }}>
                                    MIN KYC
                                </option>

                                <option value="completed" {{ $currentStatus==='completed' ? 'selected' : '' }}>
                                    Full KYC
                                </option>

                                <option value="rejected" {{ $currentStatus==='rejected' ? 'selected' : '' }}>
                                    Rejected
                                </option>
                            </select>

                            <button type="submit"
                                class=" w-28 px-4 py-1 text-sm text-white bg-green-500 rounded-10 hover:bg-green-600">
                                UPDATE
                            </button>
                    </form>
                </div>

            </div>
        </div>
        <!-- Settings Section -->
        <div class="mt-4 overflow-hidden box rounded shadow">
            {{-- <div class="h-1 bg-red-500"></div> --}}
            <div class="px-4 py-2 font-semibold uppercase text-lg bg-white border-b">Settings</div>
            <div class="p-4 space-y-4 bg-white">
                <div class="flex items-center font-semibold text-lg uppercase justify-between">
                    <span>Internet Banking / Mob App Enabled</span>
                    <input type="checkbox" class="w-5 h-5 ">
                </div>
                <div class="flex items-center font-semibold text-lg uppercase justify-between">
                    <span>Money Transfer</span>
                    <input type="checkbox" class="w-5 h-5 " checked>
                </div>
                <div class="flex items-center font-semibold text-lg uppercase justify-between">
                    <span>Account Locked</span>
                    <input type="checkbox" class="w-5 h-5 ">
                </div>
                <div class="flex items-center font-semibold text-lg uppercase justify-between">
                    <span>SMS</span>
                    <input type="checkbox" class="w-5 h-5 " checked>
                </div>
            </div>
        </div>
        {{-- Internet Banking section --}}
        <div class="mt-4 bg-white box  rounded shadow-sm">


            <!-- Header -->
            <div class="px-4 py-3 bg-white border-b">
                <h3 class="text-lg  font-semibold tracking-wide text-gray-700">INTERNET BANKING USERNAME</h3>
            </div>

            <!-- Body -->
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Left label -->
                <div class="flex-1">
                    <div class="text-lg font-semibold text-gray-700 uppercase">
                        <span>USERNAME</span>
                    </div>
                </div>

                <!-- Center username -->
                <div class="flex-1 text-center">
                    <span class="text-lg font-semibold text-gray-700">
                        demo04421
                    </span>
                </div>

                <!-- Right small action buttons -->
                <div class="flex justify-end flex-1 gap-4">
                    <button type="button" class="flex items-center justify-center btn-primary px-3"
                        title="Reset username">
                        <i class="fa fa-undo"></i>
                    </button>

                    <button type="button" class="flex items-center justify-center btn-primary px-3 py-2"
                        title="Send username">
                        <i class="fa fa-share-square-o"></i>
                    </button>
                </div>
            </div>
        </div>
        <div x-data="{
                        showMobile: false,
                        editing: false
                    }" class="mt-4  rounded shadow">

            <!-- MINORS -->
            <div class="mt-4 bg-white p-3 rounded shadow">
                {{-- <div class="h-1 bg-green-500"></div> --}}

                <!-- Header -->
                <div class="flex items-center justify-between px-4 py-2 rounded-t">
                    <span class="font-semibold  text-lg uppercase">
                        {{ isset($promoter) ? $promoter->first_name : 'Add Promoter' }}
                    </span>

                    <!-- Redirect to create page -->
                    <a href="{{ isset($promoter) ? route('minor.create', ['promotor_id' => $promoter->id, 'type' => 'promotor']) : '#' }}"
                        class="px-4 py-2 uppercase rounded-10 text-sm text-white bg-primary 
                            {{ isset($promoter) ? 'rounded-r hover:bg-green-600' : 'bg-gray-300 cursor-not-allowed' }}"
                        {{ isset($promoter) ? '' : 'onclick="return false;"' }}>
                        + Minor
                    </a>
                </div>

                <!-- Table for minors -->
                <div class="p-4">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="border-b px-4 bg-secondary/5 py-2">
                                <th class="font-semibold  px-4 py-2 text-start ">NAME</th>
                                <th class="font-semibold text-gray-ft-600 px-4 py-2 text-start">DOB</th>
                                <th class="font-semibold text-gray-ft-600 py-8 text-left">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                            @foreach ($promoter->minor as $minors)
                            <tr class="border-b">
                                <td class=" px-4 py-2">{{ $minors?->first_name ?? '' }}
                                    {{ $minors?->last_name ?? '' }}
                                </td>
                                <td class=" px-4 py-2">
                                    {{ \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}
                                </td>
                                <td class=" px-4 py-2">
                                    <div class="flex items-center gap-3 justify-center">
                                        <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                            class="btn-primary p-2 mr-2">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                            class="btn-primary p-2">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="3" class="border px-4 py-2 text-center text-gray-500">No
                                    minors available.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Share Holdings section - table format --}}
            <div class="mt-4 bg-white rounded-10 p-3 rounded shadow-sm">

                <!-- Top red border -->
                {{-- <div class="h-1 rounded-t" style="background:red;"></div> --}}

                <!-- Header -->
                <div class="px-4 py-3 bg-white border-b flex justify-between">
                    <h6 class="font-medium tracking-wide text-gray-700 text-lg">
                        SHARE HOLDING DETAILS
                    </h6>

                    @php
                    $firstNominee = $promoter->nominees->first();
                    @endphp

                    @if ($firstNominee)
                    <a href="{{ route('nominee.edit', $firstNominee->id) }}"
                        class="px-4 py-2 uppercase text-sm btn-primary rounded-10 ">
                        + Nominee
                    </a>
                    @else
                    <a href="{{ route('nominee.edit', $promoter->nominees()->create([])->id) }}"
                        class="px-4 py-2 uppercase text-sm btn-primary rounded-10 ">
                        + Nominee
                    </a>
                    @endif
                </div>
                <!-- Table Body -->
                <div class="px-6 py-4">
                    <table class="w-full border-collapse">
                        <tbody>
                            <tr>
                                <th class="px-4 py-2 text-lg     font-semibold text-start text-gray-700 uppercase">
                                    <span>No. of Shares</span>
                                </th>
                                <td class="px-4 py-2 text-lg text-center text-gray-700">
                                    <span> {{ $totalShares ?? 0 }}</span>
                                </td>


                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($promoter->nominees->count() > 0)
            <div class="box mt-5">
                <div class="toggle-box bg-secondary/5 text-black py-2 rounded-10 shadow">
                    <div class="toggle-header cursor-pointer flex items-center justify-between px-4 py-2 rounded-t">
                        <span class="font-semibold text-lg uppercase">
                            SHARE HOLDING NOMINEE'S INFO
                        </span>
                        <div class="flex gap-2 space-x-2">
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>

                    <div class=" toggle-content p-4 text-sm bg-white">
                        <div class="py-2">
                            <table class="w-full overflow-x-auto whitespace-nowrap text-sm text-left">
                                <thead>
                                    <tr class="border-b bg-secondary/5">
                                        <th class="font-semibold px-4 py-2 text-start">NAME</th>
                                        <th class="font-semibold px-4 py-2 text-start">RELATION</th>
                                        <th class="font-semibold px-4 py-2 text-start">ADDRESS</th>
                                        <th class="font-semibold px-4 py-2 text-start">SHARE %</th>
                                        <th class="font-semibold px-4 py-2 text-start">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promoter->nominees as $nom)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $nom->name }}</td>
                                        <td class="px-4 py-2">{{ $nom->relation }}</td>
                                        <td class="px-4 py-2">{{ $nom->address }}</td>
                                        <td class="px-4 py-2">
                                            {{ $nom->share_holding ? $nom->share_holding . '%' : '%' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($promoter->nominees->count() > 0)
                                            <a href="{{ route('nominee.edit', $nom->id) }}" class="btn-primary p-2">
                                                <i class="fa fa-edit "></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif


            <!-- ADDRESS & CONTACT INFO -->
            <div class="toggle-box mt-4 box rounded shadow">
                <div class="toggle-header flex items-center justify-between px-4 py-3  rounded-10 bg-secondary/5">
                    <span class="font-semibold text-lg uppercase">
                        Address & Contact Info
                    </span>
                    <div class="flex items-center gap-4">
                        <a class="btn-primary p-1"
                            href="{{ isset($promoter) ? route('promotor.address', ['id' => $promoter->id, 'type' => 'promoter']) : '#' }}">
                            <i class="cursor-pointer las la-pencil-alt"></i>
                        </a>
                        <i class="toggle-icon las la-minus"></i>
                    </div>
                </div>
                <div class="toggle-content p-4 space-y-4 text-sm overflow-x-auto whitespace-nowrap bg-white">
                    <h5 class="mb-2 font-semibold uppercase text-center">
                        Correspondence Address
                    </h5>
                    <div class="flex justify-between  text-lg border-b">
                        <span class="font-semibold uppercase ">Address</span>
                        {{-- <span>{{ $member->address->member_address_line_1 }}</span> --}}
                    </div>
                    <div class="flex justify-between text-lg  border-b">
                        <span class="font-semibold uppercase ">Para/ Ward/ Panchayat/ Area</span>

                        {{-- <span>
                            {{ $member->address->member_address_para }}/
                            {{ $member->address->member_address_ward }}/
                            {{ $member->address->member_address_panchayat }}/
                            {{ $member->address->member_address_area }}
                        </span> --}}
                    </div>
                    <div class="flex justify-between text-lg border-b ">
                        <span class="font-semibold uppercase ">Landmark</span>
                        {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                    </div>
                    <div class="flex justify-between text-lg border-b ">
                        <span class="font-semibold uppercase">GPS Lat/ Log</span>
                        {{-- <span>{{ $member->address->member_gps_location_latitude }}
                            {{ $member->address->member_gps_location_latitude }}
                        </span> --}}
                    </div>
                    <div class="flex justify-between text-lg border-b ">
                        <span class="font-semibold uppercase">Email </span>
                        {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                    </div>
                    <div class="flex justify-between text-lg border-b ">
                        <span class="font-semibold uppercase">Mobile No.</span>
                        {{-- <span>{{ $member->address->member_address_landmark }}</span> --}}
                    </div>
                </div>
            </div>
            <!-- BANK DETAILS -->
            <div class="box mt-5">
                <div class="toggle-box mt-2  bg-secondary/5 rounded-10 shadow">
                    <div class=" toggle-header flex items-center justify-between px-2 py-3 rounded-10  ">
                        <span class="font-semibold uppercase text-lg">Bank Details(static)</span>
                        <div class="cursor-pointer flex gap-4 items-center  space-x-2 px-2">
                            <a href="" class="btn-primary p-1">
                                <i class="cursor-pointer las la-pencil-alt"></i>
                            </a>
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>
                    <div class=" toggle-content p-4 text-sm bg-white">
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-semibold uppercase">Bank Name</span>
                            <span>{{ $promoter->branch->branch_name ?? '' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-semibold uppercase">IFSC Code</span>
                            <span>{{ $promoter->branch->ifsc_code }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="font-semibold uppercase">Account Type</span>
                            {{-- <span>{{ $promoter->account->account_type }}</span> --}}
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-semibold uppercase">Account No.</span>
                            {{-- <span>{{ $promoter->account->account_no }}</span> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promoter AccountsS -->
            <div class="box mt-5">
                <div class="toggle-box bg-secondary/5 py-2  rounded-10 shadow">
                    <div class=" toggle-header cursor-pointer flex items-center justify-between px-4  py-2 rounded-10">
                        <span class=" font-semibold uppercase text-lg ">Promoter Accounts(static)</span>
                        <div class="flex gap-2 space-x-2">
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>

                    <div class="toggle-content p-4 text-sm bg-white">
                        <div class="p-2 overflow-x-auto whitespace-nowrap">
                            <table class="w-full text-sm text-left">
                                <thead>
                                    <tr class="bg-secondary/5 ">
                                        <th class="font-semibold  py-2 text-start">ACCOUNT TYPE</th>
                                        <th class="font-semibold  py-2 text-start">ACCOUNT NO.</th>
                                        <th class="font-semibold  py-2 text-start">OPEN DATE</th>
                                        <th class="font-semibold  py-2 text-start">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                    @foreach ($promoter->minor as $minors)
                                    <tr>
                                        <td>{{ $minors?->first_name ?? '' }}
                                            {{ $minors?->last_name ?? '' }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="flex items-center gap-2 py-2 ">
                                                <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                                    class="btn-primary p-1 hover:underline mr-2">
                                                    <i class="las la-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                                    class="btn-primary p-1 hover:underline">
                                                    <i class="las la-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                            No minors available.
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JOINT ACCOUNTS -->
            <div class="box mt-5">
                <div class="toggle-box bg-secondary/5  rounded-10 py-2 shadow">
                    <div class=" toggle-header cursor-pointer flex items-center justify-between px-4 py-2 rounded-10">
                        <span class="font-semibold uppercase text-lg">JOINT ACCOUNTS(static)</span>
                        <div class="flex gap-2 space-x-2">
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>

                    <div class=" toggle-content p-4 text-sm bg-white">
                        <div class="overflow-x-auto whitespace-nowrap">
                            <table class="w-full text-sm overflow-x-auto whitespace-nowrap text-left">
                                <thead>
                                    <tr class="bg-secondary/5">
                                        <th class="font-semibold px-2 py-2 text-start">ACCOUNT TYPE</th>
                                        <th class="font-semibold px-2 py-2 text-start">ACCOUNT NO.</th>
                                        <th class="font-semibold px-2 py-2 text-start">OPEN DATE</th>
                                        <th class="font-semibold px-2 py-2 text-start">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                    @foreach ($promoter->minor as $minors)
                                    <tr class="py-2">
                                        <td class="text-center">{{ $minors?->first_name ?? '' }}
                                            {{ $minors?->last_name ?? '' }}
                                        </td>
                                        <td class="text-center">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center py-2">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                                    class="btn-primary p-1 hover:underline mr-2">
                                                    <i class="las la-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                                    class="btn-primary p-1 hover:underline">
                                                    <i class="las la-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                            No minors available.
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CO APPLICANT LOANS -->
            <div class="box  mt-5">
                <div class="toggle-box py-2 bg-secondary/5   rounded-10 shadow">
                    <div class="toggle-header flex items-center cursor-pointer justify-between px-4 py-2 rounded-10">
                        <span class="font-semibold uppercase text-lg">CO APPLICANT LOANS (static)</span>
                        <div class="flex gap-2 space-x-2">
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>

                    <div class="toggle-content p-4 text-sm bg-white">
                        <div class="p-2 whitespace-nowrap overflow-x-auto">
                            <table class="w-full text-sm text-left whitespace-nowrap overflow-x-auto">
                                <thead>
                                    <tr class="bg-secondary/5">
                                        <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                        <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                        <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                        <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                    @foreach ($promoter->minor as $minors)
                                    <tr>
                                        <td class="text-center">{{ $minors?->first_name ?? '' }}
                                            {{ $minors?->last_name ?? '' }}
                                        </td>
                                        <td class="text-center">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center py-2">
                                            <div class="flex justify-center items-center gap-2">
                                                <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                                    class="btn-primary p-1 hover:underline mr-2">
                                                    <i class="las la-eye" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                                    class="btn-primary p-1 hover:underline">
                                                    <i class="las la-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                            No minors available.
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MY GUARANTOR SHIP -->
            <div class="box mt-5">
                <div class="toggle-box  bg-secondary/5 py-2 rounded-10 shadow" style="">

                    <div class="toggle-header flex items-center justify-between px-4 py-2  rounded-t">
                        <span class="font-semibold cursor-pointer uppercase text-lg">MY GUARANTOR SHIP (static)</span>
                        <div class="flex gap-2 space-x-2">
                            <i class="toggle-icon las la-minus"></i>
                        </div>
                    </div>

                    <div class="toggle-content p-4 text-sm bg-white">
                        <div class="">
                            <table class="w-full text-sm text-left overflow-x-auto whitespace-nowrap">
                                <thead>
                                    <tr class="bg-secondary/5 first:">
                                        <th class="font-semibold px-4 py-2 text-start">ACCOUNT TYPE</th>
                                        <th class="font-semibold px-4 py-2 text-start">ACCOUNT NO.</th>
                                        <th class="font-semibold px-4 py-2 text-start">OPEN DATE</th>
                                        <th class="font-semibold px-4 py-2 text-start">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($promoter->minor) && is_iterable($promoter->minor))
                                    @foreach ($promoter->minor as $minors)
                                    <tr>
                                        <td class="text-center py-2">{{ $minors?->first_name ?? '' }}
                                            {{ $minors?->last_name ?? '' }}
                                        </td>
                                        <td class="text-center py-2">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center py-2">{{
                                            \Carbon\Carbon::parse($minors->dob)->format('d-m-Y') }}</td>
                                        <td class="text-center py-2">
                                            <a href="{{ route('minor.show', $minors->id) }}" title="View"
                                                class="btn-primary p-1 hover:underline mr-2">
                                                <i class="las la-eye" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('minor.edit', $minors->id) }}" title="Edit"
                                                class="btn-primary p-1 hover:underline">
                                                <i class="las la-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2 text-center text-gray-500">
                                            No minors available.
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal HTML -->
    <!-- <div id="docPreviewModal"
                                                                                            class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                                                                                            <div class="bg-white rounded-lg shadow-lg p-4 max-w-3xl w-full relative">
                                                                                                <button onclick="closePreview()"
                                                                                                    class="absolute top-2 right-4 text-gray-800 text-xl font-bold">&times;</button>
                                                                                                <h2 id="docTitle" class="text-lg font-semibold mb-4 text-center"></h2>
                                                                                                <div id="docContent" class="max-h-[70vh] overflow-auto text-center">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div> -->

    <!-- JS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-box').forEach(box => {
        const header = box.querySelector('.toggle-header');
        const content = box.querySelector('.toggle-content');
        const icon = box.querySelector('.toggle-icon');

        let open = true; // default open

        header.addEventListener('click', function () {
            open = !open;

            content.style.display = open ? 'block' : 'none';

            icon.classList.toggle('la-minus', open);
            icon.classList.toggle('la-plus', !open);
        });
    });
});
    </script>

    <script>
        function previewDoc(fileUrl, title) {
                    const modal = document.getElementById("docPreviewModal");
                    const content = document.getElementById("docContent");
                    const docTitle = document.getElementById("docTitle");

                    docTitle.textContent = title;
                    content.innerHTML = "";

                    const ext = fileUrl.split('.').pop().toLowerCase();

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                        content.innerHTML = `<img src="${fileUrl}" alt="${title}" class="max-w-full max-h-[60vh] mx-auto" />`;
                    } else if (ext === 'pdf') {
                        content.innerHTML = `<iframe src="${fileUrl}" class="w-full h-[70vh]" frameborder="0"></iframe>`;
                    } else {
                        content.innerHTML =
                            `<p>Cannot preview this file. <a href="${fileUrl}" target="_blank" class="text-blue-600 underline">Download</a></p>`;
                    }

                    modal.classList.remove("hidden");
                }

                function closePreview() {
                    document.getElementById("docPreviewModal").classList.add("hidden");
                }
    </script>
</div>
@endsection