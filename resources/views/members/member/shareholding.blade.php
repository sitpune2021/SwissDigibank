@extends('layout.main')
<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }
</style>
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h1 class="text-xl font-semibold">Share holdings</h1>
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
                    @forelse ($finalizedShares as $share)
                        <tr class="border-b border-gray-200">
                            <td class="py-4 px-6">{{ $share->share_from }} - {{ $share->share_to }}</td>
                            <td class="py-4 px-6">{{ $share->total_shares }}</td>
                            <td class="py-4 px-6">{{ number_format($share->share_nominal, 2) }}</td>
                            <td class="py-4 px-6">{{ number_format($share->total_share_value, 2) }}</td>
                            <td class="py-4 px-6">{{ \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y') }}</td>
                            <td class="py-4 px-6">{{ \Carbon\Carbon::parse($share->transfer_date)->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="py-4 px-6">
                                @if ($share->is_surrendered)
                                    <span class="text-red-500 font-semibold">Yes</span>
                                @else
                                    <span class="text-green-500 font-semibold">No</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('shareholding.edit', $share->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a> |
                                <form action="{{ route('shareholding.destroy', $share->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-gray-500">No finalized shareholdings found.</td>
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
            url: `/api/member/${memberId}/share-holdings`, // 👈 Your backend route
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
