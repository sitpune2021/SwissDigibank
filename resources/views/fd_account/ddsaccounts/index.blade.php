@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h3 class="h2">DD ACCOUNTS</h3>
            <a class="btn-primary flex items-center gap-2" href="{{ route('dds-accounts.create') }}">
                Add
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
                        <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold ">
                            <th class="px-6 py-3 text-center">ASSOCIATE</th>
                            <th class="px-6 py-3 text-center">COLLECTOR</th>
                            <th class="px-6 py-3 text-center">GROUP</th>
                            <th class="px-6 py-3 text-center">DD NO</th>
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
                            <th class="px-6 py-3 text-center">INST CANCELED</th>
                            <th class="px-6 py-3 text-center">TOTAL INST NOT DUE</th>
                            <th class="px-6 py-3 text-center">OPEN DATE</th>
                            <th class="px-6 py-3 text-center">MATURITY DATE</th>
                            <th class="px-6 py-3 text-center">FREQUENCY</th>
                            <th class="px-6 py-3 text-center">STATUS</th>
                            <th class="px-6 py-3 text-center">ACTION</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ddaccounts as $ddaccount)
                            <tr class="border-t">
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member?->general_advisor_staff ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member?->general_advisor_staff ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member?->general_group ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ $ddaccount?->id ? route('dds-accounts.show', $ddaccount->id) : '#' }}"
                                        class="text-primary hover:underline">
                                        DDA {{ $ddaccount->id }}
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center"><a
                                        href="{{ $ddaccount?->member?->id ? route('member.show', $ddaccount->member->id) : '#' }}"
                                        class="text-primary hover:underline">
                                        {{ $ddaccount->member?->member_no ??
                                            ($ddaccount->member?->id ? str_pad($ddaccount->member->id, 6, '0', STR_PAD_LEFT) : 'N/A') }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ trim(($ddaccount->member->member_info_first_name ?? '') . ' ' . ($ddaccount->member->member_info_middle_name ?? '') . ' ' . ($ddaccount->member->member_info_last_name ?? '')) ?: 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member->minor?->first_name ?? '' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member->branch?->branch_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->scheme->scheme_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ number_format($ddaccount->dd_amount, 2) }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->total_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->paid_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->due_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->overdue_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->canceled_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->not_due_installments ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->open_date?->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ ucwords($ddaccount->rd_dd_frequency ?? '-') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($ddaccount->status === 0)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-warning/20 py-2 text-center text-xs text-warning dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Pending
                                        </span>
                                    @elseif ($ddaccount->status === 1)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-success/20 py-2 text-center text-xs text-success dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
                                            Approved
                                        </span>
                                    @elseif ($ddaccount->status === 2)
                                        <span
                                            class="block w-28 rounded-[30px] border border-n30 bg-danger/20 py-2 text-center text-xs text-danger dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
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
                                            'viewRoute' => 'dds-accounts.show',
                                        ])

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-pagination :paginator="$ddaccounts" />
        </div>
    </div>
    </div>
@endsection
