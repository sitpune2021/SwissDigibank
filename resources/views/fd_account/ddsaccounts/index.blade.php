@extends('layout.main')

@section('content')
    <div class="main-inner">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
            <h3 class="h2">DD Accounts</h3>
            <a class="btn-primary flex items-center gap-2" href="{{ route('dds-accounts.create') }}">
                <i class="text-base  md:text-lg"></i>
                Add
            </a>
        </div>
        <!-- Alpine.js for toggle -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <div class="mt-6" x-data="{ open: false }">
            <!-- Header -->
            <div class="bg-primary text-white font-semibold px-4 py-3 rounded-10 flex justify-between items-center cursor-pointer"
                @click="open = !open">
                <span>Search Box</span>
                <button type="button" class="text-white text-xl font-bold focus:outline-none"
                    x-text="open ? '-' : '+'"></button>
            </div>
            <!-- Collapsible Body -->
            <div class="bg-white dark:bg-bg3 border border-gray-200 rounded-10 shadow-md overflow-hidden transition-all duration-500"
                x-show="open" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="max-h-0 opacity-0" x-transition:enter-end="max-h-screen opacity-100"
                x-transition:leave="transition ease-in duration-500" x-transition:leave-start="max-h-screen opacity-100"
                x-transition:leave-end="max-h-0 opacity-0">

                <!-- Search Form -->
                <form class="grid grid-cols-2 gap-6 p-6">
                    <!-- Field 1 -->
                    <div>
                        <label class="md:text-lg font-medium block mb-2">
                            Scheme Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="scheme_name"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-xl px-4 py-3"
                            placeholder="Enter Scheme Name">
                    </div>
                    <!-- Field 2 -->
                    <div>
                        <label class="md:text-lg font-medium block mb-2">
                            Scheme Code <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="scheme_code"
                            class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-xl px-4 py-3"
                            placeholder="Enter Scheme Code">
                    </div>
                </form>
                <div class="flex justify-center gap-4 pb-6">
                    <button class="btn-primary px-6 py-2 rounded-full" type="submit">
                        Save Scheme
                    </button>
                    <button class="btn-outline px-6 py-2 rounded-full " type="reset">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="col-span-12 box lg:col-span-6">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full border border-n30 rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3 text-sm font-semibold">
                            <th class="px-6 py-3 text-center">ASSOCIATE</th>
                            <th class="px-6 py-3 text-center">COLLECTOR</th>
                            <th class="px-6 py-3 text-center">GROUP</th>
                            <th class="px-6 py-3 text-center">DD NO</th>
                            <th class="px-6 py-3 text-center">MEMBER NO</th>
                            <th class="px-6 py-3 text-center">MEMBER NAME</th>
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
                                <td class="px-6 py-4 text-center">{{ $ddaccount->advisor?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->collectionAdvisor?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->group?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('dds-accounts.show', $ddaccount->id) }}"
                                        class="text-primary hover:underline">
                                        DDA {{ $ddaccount->id }}
                                    </a>
                                </td>

                                <td><a href="{{ route('member.show', $ddaccount->member->id) }}"
                                        class="text-primary hover:underline">
                                        {{ $ddaccount->member->member_info_first_name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member->member_info_first_name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member->minor?->first_name ?? '' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->member->branch?->branch_name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->scheme?->scheme_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ number_format($ddaccount->dd_amount, 2) }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->total_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->paid_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->due_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->overdue_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->canceled_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->not_due_installments ?? '-' }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->open_date?->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->maturity_date?->format('d-m-Y') }}</td>
                                <td class="px-6 py-4 text-center">{{ $ddaccount->scheme?->payout_frequency ?? '-' }}</td>
                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($ddaccount->status === 'active')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Active</span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="relative">
                                        <a href="{{ route('dds-accounts.show', $ddaccount->id) }}"
                                            class="btn btn-default btn-xs" title="View">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
