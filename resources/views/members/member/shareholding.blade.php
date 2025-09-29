@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="text-xl font-semibold">SHARE HOLDINGS</h3>
        </div>
        <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
            <x-alert />
        </div>
        <div class="overflow-x-auto pb-4 lg:pb-6">
            <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start py-5 px-6 cursor-pointer">Share Range</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Total Shares</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Nominal Value</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Total Value</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Allotment Date</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Transfer Date</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Is Surrendered</th>
                        <th class="text-start py-5 px-6 cursor-pointer">Actions</th>
                    </tr>
                </thead>
                <tbody id="shareHoldingsBody">
                    @php
                        $finalizedShares = $shareholdings;
                    @endphp
                    @forelse ($shareholdings as $shareholding)
                        <tr>
                            <td class="px-6 py-5">{{ $shareholding->from_share_no . '-' . $shareholding->to_share_no ?? '-' }}
                            </td>
                            <td class="px-6 py-5">{{ $shareholding->shares ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->face_value ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->total_consideration ?? '-' }}</td>
                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($shareholding->allotment_date)->format('d-m-Y') ?? '-' }}</td>
                            <td class="px-6 py-5">
                                {{ \Carbon\Carbon::parse($shareholding->transfer_date)->format('d-m-Y') ?? '-' }}</td>
                            <td class="px-6 py-5">{{ $shareholding->is_surrendered ? 'Yes' : 'No' }}</td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center">
                                    @include('partials._vertical-options', [
                                        'id' => $shareholding->id,
                                        'viewRoute' => 'shares-transfer.show',
                                        'printRoute' => 'shares-transfer.print',
                                    ])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center px-6 py-5 text-gray-500">No shareholdings available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- <x-pagination :paginator="$shareholdings" /> --}}
    </div>
@endsection
<script>
    function fetchShareHoldings(memberId) {
        $.ajax({
            url: '/api/member/${memberId}/share-holdings', // 👈 Your backend route
            method: 'GET',
            success: function(data) {
                let html = '';

                if (data.length === 0) {
                    html =
                        `<tr><td colspan="8" class="text-center text-gray-500">No records found.</td></tr>`;
                } else {
                    data.forEach(item => {
                        html += `<tr>
                        <td>${item.share_range}</td>
                        <td>${item.total_shares}</td>
                        <td>${item.nominal_value}</td>
                        <td>${item.total_value}</td>
                        <td>${item.allotment_date}</td>
                        <td>${item.transfer_date}</td>
                        <td>${item.is_surrendered ? 'Yes' : 'No'}</td>
                        <td><button class="text-blue-600 hover:underline">View</button></td>
                    </tr>`;
                    });
                }

                $('#shareHoldingsBody').html(html);
            },
            error: function(err) {
                alert('Error loading share holdings');
            }
        });
    }
</script>
