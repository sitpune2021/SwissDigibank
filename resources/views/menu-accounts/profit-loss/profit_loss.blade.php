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

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
               Profit & Loss
            </h3>
        </div>

        <div>
            <form>
                <div class="flex justify-center box gap-3">
                    <div class="">
                        <select id="" name=""
                            class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                            <option selected>ALL</option>

                        </select>
                    </div>

                    <div class="">
                        <button type="submit" class="btn-warning rounded-10  ">
                            GET
                        </button>
                    </div>
                </div>
            </form>
        </div>


        <div class="col-span-12 box lg:col-span-12">

            <div class="border-b border-gray-200 mb-4">
                <ul id="tabs" class="flex flex-wrap -mb-px text-sm font-medium text-center">                 
                    <li class="me-2">
                        <button data-tab="tab4" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            PROFIT & LOSS ACCOUNTS
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab5" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            EXPENSES
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab6" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            REVENUE
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Tabs Content -->
            <div class="tab-content p-4">

                <!-- Tab 4 : Profit & Loss Only -->
                <div id="tab4" class="tab-pane hidden">

                <div class="overflow-x-auto rounded-xl border bg-white">

                <table class="min-w-full text-sm">

                <thead class="bg-gray-100 font-bold">
                <tr>
                <th class="px-4 py-3 text-left">PARTICULARS</th>
                <th class="px-4 py-3 text-right">CURRENT</th>
                <th class="px-4 py-3 text-right">PREVIOUS</th>
                </tr>
                </thead>

                <tbody>

                {{-- Revenue --}}
                <tr>
                <td class="px-4 py-3 font-semibold">Total Revenue</td>
                <td class="px-4 py-3 text-right text-green-600 font-bold">
                ₹ {{ number_format($totalRevenueCurrent,2) }}
                </td>
                <td class="px-4 py-3 text-right text-green-600 font-bold">
                ₹ {{ number_format($totalRevenuePrevious,2) }}
                </td>
                </tr>

                {{-- Expense --}}
                <tr>
                <td class="px-4 py-3 font-semibold">Total Expense</td>
                <td class="px-4 py-3 text-right text-red-600 font-bold">
                ₹ {{ number_format($totalExpenseCurrent,2) }}
                </td>
                <td class="px-4 py-3 text-right text-red-600 font-bold">
                ₹ {{ number_format($totalExpensePrevious,2) }}
                </td>
                </tr>

                {{-- Net Profit / Loss --}}
                <tr class="bg-blue-100 text-lg font-bold">
                <td class="px-4 py-4">Net Profit / Loss</td>
                <td class="px-4 py-4 text-right">
                ₹ {{ number_format($netCurrent,2) }}
                </td>
                <td class="px-4 py-4 text-right">
                ₹ {{ number_format($netPrevious,2) }}
                </td>
                </tr>

                </tbody>
                </table>

                </div>
                </div>
                
                <!-- Tab 5 : EXPENSES -->
                <div id="tab5" class="tab-pane hidden">

                    <div class="overflow-x-auto rounded-xl border bg-white">

                        <table class="min-w-full text-sm text-left">

                            {{-- ================= HEAD ================= --}}
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">System Name</th>
                                    <th class="px-4 py-3">Group</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Bank A/C</th>
                                    <th class="px-4 py-3 text-right">Balance</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>

                            {{-- ================= BODY ================= --}}
                            <tbody class="divide-y">

                                @php $totalExpense = 0; @endphp

                                @forelse($ledgers->where('type','Expense') as $ledger)

                                    @php $totalExpense += $ledger->balance; @endphp

                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-3 font-semibold text-indigo-600">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-4 py-3 font-medium">
                                            {{ $ledger->display_name }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-500">
                                            {{ $ledger->system_name }}
                                        </td>

                                        <td class="px-4 py-3">
                                            {{ $ledger->group->display_name ?? '-' }}
                                        </td>

                                        {{-- Type Badge --}}
                                        <td class="px-4 py-3">
                                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Bank --}}
                                        <td class="px-4 py-3">
                                            @if($ledger->is_bank_acc)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                            @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-4 py-3 font-semibold text-right">
                                            ₹ {{ number_format($ledger->balance,2) }}
                                        </td>

                                        {{-- Action --}}
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('ledger.edit',$ledger->id) }}"
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition">
                                                Edit
                                            </a>
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-400">
                                            No Expense Ledgers Found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                            {{-- ================= FOOTER TOTAL ================= --}}
                            <tfoot class="bg-red-50 font-bold">
                                <tr>
                                    <td colspan="6" class="px-4 py-3 text-right">
                                        TOTAL EXPENSE
                                    </td>
                                    <td class="px-4 py-3 text-right text-red-700">
                                        ₹ {{ number_format($totalExpense,2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>

                <!-- Tab 6 : REVENUE ONLY -->
                <div id="tab6" class="tab-pane hidden">

                    <div class="overflow-x-auto rounded-xl border bg-white">

                        <table class="min-w-full text-sm">

                            {{-- ================= HEAD ================= --}}
                            <thead class="bg-gray-100 font-bold uppercase text-xs">
                                <tr>
                                    <th class="px-4 py-3 text-left">PARTICULARS</th>
                                    <th class="px-4 py-3 text-right">CURRENT</th>
                                    <th class="px-4 py-3 text-right">PREVIOUS</th>
                                </tr>
                            </thead>

                            {{-- ================= BODY ================= --}}
                            <tbody>

                                @php
                                    $totalRevenueCurrent = 0;
                                    $totalRevenuePrevious = 0;
                                @endphp

                                @forelse($revenues as $row)

                                    @php
                                        $totalRevenueCurrent += $row['current'];
                                        $totalRevenuePrevious += $row['previous'];
                                    @endphp

                                    <tr class="border-b hover:bg-gray-50">

                                        <td class="px-4 py-2 font-medium">
                                            {{ $row['name'] }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            ₹ {{ number_format($row['current'],2) }}
                                        </td>

                                        <td class="px-4 py-2 text-right">
                                            ₹ {{ number_format($row['previous'],2) }}
                                        </td>

                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-6 text-gray-400">
                                            No Revenue Data Found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                            {{-- ================= TOTAL ================= --}}
                            <tfoot class="bg-green-100 font-bold text-lg">
                                <tr>
                                    <td class="px-4 py-3">
                                        TOTAL REVENUE
                                    </td>

                                    <td class="px-4 py-3 text-right text-green-700">
                                        ₹ {{ number_format($totalRevenueCurrent,2) }}
                                    </td>

                                    <td class="px-4 py-3 text-right text-green-700">
                                        ₹ {{ number_format($totalRevenuePrevious,2) }}
                                    </td>
                                </tr>
                            </tfoot>

                        </table>

                    </div>
                </div>

            </div>

        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // Tab switching logic
                tabs.forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();

                        // Remove active state from all tabs & hide all panes
                        tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                        tabPanes.forEach(p => p.classList.add('hidden'));

                        // Activate clicked tab and show its pane
                        tab.classList.add('active', 'text-primary', 'border-primary');
                        const targetPane = document.getElementById(tab.dataset.tab);
                        if (targetPane) targetPane.classList.remove('hidden');
                    });
                });
            });
        </script>


@endsection