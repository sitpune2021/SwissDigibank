@extends('layout.main')

@section('content')

<div class="main-inner px-4 lg:px-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h3 class="text-xl font-bold uppercase">
            Ledger Group Details
        </h3>

        <a href="{{ route('ledger-group.index') }}"
           class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
            ← Back
        </a>
    </div>


    {{-- ================= GROUP SUMMARY TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow border mb-6 overflow-x-auto">

        <table class="min-w-full text-sm text-left">

            {{-- HEADER --}}
            <thead class="bg-gray-100 text-xs uppercase tracking-wider text-gray-600">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">System Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3 text-center">Is System</th>
                    <th class="px-4 py-3 text-center">Position</th>
                    <th class="px-4 py-3 text-center">Accounts</th>
                    <th class="px-4 py-3 text-right">Balance</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y">

                <tr class="bg-white hover:bg-gray-50 transition font-medium">

                    <td class="px-4 py-3">
                        {{ $group->display_name }}
                    </td>

                    <td class="px-4 py-3 text-gray-500">
                        {{ $group->system_name }}
                    </td>

                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                            {{ $group->type }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($group->is_system_group)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Yes</span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">No</span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ $group->weightage }}
                    </td>

                    <td class="px-4 py-3 text-center font-semibold">
                        {{ $accountsCount }}
                    </td>

                    <td class="px-4 py-3 text-right font-bold text-green-600">
                        ₹ {{ number_format($totalBalance,2) }}
                    </td>

                </tr>

            </tbody>
        </table>

    </div>



    {{-- ================= LEDGER TABLE ================= --}}
    <div class="bg-white rounded-2xl shadow border">

        <div class="p-4 border-b font-semibold uppercase text-sm text-gray-600">
            Ledgers under Group
        </div>

        {{-- responsive scroll wrapper --}}
        <div class="overflow-x-auto">

            <table class="min-w-full text-sm text-left">

                {{-- HEADER --}}
                <thead class="bg-gray-100 sticky top-0 z-10">
                    <tr class="uppercase text-xs tracking-wider text-gray-600">
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">System Name</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3 text-center">System A/C</th>
                        <th class="px-4 py-3 text-right">Balance</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y">

                @forelse($ledgers as $ledger)

                    <tr class="hover:bg-gray-50 transition">

                        <td class="px-4 py-3 font-medium">
                            {{ $ledger->code }}
                        </td>

                        <td class="px-4 py-3 text-indigo-600 hover:underline">
                            <a href="{{ route('ledger.view', $ledger->id) }}">
                                {{ $ledger->display_name }}
                            </a>
                        </td>

                        <td class="px-4 py-3 text-gray-500">
                            {{ $ledger->system_name }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                {{ $ledger->type }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($ledger->is_bank_acc)
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Yes</span>
                            @else
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">No</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-right font-semibold text-green-600">
                            ₹ {{ number_format($ledger->balance,2) }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-400">
                            No ledgers found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection
