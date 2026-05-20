@extends('layout.main')
@extends('layout.tablestyle')

@section('page-title')

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

    <!-- LEFT SIDE -->
    <div class="flex items-center gap-3 min-w-0">

        <!-- ICON -->
        <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl
            flex items-center justify-center shrink-0 shadow-lg"
            style="
                background: linear-gradient(135deg,#2563eb,#06b6d4,#0ea5e9);
                min-width:44px;
                min-height:44px;
            ">

            <i class="las la-university text-white text-xl sm:text-2xl leading-none"></i>

        </div>

        <!-- TITLE -->
        <div class="min-w-0">

            <h2 class="text-lg sm:text-xl lg:text-2xl
                font-extrabold uppercase tracking-wide
                text-gray-800 leading-tight truncate">

                SAVING / CURRENT ACCOUNTS Management

            </h2>

            <p class="text-[11px] sm:text-sm text-gray-500 font-medium mt-1">

                Manage account schemes, opening balance and account settings.

            </p>

        </div>

    </div>

    <!-- RIGHT BADGE -->
    <div class="hidden md:flex items-center gap-2
        px-4 py-2 rounded-xl
        bg-gradient-to-r from-slate-100 to-slate-50
        border border-slate-200 shadow-sm">

        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>

        <span class="text-xs font-bold uppercase tracking-wider text-slate-600">

            Banking Panel

        </span>

    </div>

</div>

@endsection

@php
    $permissions = auth()->user()->rolePermission->permissions ?? [];
    $isSuperAdmin = auth()->user()->role_id == 1;
@endphp

@section('action-button')
@if($isSuperAdmin || in_array('accounts.create', $permissions))
<a href="{{ route('accounts.create') }}"
    class="inline-flex items-center gap-2
    px-4 sm:px-5 py-2.5
    rounded-xl text-xs sm:text-sm font-bold uppercase
    shadow-lg transition-all duration-300 hover:scale-105"
    style="background:linear-gradient(90deg,#e1d315,#e30f0f); color:#111;">
    <span>Add SAVING / CURRENT</span>
</a>
@endif
@endsection

@section('content')

<div class="box col-span-12 lg:col-span-6 bank-page-animate">

    <x-searchbox />
    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4 lg:pb-6 table-premium">

        <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
            
            <thead
                class="sticky top-0 z-10
                bg-gradient-to-r from-orange-50 via-white to-orange-50
                border-b border-slate-200">

                <tr
                    class="text-[10px] sm:text-xs lg:text-sm
                    font-extrabold uppercase tracking-wider text-slate-700">

                    @php
                        $headers = [
                            ['title' => 'SR.NO.', 'icon' => 'las la-hashtag', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                            ['title' => 'Type', 'icon' => 'las la-id-card', 'bg' => 'bg-violet-50', 'text' => 'text-violet-600'],
                            ['title' => 'Scheme', 'icon' => 'las la-layer-group', 'bg' => 'bg-orange-50', 'text' => 'text-orange-600'],
                            ['title' => 'A/C No.', 'icon' => 'las la-university', 'bg' => 'bg-cyan-50', 'text' => 'text-cyan-600'],
                            ['title' => 'Customer Name', 'icon' => 'las la-user', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                            ['title' => 'Joint A/C', 'icon' => 'las la-users', 'bg' => 'bg-pink-50', 'text' => 'text-pink-600'],
                            ['title' => 'Balance', 'icon' => 'las la-wallet', 'bg' => 'bg-green-50', 'text' => 'text-green-600'],
                            ['title' => 'Action', 'icon' => 'las la-cog', 'bg' => 'bg-gray-50', 'text' => 'text-gray-700'],
                        ];
                    @endphp

                    @foreach ($headers as $header)

                        <th
                            class="{{ $header['title'] == 'Action' ? 'text-center' : 'text-start' }}
                            py-3 px-3 whitespace-nowrap">

                            <div
                                class="flex items-center gap-2 min-w-max
                                {{ $header['title'] == 'Action' ? 'justify-center' : '' }}">

                                <!-- ICON -->
                                <div
                                    class="w-7 h-7 rounded-xl
                                    flex items-center justify-center shrink-0
                                    border border-white/60 shadow-sm
                                    {{ $header['bg'] }}">

                                    <i
                                        class="{{ $header['icon'] }}
                                        {{ $header['text'] }}
                                        text-base">
                                    </i>

                                </div>

                                <!-- TITLE -->
                                <span>
                                    {{ $header['title'] }}
                                </span>

                            </div>

                        </th>

                    @endforeach

                </tr>

            </thead>

                @php
                    $lastAdvisorId = null;
                @endphp

            <tbody>
                @foreach ($Accounts as $index => $Account)
                    <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                        style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                        <!-- SR NO -->
                        <td class="px-6 py-5 text-center font-semibold text-gray-700">

                            {{ $loop->iteration }}

                        </td>

                        {{-- Type --}}
                        <td class="text-start py-5 px-6">{{ $Account->account_type ?? '-' }}</td>

                        {{-- Scheme Name --}}
                        <td class="text-start py-5 px-6">
                            {{ $Account->scheme->scheme_name ?? '-' }}
                        </td>

                        {{-- A/C NO. --}}
                        <td class="text-start py-5 px-6">
                            <a href="{{ $Account?->id ? route('accounts.show', base64_encode($Account->id)) : '#' }}"
                                class="text-primary underline hover:text-primary/80">
                                {{ $Account->account_no ?? '-' }}
                            </a>
                        </td>

                        {{-- Member Name --}}
                        <td class="px-4 py-3">
                            @if ($Account->members)
                                <a href="{{ route('member.show', $Account->members->id) }}"
                                    class="flex items-center gap-3 group">

                                    <!-- Member Info -->
                                    <div class="leading-tight">
                                                
                                        <!-- Member Name -->
                                        <p class="font-semibold text-primary group-hover:text-green-600 transition">
                                            {{ ucfirst($Account->members->member_info_first_name ?? '') }}
                                            {{ ucfirst($Account->members->member_info_last_name ?? '') }}
                                        </p>

                                        <!-- Member ID -->
                                        <p class="text-xs text-gray-400">
                                            Customer No : {{ str_pad($Account->members->id, 6, '0', STR_PAD_LEFT) }}
                                        </p>

                                    </div>

                                </a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>

                        {{-- joint_account --}}
                        <td class="text-start py-5 px-6">

                            {!! $Account->account_holder_type == 'joint'
                                ? '<span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">Yes</span>'
                                : '<span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">No</span>' !!}
                        </td>

                        {{-- show Balance --}}
                        <td class="text-start py-5 px-6">
                            <button class="text-primary uppercase show-balance-btn"
                                data-account-id="{{ $Account->id }}">
                                Show Balance
                            </button>
                            <div class="mt-2 balance-output" id="balance-{{ $Account->id }}"></div>
                        </td>

                        {{-- Balance --}}
                        {{-- Action --}}
                        <td class="px-4 py-3 text-center">

                            <div class="flex items-center justify-center gap-2 whitespace-nowrap">

                                <!-- VIEW -->
                                @if($isSuperAdmin || in_array('accounts.show', $permissions))
                                <a href="{{ route('accounts.show', base64_encode($Account->id)) }}"
                                    class="action-btn action-view">

                                    <i class="las la-eye text-sm"></i>

                                    <span>View</span>

                                </a>
                                @endif

                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>

        <div class="mt-5">
            <x-pagination :paginator="$Accounts" />
        </div>

</div>
        

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.show-balance-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const accountId = this.getAttribute('data-account-id');
                    const outputDiv = document.getElementById('balance-' + accountId);

                    // Toggle display
                    if (outputDiv.style.display === 'block') {
                        outputDiv.style.display = 'none';
                        button.innerText = 'Show Balance';
                        return;
                    }

                    fetch("{{ route('ajax.get.account.balance') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                account_id: accountId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            outputDiv.innerText = "Balance: ₹" + parseFloat(data.balance)
                                .toFixed(2);
                            outputDiv.style.display = 'block';
                            button.innerText = 'Hide Balance';
                        })
                        .catch(err => {
                            outputDiv.innerText = "Error fetching balance.";
                            outputDiv.style.display = 'block';
                            console.error(err);
                        });
                });
            });
        });
    </script>
    
@endsection
