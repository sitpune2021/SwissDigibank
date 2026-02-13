@extends('layout.main')

@section('content')

<div class="main-inner px-4 lg:px-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h3 class="text-lg font-bold uppercase">
            Ledger Group Details
        </h3>

        <a href="{{ route('ledger-group.index') }}"
           class="btn-primary uppercase">
             Back
        </a>
    </div>


    {{-- ================= GROUP SUMMARY TABLE ================= --}}
    <div class="box rounded-10 shadow border mb-6 overflow-x-auto">

        <table class="w-full whitespace-nowrap text-sm text-left px-2">

                        {{-- HEADER --}}
             <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">
                    <th class="text-start px-4 py-3">Name</th>
                    <th class="text-start px-4 py-3">System Name</th>
                    <th class="text-start px-4 py-3">Type</th>
                    <th class="text-center px-4 py-3 ">Is System</th>
                    <th class="text-start px-4 py-3 ">Position</th>
                    <th class="text-start px-4 py-3 ">Accounts</th>
                    <th class="text-start px-4 py-3 ">Balance</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="divide-y">

                <tr class="hover:bg-gray-50 border-b dark:hover:bg-bg2 transition">

                                    {{-- NAME --}}
                    <td class="px-4 py-4 text-sm ">
                        {{ $group->display_name }}
                    </td>

                    <td class="px-5 py-4 ">
                     <span class=" text-sm">
                        {{ $group->system_name }}
                      </span>   
                    </td>

                    <td class="px-4 py-4">
                        <span class="px-1 text-sm ">
                            {{ $group->type }}
                        </span>
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($group->is_system_group)
                           <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                            </span>
                         @endif
                    </td>

                    <td class="px-4 py-3 text-center tet-sm">
                        {{ $group->weightage }}
                    </td>

                    <td class="px-4 py-3 text-center ">
                        {{ $accountsCount }}
                    </td>

                    <td class="px-6 py-4  text-primary">
                      <span class=" text-sm">
                        ₹ {{ number_format($totalBalance,2) }}
                       </span> 
                    </td>

                </tr>

            </tbody>
        </table>

    </div>



    {{-- ================= LEDGER TABLE ================= --}}
    <div class="box rounded-2xl shadow border">

        <div class="p-4 border-b font-semibold uppercase text-lg ">
            Ledgers under Group
        </div>

        {{-- responsive scroll wrapper --}}
        <table class="w-full whitespace-nowrap mt-3 text-sm text-left px-2">

                        {{-- HEADER --}}
             <thead class="bg-gray-100 dark:bg-bg2 sticky top-0 z-10">
                <tr class="text-sm bg-secondary/5 uppercase tracking-wider text-gray-600 dark:text-gray-300">
                  
                        <th class="text-start px-4 py-3">Code</th>
                        <th class="text-start px-4 py-3">Name</th>
                        <th class="text-start px-4 py-3">System Name</th>
                        <th class="text-start px-4 py-3">Type</th>
                        <th class=" px-6 py-3 text-start">System A/C</th>
                        <th class="text-start px-4 py-3 ">Balance</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y">

                @forelse($ledgers as $ledger)

                    <tr class="hover:bg-gray-50 border-b transition">

                        <td class="px-4 py-3 text-sm">
                            {{ $ledger->code }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <a href="{{ route('ledger.view', $ledger->id) }}" class="text-primary">
                                {{ $ledger->display_name }}
                            </a>
                        </td>

                        <td class="px-5 py-3 text-sm">
                            {{ $ledger->system_name }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="">
                                {{ $ledger->type }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center">
                            @if($ledger->is_bank_acc)
                                 <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                Yes
                                 </span>
                            @else
                                  <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16" >
                                                No
                                 </span>
                            @endif
                        </td>

                        <td class="px-5 py-3 text-right  text-primary">
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
