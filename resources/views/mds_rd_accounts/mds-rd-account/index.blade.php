@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2 text-lg">MDS/ RD ACCOUNTS</h2>
        <a class="btn-primary flex items-center gap-2 uppercase" href="{{ route('mds-rd-accounts.create-rd-account') }}">
            Add
        </a>
    </div>

    <!-- Alpine.js for toggle -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    <!-- Table -->
   <div class="box">
     <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>
    <div class="pb-4 overflow-x-auto   lg:pb-6">
        <table class="w-full border border-n30 rounded-lg p-2 overflow-hidden whitespace-nowrap">
            <thead>
                <tr class="bg-secondary/5 dark:bg-bg3  font-semibold">
                    <th class="px-6 py-4  text-start">ASSOCIATE</th>
                    <th class="px-6 py-4  text-start">COLLECTOR</th>
                    <th class="px-6 py-4  text-start">GROUP</th>
                    <th class="px-6 py-4  text-start">RD NO</th>
                    <th class="px-6 py-4  text-start">CUSTOMER NO</th>
                    <th class="px-6 py-4  text-start">CUSTOMER NAME</th>
                    <th class="px-6 py-4  text-start">MINOR</th>
                    <th class="px-6 py-4  text-start">BRANCH</th>
                    <th class="px-6 py-4  text-start">SCHEME</th>
                    <th class="px-6 py-4  text-start">AMOUNT</th>
                    <th class="px-6 py-4  text-start">TOTAL INST</th>
                    <th class="px-6 py-4  text-start">PAID INST</th>
                    <th class="px-6 py-4  text-start">DUE INST</th>
                    <th class="px-6 py-4  text-start">OVERDUE INST</th>
                    <th class="px-6 py-4  text-start">INST CANCELLED</th>
                    <th class="px-6 py-4  text-start">TOTAL INST NOT DUE</th>
                    <th class="px-6 py-4  text-start">OPEN DATE</th>
                    <th class="px-6 py-4  text-start">MATURITY DATE</th>
                    <th class="px-6 py-4  text-start">FREQUENCY</th>
                    <th class="px-6 py-4  text-start">STATUS</th>
                    <th class="px-6 py-4  text-start">ACTIONS</th>
                </tr>
            </thead> 
            <tbody>
                @forelse($rdAccounts as $account)
                <tr class="border-t">
                    <td class="px-6 py-4 text-start">{{ $account->advisor_staff ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-start">{{ $account->collection_advisor_staff ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">
                        <a href="{{route('rd-accounts.show',$account->id)}}" class="text-primary underline hover:text-primary/80">
                            {{ $account->rd_no ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-start">
                        <a href="{{route('member.show',$account->member->id)}}" class="text-primary underline hover:text-primary/80">
                            {{
                                optional($account->member)->member_no
                                ?? (optional($account->member)->id 
                                ? str_pad($account->member->id, 6, '0', STR_PAD_LEFT) 
                                : '')}}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-start">{{ optional($account->member)->full_name ?? '—' }}</td>
                    <td class="px-6 py-4 text-start">
                        @php
                        $minor = $account->minor;
                        @endphp
                        {{ $minor ? trim(($minor->first_name ?? '').' '.($minor->last_name ?? '')) : 'No' }}
                    </td>
                    <td class="px-6 py-4 text-start">{{ optional($account->branch)->branch_name ?? '—' }}</td>
                    
                    <td class="px-6 py-4 text-start">{{ $account->scheme->scheme_name ?? '—' }}</td>
                    <td class="px-6 py-4 text-start">₹{{ number_format($account->rd_amount, 2) }}</td>

                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">—</td>
                    <td class="px-6 py-4 text-start">—</td>

                    <td class="px-6 py-4 text-start">
                        {{ $account->open_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $account->open_date)->format('d-m-Y') : '' }}
                    </td>
                    <td class="px-6 py-4 text-start">{{ $account->maturity_date ? \Carbon\Carbon::createFromFormat('Y-m-d', $account->maturity_date)->format('d-m-Y') : '' }}</td>
                    <td class="px-6 py-4 text-start">Monthly</td>

                    <td class="px-6 py-4 text-start">
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
                    <td class="px-6 py-4 text-start">
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
                    <td colspan="21" class="px-6 py-6 text-start text-gray-500">No RD accounts found.</td>
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
   </div>
</div>
    @endsection