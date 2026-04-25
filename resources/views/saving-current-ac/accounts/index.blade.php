@extends('layout.main')
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h4 class="h3">SAVING / CURRENT ACCOUNTS</h4>
            <a class="btn-primary text-sm" href="{{ route('accounts.create') }}">
                ADD
            </a>
        </div>

        <!-- Latest Transactions -->
        <div class="box col-span-12 lg:col-span-6">
            <x-searchbox />
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>
            <div class="overflow-x-auto pb-4 lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead class="custom-thead" style="background-color: bisque;">
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            @php
                                $headers = [
                                    'ASSOCIATE',
                                    'TYPE',
                                    'SCHEME',
                                    'A/C NO.',
                                    'CUSTOMER NAME',
                                    'JOINT A/C',
                                    'BALANCE',
                                    'ACTION',
                                ];
                            @endphp
                            @foreach ($headers as $index => $header)
                                <th
                                    class="{{ $header === 'Action' ? 'text-center' : 'text-start' }} py-5 px-6 min-w-[100px] cursor-pointer uppercase">
                                    <div class="flex items-center gap-1">
                                        {{ $header }}
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
                            <tr class="border-b dark:even:bg-bg3">

                                {{-- Associate --}}
                                <td class="text-start py-5 px-6">
                                    @if ($lastAdvisorId !== $Account->advisor_id)
                                        {{ $Account->users ? $Account->users->fname . ' ' . $Account->users->lname : '-' }}
                                        @php $lastAdvisorId = $Account->advisor_id; @endphp
                                    @else
                                        {{-- Empty cell for repeated advisor --}}
                                    @endif
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

                                            <!-- Icon -->
                                            <div class="w-9 h-9 flex items-center justify-center bg-blue-100 rounded-full">
                                                <i class="las la-user text-blue-600 text-sm"></i>
                                            </div>

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
                                <td class="text-center py-5 px-6">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options', [
                                            'id' => base64_encode($Account->id),
                                            'viewRoute' => 'accounts.show',
                                        ])
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
