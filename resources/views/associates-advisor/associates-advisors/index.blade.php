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
            <h4 class=" flex text-xl block  uppercase  font-bold">
                Associates/ Advisors
            </h4>
            <div class="flex flex-col md:flex-row  lg:flex-row gap-3">
                <a href="{{ route('associates-advisor.associates-advisors.add') }}" class=" block flex btn-primary justify-center uppercase ">
                    ADD
                </a>
            </div>

        </div>
        <div class="col-span-12 box lg:col-span-12">


            <div class="tab-content p-4">
                <!-- Tab 1 -->
                <div id="tab1" class="tab-pane block">
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse whitespace-nowrap text-sm">
                            <thead>
                                <tr class="bg-secondary/5 dark:bg-bg3">
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            SUPERVISOR
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ADVISOR CODE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            RANK/ POSITION
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                        <div class="flex  text-lg  uppercase items-center gap-1">
                                            NAME
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            LOGIN USERNAME
                                        </div>
                                    </th>

                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ROLES
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            BRANCHES
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ENROLL DATE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACTIVE
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            LOCKED
                                        </div>
                                    </th>
                                    <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                        <div class="flex text-lg uppercase items-center gap-1">
                                            ACTIONS
                                        </div>
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($associates as $a)
                                <tr>
                                    {{-- SUPERVISOR --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->supervisor->first_name ?? 'N/A' }}
                                    </td>

                                    {{-- ADVISOR CODE (employee_id) --}}
                                    <td class="text-start !py-5 px-6">
                                        <a href="" class="text-primary">
                                            {{ $a->employee_id }}
                                        </a>
                                    </td>

                                    {{-- RANK --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->rank }}
                                    </td>

                                    {{-- NAME --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->first_name }} {{ $a->last_name }}
                                    </td>

                                    {{-- LOGIN USERNAME --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->username }}
                                    </td>

                                    {{-- ROLE --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->role ?? 'N/A' }}
                                    </td>

                                    {{-- BRANCH --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ $a->branch_id }}
                                    </td>

                                    {{-- ENROLL DATE --}}
                                    <td class="text-start !py-5 px-6">
                                        {{ \Carbon\Carbon::parse($a->enrollment_date)->format('d-m-Y') }}
                                    </td>

                                    {{-- ACTIVE --}}
                                    <td class="text-start !py-5 px-6">
                                        @if($a->active == 1)
                                            <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-center text-xs text-primary">
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border bg-error/20 py-2 text-center text-xs text-error">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- LOCKED --}}
                                    <td class="text-start !py-5 px-6">
                                        @if($a->login_holiday == 'yes')
                                            <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-center text-xs text-primary">
                                                Yes
                                            </span>
                                        @else
                                            <span class="block w-28 rounded-[30px] border bg-error/20 py-2 text-center text-xs text-error">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="text-start !py-5 px-6">
                                        <div class="relative">
                                            <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                            <ul class="horiz-option popover-content">
                                                <li><a href="{{ route('associates-advisor.associates-advisors.view', $a->id) }}" class="single-option uppercase">View</a></li>
                                                <li><a href="" class="single-option uppercase">Print Joining Form</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="mt-5">
                    <a href="" class="btn-error rounded-10 py-2">
                        <i></i>
                        Download
                    </a>
                </div>
            </div>
            
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const tabPanes = document.querySelectorAll('.tab-pane');

                // ✅ Set the first tab active by default
                if (tabs.length > 0 && tabPanes.length > 0) {
                    tabs.forEach(t => t.classList.remove('active', 'text-primary', 'border-primary'));
                    tabPanes.forEach(p => p.classList.add('hidden'));

                    tabs[0].classList.add('active', 'text-primary', 'border-primary');
                    tabPanes[0].classList.remove('hidden');
                }

                // ✅ Tab switching logic
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