@extends('layout.main')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="main-inner">
        <div class="grid grid-cols-12 gap-4 xxl:gap-6">
            <div class="col-span-12 lg:col-span-6 overflow-x-hidden">
                <div class="overflow-hidden box   bg-white border border-gray-200 rounded-lg shadow-md">

                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-gray-50">
                        <!-- Member Name -->
                        <span class="text-sm font-semibold text-blue-600"></span>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button class="flex btn-warning uppercase px-2 py-2 rounded-10 text-sm"
                                title=" Surrender Share " style="">
                                Surrender Share
                            </button>
                            <!-- Transfer Share -->
                            <button
                                class="flex btn-primary uppercase px-2 py-2 rounded-10 text-sm"
                                title="Transfer Share">
                                Share Transfer
                            </button>

                            <button type="button"
                                class=" p-2 btn-primary"
                                title="Edit">
                                <i class="las la-pencil-alt"></i>
                            </button>

                            <!-- Delete -->
                            <button
                                class="p-2 btn-error"
                                title="Delete">
                                <i class="las la-trash-alt "></i>
                            </button>
                        </div>
                    </div>

                    <!-- Transaction Details Table -->
                    <table class="w-full text-sm text-left">
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Customer</td>
                                <td class="px-4 py-2 border-b">
                                    <a href="{{ route('member.show', $shareholding->members->id) }}"
                                        class="text-primary hover:underline">
                                        {{ $shareholding->members->member_no
        ?? ($shareholding->members->id ? str_pad($shareholding->members->id, 6, '0', STR_PAD_LEFT) : 'N/A') }} -
                                        {{ $shareholding->members->member_info_first_name ?? '' }}
                                        {{ $shareholding->members->member_info_middle_name }}
                                        {{ $shareholding->members->member_info_last_name }}
                                    </a>

                                </td>

                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Share Allotment Date</td>
                                <td class="px-4 py-2 border-b">
                                    {{ \Carbon\Carbon::parse($shareholding->allotment_date)->format('d-m-Y') ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Share Range</td>
                                <td class="px-4 py-2 border-b">{{ $shareholding->from_share_no }} -
                                    {{ $shareholding->to_share_no }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Total Shares</td>
                                <td class="px-4 py-2 border-b">{{ $shareholding->shares ?? '' }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Nominal Value</td>
                                <td class="px-4 py-2 border-b"> ₹ {{ number_format($shareholding->face_value, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Total Value</td>
                                <td class="px-4 py-2 font-medium text-green-600 border-b"> ₹
                                    {{ number_format($shareholding->total_consideration, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Allotment Date</td>
                                <td class="px-4 py-2  border-b">
                                    {{ \Carbon\Carbon::parse($shareholding->created_at)->format('d-m-Y') ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Date of Transfer</td>
                                <td class="px-4 py-2 border-b">
                                    {{ $shareholding->transfer_date ? \Carbon\Carbon::parse($shareholding->transfer_date)->format('d-m-Y') : '' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Share Certificate No</td>
                                <td class="px-4 py-2 border-b">{{ $shareholding->certificate_number }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-semibold border-b bg-gray-50 uppercase">Is Surrendered</td>
                                <td class="px-4 py-2 border-b">No</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="mt-6 rounded-10 shadow box ">
            <div class="overflow-x-auto whitespace-nowrap">
                <table class="w-full overflow-x-auto whitespace-nowrap text-sm text-left border-0">
                    <thead class="font-bold  bg-secondary/5">
                        <tr>
                            <th class="px-4 py-3 text-start border-0 uppercase">Business Type</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">Transferor</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">Transferee</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">Share Range</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">Nominal Val.</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">No. Of Shares</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">Transfer Date</th>
                            <th class="px-4 py-3  text-start border-0 uppercase">New Share</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr>
                            <td class="px-4 py-5 text-start border-0">Saving Account</td>
                            <td class="px-4 py-5 text-start text-blue-600 border-0">
                                <a href="{{ route('promotor.show', base64_encode($shareholding->promotor->id)) }}"
                                    class="text-primary hover:underline">
                                    {{ $shareholding->promotor->folio_no ?? '' }} -
                                    {{ $shareholding->promotor->first_name ?? '' }}
                                </a>
                            </td>
                            <td class="px-4 py-5 text-start text-blue-600 border-0">
                                <a href="{{ route('member.show', $shareholding->members->id) }}"
                                    class="text-primary hover:underline">
                                    {{ $shareholding->members->member_no
        ?? ($shareholding->members->id ? str_pad($shareholding->members->id, 6, '0', STR_PAD_LEFT) : 'N/A') }} -
                                    {{ $shareholding->members->member_info_first_name ?? '' }}
                                    {{ $shareholding->members->member_info_middle_name }}
                                    {{ $shareholding->members->member_info_last_name }}
                                </a>
                            </td>
                            <td class="px-4 py-5 text-start border-0">{{ $shareholding->from_share_no }} -
                                {{ $shareholding->to_share_no }}
                            </td>
                            <td class="px-4 py-5 text-start border-0">{{ number_format($shareholding->face_value, 2) }}</td>
                            <td class="px-4 py-5 text-start border-0">{{ $shareholding->shares ?? '' }}</td>
                            <td class="px-4 py-5 text-start border-0">
                                {{ $shareholding->transfer_date ? \Carbon\Carbon::parse($shareholding->transfer_date)->format('d-m-Y') : '' }}
                            </td>
                            <td class="px-4 py-5 text-start border-0">
                                {{-- <span class="px-2 py-1 text-xs text-white bg-red-500 rounded">No</span> --}}

                                <div class="flex items-center gap-1">
                                    <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                Yes
                            </span>
                             <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                No
                            </span>
                            (static)
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection