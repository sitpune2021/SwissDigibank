@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h4 class="h2">MDS/ RD ACCOUNTS</h4>
        <a class="btn-primary flex items-center gap-2" href="{{ route('mds-rd-accounts.create-rd-account') }}">
            ADD
        </a>
    </div>

    <!-- Alpine.js for toggle -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Table -->
    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="pb-4 overflow-x-auto lg:pb-6">
        <table class="w-full border border-n30 rounded-lg overflow-hidden whitespace-nowrap">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                    <th class="px-6 py-3 text-center">ASSOCIATE</th>
                    <th class="px-6 py-3 text-center">COLLECTOR</th>
                    <th class="px-6 py-3 text-center">GROUP</th>
                    <th class="px-6 py-3 text-center">RD NO</th>
                    <th class="px-6 py-3 text-center">CUSTOMER NO</th>
                    <th class="px-6 py-3 text-center">CUSTOMER NAME</th>
                    <th class="px-6 py-3 text-center">MINOR</th>
                    <th class="px-6 py-3 text-center">BRANCH</th>
                    <th class="px-6 py-3 text-center">SCHEME</th>
                    <th class="px-6 py-3 text-center">AMOUNT</th>
                    <th class="px-6 py-3 text-center">TOTAL INST</th>
                    <th class="px-6 py-3 text-center">PAID INST</th>
                    <th class="px-6 py-3 text-center">DUE INST</th>
                    <th class="px-6 py-3 text-center">OVERDUE INST</th>
                    <th class="px-6 py-3 text-center">INST CANCELLED</th>
                    <th class="px-6 py-3 text-center">TOTAL INST NOT DUE</th>
                    <th class="px-6 py-3 text-center">OPEN DATE</th>
                    <th class="px-6 py-3 text-center">MATURITY DATE</th>
                    <th class="px-6 py-3 text-center">FREQUENCY</th>
                    <th class="px-6 py-3 text-center">STATUS</th>
                    <th class="px-6 py-3 text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Demo Row -->
            <tbody>
                @forelse($rdAccounts as $account)
                <tr class="border-t">
                    <td class="px-6 py-4 text-center">{{ $account->advisor_staff ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">{{ $account->collection_advisor_staff ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{route('rd-accounts.show',$account->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $account->id ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{route('member.show',$account->member->id)}}" class="text-primary underline hover:text-primary/80">
                            {{
                                optional($account->member)->member_no
        ?? (optional($account->member)->id 
            ? str_pad($account->member->id, 6, '0', STR_PAD_LEFT) 
            : '')}}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-center">{{ optional($account->member)->full_name ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">
                        @php
                        $minor = $account->minor;
                        @endphp
                        {{ $minor ? trim(($minor->first_name ?? '').' '.($minor->last_name ?? '')) : 'No' }}
                    </td>
                    <td class="px-6 py-4 text-center">{{ optional($account->branch)->branch_name ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">{{ $account->scheme ?? '—' }}</td>
                    <td class="px-6 py-4 text-center">₹{{ number_format($account->rd_amount, 2) }}</td>

                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">—</td>

                    <td class="px-6 py-4 text-center">
                        {{ $account->open_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $account->open_date)->format('d-m-Y') : '' }}
                    </td>
                    <td class="px-6 py-4 text-center">—</td>
                    <td class="px-6 py-4 text-center">Monthly</td>

                    <td class="px-6 py-4 text-center">
                        @if($account->approve_status === 'Approved')
                        <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Active
                        </span>
                        @else
                        <span class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                            Pending
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => $account->id,
                            'viewRoute' => 'mds-rd-account.show',
                            ])
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="21" class="px-6 py-6 text-center text-gray-500">No RD accounts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if ($rdAccounts->hasPages())
        <div class="flex items-center justify-center space-x-2 mt-6">
            {{-- Previous Page Link --}}
            @if ($rdAccounts->onFirstPage())
            <button class="px-3 py-1 border rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">Prev</button>
            @else
            <a href="{{ $rdAccounts->previousPageUrl() }}" class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-200">Prev</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($rdAccounts->getUrlRange(1, $rdAccounts->lastPage()) as $page => $url)
            @if ($page == $rdAccounts->currentPage())
            <span class="px-3 py-1 border rounded-lg bg-primary text-white">{{ $page }}</span>
            @else
            <a href="{{ $url }}" class="px-3 py-1 border rounded-lg hover:bg-gray-200">{{ $page }}</a>
            @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($rdAccounts->hasMorePages())
            <a href="{{ $rdAccounts->nextPageUrl() }}" class="px-3 py-1 border rounded-lg text-gray-600 hover:bg-gray-200">Next</a>
            @else
            <button class="px-3 py-1 border rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">Next</button>
            @endif
        </div>
        @endif

    </div>

    @endsection