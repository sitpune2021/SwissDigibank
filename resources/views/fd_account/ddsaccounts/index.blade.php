@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h4 class="h2 text-lg">DD ACCOUNTS</h4>
            <a class="btn-primary flex items-center gap-2" href="{{ route('dds-accounts.create') }}">
                ADD
            </a>
        </div>
        <!-- Alpine.js for toggle -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <!-- Table -->
        <div class="col-span-12 box lg:col-span-6">
            <x-searchbox />
            <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
                <x-alert />
            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full border border-n30 rounded-lg whitespace-nowrap overflow-hidden">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3  font-semibold ">
                            <th class="px-6 py-3 text-start">ASSOCIATE</th>
                            <th class="px-6 py-3 text-start">COLLECTOR</th>
                            <th class="px-6 py-3 text-start">GROUP</th>
                            <th class="px-6 py-3 text-start">DD NO</th>
                            <th class="px-6 py-3 text-start">CUSTOMER NO</th>
                            <th class="px-6 py-3 text-start">CUSTOMER NAME</th>
                            <th class="px-6 py-3 text-start">MINOR</th>
                            <th class="px-6 py-3 text-start">BRANCH</th>
                            <th class="px-6 py-3 text-start">SCHEME</th>
                            <th class="px-6 py-3 text-start">AMOUNT</th>
                            <th class="px-6 py-3 text-start">TOTAL INST</th>
                            <th class="px-6 py-3 text-start">PAID INST</th>
                            <th class="px-6 py-3 text-start">DUE INST</th>
                            <th class="px-6 py-3 text-start">OVERDUE INST</th>
                            <th class="px-6 py-3 text-start">INST CANCELED</th>
                            <th class="px-6 py-3 text-start">TOTAL INST NOT DUE</th>
                            <th class="px-6 py-3 text-start">OPEN DATE</th>
                            <th class="px-6 py-3 text-start">MATURITY DATE</th>
                            <th class="px-6 py-3 text-start">FREQUENCY</th>
                            <th class="px-6 py-3 text-start">STATUS</th>
                            <th class="px-6 py-3 text-start">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ddaccounts as $ddaccount)
                            <tr class="border-t">
                                <td class="px-6 py-4 text-start">{{ $ddaccount->member?->general_advisor_staff ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->member?->general_advisor_staff ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->member?->general_group ?? '-' }}</td>
                                <td class="px-6 py-4 text-start">
                                    <a href="{{ $ddaccount?->id ? route('ddsaccounts.show', $ddaccount->id) : '#' }}"
                                        class="text-primary hover:underline">
                                        {{ $ddaccount->dd_no }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-start"><a
                                        href="{{ $ddaccount?->member?->id ? route('member.show', $ddaccount->member->id) : '#' }}"
                                        class="text-primary hover:underline">
                                        {{ $ddaccount->member?->member_no ??
                                            ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : 'N/A') }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-start">
                                    {{ trim(($ddaccount->member->member_info_first_name ?? '') . ' ' . ($ddaccount->member->member_info_middle_name ?? '') . ' ' . ($ddaccount->member->member_info_last_name ?? '')) ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->member->minor?->first_name ?? '' }}</td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->member->branch?->branch_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->scheme->scheme_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-start">{{ number_format($ddaccount->dd_amount, 2) }}</td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->scheme->tenure_of_rd_dd_value ?? '-' }}</td>
                                
                                <td class="px-6 py-4 text-start">{{ $ddaccount->paid_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->due_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->overdue_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->canceled_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->not_due_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->open_date?->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-start">{{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-start">{{ ucwords($ddaccount->rd_dd_frequency ?? '-') }}</td>
                                <td class="px-6 py-4 text-start">
                                    @if ($ddaccount->status === 0)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Pending
                                        </span>
                                    @elseif ($ddaccount->status === 1)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Approved
                                        </span>
                                    @elseif ($ddaccount->status === 2)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Not Approved
                                        </span>
                                    @else
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-gray-200 py-2 text-center text-xs text-gray-600 dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Unknown
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2 px-6">
                                    <div class="flex justify-center">
                                        @include('partials._vertical-options', [
                                            'id' => $ddaccount->id,
                                            'viewRoute' => 'ddsaccounts.show',
                                        ])

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
