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
                        <button data-tab="tab2" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            ASSETS
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab3" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            LIABILITIES
                        </button>
                    </li>
                    <li class="me-2">
                        <button data-tab="tab4" class="tab-link inline-block p-4 border-b-2 border-transparent text-lg">
                            EQUITY
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

                <!-- Tab 2 -->
                <div id="tab2" class="tab-pane hidden">
                        {{-- Table --}}
                        <div class="overflow-x-auto rounded-xl border">

                            <table class="min-w-full text-sm text-left">

                                {{-- Head --}}
                                <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3">Code</th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">System Name</th>
                                        <th class="px-4 py-3">Group</th>
                                        <th class="px-4 py-3">Type</th>
                                        <th class="px-4 py-3">Bank A/C</th>
                                        <th class="px-4 py-3">Balance</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>

                                {{-- Body --}}
                                <tbody class="divide-y">

                                @foreach($ledgers->where('type','Asset') as $ledger)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-3 font-semibold text-indigo-600">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-4 py-3">
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
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Bank Yes/No Badge --}}
                                        <td class="px-4 py-3">
                                            @if($ledger->is_bank_acc)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                            @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-4 py-3 font-semibold">
                                            ₹ {{ number_format($ledger->opening_balance,2) }}
                                        </td>

                                        {{-- Action --}}
                                        <td class="px-4 py-3 text-center">

                                            <a href=""
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition btn-primary">
                                                Edit
                                            </a>

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        </div>
                </div>

                <!-- Tab 3 -->
                <div id="tab3" class="tab-pane hidden">
                    <div class="bg-white rounded-2xl shadow-lg p-4">

                        {{-- Table --}}
                        <div class="overflow-x-auto rounded-xl border">

                            <table class="min-w-full text-sm text-left">

                                {{-- Head --}}
                                <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3">Code</th>
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">System Name</th>
                                        <th class="px-4 py-3">Group</th>
                                        <th class="px-4 py-3">Type</th>
                                        <th class="px-4 py-3">Bank A/C</th>
                                        <th class="px-4 py-3">Balance</th>
                                        <th class="px-4 py-3 text-center">Action</th>
                                    </tr>
                                </thead>

                                {{-- Body --}}
                                <tbody class="divide-y">

                                @foreach($ledgers->where('type','lability') as $ledger)
                                    <tr class="hover:bg-gray-50 transition">

                                        <td class="px-4 py-3 font-semibold text-indigo-600">
                                            {{ $ledger->code }}
                                        </td>

                                        <td class="px-4 py-3">
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
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                                {{ $ledger->type }}
                                            </span>
                                        </td>

                                        {{-- Bank Yes/No Badge --}}
                                        <td class="px-4 py-3">
                                            @if($ledger->is_bank_acc)
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                            @else
                                                <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                            @endif
                                        </td>

                                        {{-- Balance --}}
                                        <td class="px-4 py-3 font-semibold">
                                            ₹ {{ number_format($ledger->opening_balance,2) }}
                                        </td>

                                        {{-- Action --}}
                                        <td class="px-4 py-3 text-center">

                                            <a href=""
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition btn-primary">
                                                Edit
                                            </a>

                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

                <!-- Tab 4 -->
                <div id="tab4" class="tab-pane hidden">
                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-xl border">

                        <table class="min-w-full text-sm text-left">

                            {{-- Head --}}
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">System Name</th>
                                    <th class="px-4 py-3">Group</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Bank A/C</th>
                                    <th class="px-4 py-3">Balance</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Equity') as $ledger)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 font-semibold text-indigo-600">
                                        {{ $ledger->code }}
                                    </td>

                                    <td class="px-4 py-3">
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
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-4 py-3">
                                        @if($ledger->is_bank_acc)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                        @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-4 py-3 font-semibold">
                                        ₹ {{ number_format($ledger->opening_balance,2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                        <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition btn-primary">
                                            Edit
                                        </a>

                                    </td>

                                </tr>
                            @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- Tab 5 -->
                <div id="tab5" class="tab-pane hidden">
                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-xl border">

                        <table class="min-w-full text-sm text-left">

                            {{-- Head --}}
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">System Name</th>
                                    <th class="px-4 py-3">Group</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Bank A/C</th>
                                    <th class="px-4 py-3">Balance</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Expense') as $ledger)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 font-semibold text-indigo-600">
                                        {{ $ledger->code }}
                                    </td>

                                    <td class="px-4 py-3">
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
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-4 py-3">
                                        @if($ledger->is_bank_acc)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                        @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-4 py-3 font-semibold">
                                        ₹ {{ number_format($ledger->opening_balance,2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                        <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition btn-primary">
                                            Edit
                                        </a>

                                    </td>

                                </tr>
                            @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

                <!-- Tab 6 -->
                <div id="tab6" class="tab-pane hidden">
                     {{-- Table --}}
                    <div class="overflow-x-auto rounded-xl border">

                        <table class="min-w-full text-sm text-left">

                            {{-- Head --}}
                            <thead class="bg-gray-100 text-gray-700 uppercase text-xs sticky top-0">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">System Name</th>
                                    <th class="px-4 py-3">Group</th>
                                    <th class="px-4 py-3">Type</th>
                                    <th class="px-4 py-3">Bank A/C</th>
                                    <th class="px-4 py-3">Balance</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>

                            {{-- Body --}}
                            <tbody class="divide-y">

                            @foreach($ledgers->where('type','Revenue') as $ledger)
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 font-semibold text-indigo-600">
                                        {{ $ledger->code }}
                                    </td>

                                    <td class="px-4 py-3">
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
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">
                                            {{ $ledger->type }}
                                        </span>
                                    </td>

                                    {{-- Bank Yes/No Badge --}}
                                    <td class="px-4 py-3">
                                        @if($ledger->is_bank_acc)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full">Yes</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full">No</span>
                                        @endif
                                    </td>

                                    {{-- Balance --}}
                                    <td class="px-4 py-3 font-semibold">
                                        ₹ {{ number_format($ledger->opening_balance,2) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-3 text-center">

                                        <a href=""
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs hover:bg-indigo-700 transition btn-primary">
                                            Edit
                                        </a>

                                    </td>

                                </tr>
                            @endforeach

                            </tbody>

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