@extends('layout.main')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="main-inner">
    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md">

        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-gray-50">
            <!-- Member Name -->
            <span class="text-sm font-semibold text-blue-600"></span>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button
                    class="flex items-center gap-1 px-2 py-1 text-xs text-white transition rounded"
                    title=" Surrender Share " style="background-color: orange;">
                    Surrender Share 
                </button>
                <!-- Transfer Share -->
                <button
                    class="flex items-center gap-1 px-2 py-1 text-xs text-white transition bg-green-500 rounded hover:bg-green-600"
                    title="Transfer Share">
                    Share Transfer
                </button>

                <button type="button"
                    class="flex items-center justify-center text-gray-700 transition bg-gray-200 rounded w-7 h-7 hover:bg-gray-300"
                    title="Edit">
                    <i class="fa fa-pencil text-[11px]"></i>
                </button>

                <!-- Delete -->
                <button
                    class="flex items-center justify-center text-white transition bg-red-500 rounded w-7 h-7 hover:bg-red-600"
                    title="Delete">
                    <i class="fas fa-trash-alt text-[11px]"></i>
                </button>
            </div>
        </div>

        <!-- Transaction Details Table -->
        <table class="w-full text-sm text-left">
            <tbody>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Member</td>
                    <td class="px-4 py-2 border-b"> {{ $shareholding->members->member_info_first_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Share Allotment Date</td>
                    <td class="px-4 py-2 border-b"> {{ \Carbon\Carbon::parse($shareholding->allotment_date)->format('d/m/Y') ?? '' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Share Range</td>
                    <td class="px-4 py-2 border-b">{{ $shareholding->from_share_no}} - {{ $shareholding->to_share_no }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Total Shares</td>
                    <td class="px-4 py-2 border-b">{{ $shareholding->shares ?? '' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Nominal Value</td>
                    <td class="px-4 py-2 border-b"> ₹ {{ number_format($shareholding->face_value, 2) }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Total Value</td>
                    <td class="px-4 py-2 font-medium text-green-600 border-b"> ₹ {{ number_format($shareholding->total_consideration, 2) }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Allotment Date</td>
                    <td class="px-4 py-2 text-green-600 border-b">{{ \Carbon\Carbon::parse($shareholding->created_at)->format('d/m/Y') ?? '' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Date of Transfer</td>
                    <td class="px-4 py-2 border-b">{{$shareholding->transfer_date}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Share Certificate No</td>
                    <td class="px-4 py-2 border-b">{{$shareholding->certificate_number}}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-semibold border-b bg-gray-50">Is Surrendered</td>
                    <td class="px-4 py-2 border-b">No</td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="mt-6 rounded shadow bg-gray-50">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-0">
                <thead class="font-bold text-white bg-green-500">
                    <tr>
                        <th class="px-4 py-2 border-0">Business Type</th>
                        <th class="px-4 py-2 border-0">Transferor</th>
                        <th class="px-4 py-2 border-0">Transferee</th>
                        <th class="px-4 py-2 border-0">Share Range</th>
                        <th class="px-4 py-2 border-0">Nominal Val.</th>
                        <th class="px-4 py-2 border-0">No. Of Shares</th>
                        <th class="px-4 py-2 border-0">Transfer Date</th>
                        <th class="px-4 py-2 border-0">New Share</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <tr>
                        <td class="px-4 py-2 border-0">Saving Account</td>
                        <td class="px-4 py-2 text-blue-600 border-0">DEMO-9 - Har Chauhan</td>
                        <td class="px-4 py-2 text-blue-600 border-0">DEMO-04417 - shriram kale</td>
                        <td class="px-4 py-2 border-0">31461 - 31461</td>
                        <td class="px-4 py-2 border-0">10.0</td>
                        <td class="px-4 py-2 border-0">1</td>
                        <td class="px-4 py-2 border-0">07/08/2025</td>
                        <td class="px-4 py-2 border-0">
                            <span class="px-2 py-1 text-xs text-white bg-red-500 rounded">No</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection