@extends('layout.main')

<style>
    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-xl font-semibold">
                MIS PAYOUTS — {{ 'MIS-' . $misAccount->id }}
            </h1>
            <p class="text-gray-500 text-sm">
                <a href="" class="text-gray-500">MIS Accounts</a> >
                <a href="#" class="text-gray-500">Payouts</a>
            </p>
        </div>
    </div>

    <div class="mx-auto max-w-5xl box px-6 py-4">
        <div class="overflow-x-auto shadow-sm dark:bg-bg3">
            <table class="w-full whitespace-nowrap text-sm border-collapse">
                <thead class="bg-secondary/5 text-black text-sm font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-4 py-2 text-lg text-start">Year</th>
                        <th class="px-4 py-2 text-lg text-start">Period</th>
                        <th class="px-4 py-2 text-lg text-start">Days</th>
                        <th class="px-4 py-2 text-lg text-start">Principal</th>
                        <th class="px-4 py-2 text-lg text-start">Interest (A)</th>
                        <th class="px-4 py-2 text-lg text-start">TDS (B)</th>
                        <th class="px-4 py-2 text-lg text-start">Net Interest (A - B)</th>
                        <th class="px-4 py-2 text-lg text-start">Due Date</th>
                        <th class="px-4 py-2 text-lg text-start">Payout Status</th>
                        <th class="px-4 py-2 text-lg text-start">Processed</th>
                        <th class="px-4 py-2 text-lg text-start">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($payouts) && count($payouts) > 0)
                    @php
                    // Group payouts by year (assuming 12 months = 1 year)
                    // $groupedPayouts = collect($payouts)->groupBy(function($payout) {
                    // return ceil(((int)$payout['period']) / 12);
                    //});
                    $groupedPayouts = collect($payouts)->values()->groupBy(function($payout, $index) {
                    return ceil(($index + 1) / 13);
                    });


                    @endphp

                    @foreach($groupedPayouts as $year => $yearPayouts)
                    @foreach($yearPayouts as $index => $payout)
                    <tr id="payout-row-{{ $loop->parent->index ?? $index }}" class="border-b">
                        {{-- Year column with rowspan --}}
                        @if($loop->first)
                        <td class="text-center py-2" rowspan="{{ count($yearPayouts) }}">
                            {{ $year }}
                        </td>
                        @endif

                        <td class="text-center py-5">{{ $payout['from'] ?? '-' }} - {{ $payout['to'] ?? '-' }}</td>
                        <td class="text-center py-5">{{ $payout['days'] }}</td>
                        <td class="text-center py-5">{{ number_format((float) $payout['principal'], 2) }}</td>
                        <td class="text-center py-5">{{ number_format((float) $payout['interest'], 2) }}</td>
                        <td class="text-center py-5">{{ number_format((float) $payout['tds'], 2) }}</td>
                        <td class="text-center py-5">{{ number_format((float) $payout['net_interest'], 2) }}</td>
                        <td class="text-center py-5">{{ \Carbon\Carbon::parse($payout['due_date'])->format('d-m-Y') }}</td>

                        <td class="text-center py-5" id="state-label-{{ $loop->parent->index ?? $index }}">
                            @if(isset($payout['processed']) && $payout['processed'] == 1)
                            <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-xs text-primary text-center">
                                Paid
                            </span>
                            @else
                            <span class="block w-28 rounded-[30px] border border-n30 bg-error/10 py-2 text-xs text-error text-center">
                                Pending
                            </span>
                            @endif
                        </td>

                        <td class="text-center py-5" id="processed-label-{{ $loop->parent->index ?? $index }}">
                            @if($payout['processed'] == 1)
                            <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Yes</span>
                            @else
                            <span class="block w-28 rounded-[30px] border bg-error/10 py-2 text-xs text-error">No</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="text-center">

                            @php
                            $today = \Carbon\Carbon::today();
                            $dueDate = \Carbon\Carbon::parse($payout['due_date_db'] ?? $payout['due_date']);

                            $hasUnprocessedBefore = false;
                            foreach ($yearPayouts as $i => $p) {
                            if ($i < $index && $p['processed']==0) {
                                $hasUnprocessedBefore=true;
                                break;
                                }
                                }
                                $showButton=($payout['processed']==0 && !$hasUnprocessedBefore && $today->greaterThanOrEqualTo($dueDate));
                                @endphp

                                @if($showButton)
                                <button class="btn btn-primary rounded-10 py-2 process-btn"
                                    data-index="{{ $loop->parent->index ?? $index }}"
                                    data-id="{{ $misAccount->id }}"
                                    data-due="{{ $payout['due_date'] }}">
                                    Process
                                </button>
                                @endif
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                    @else
                    <tr>
                        <td colspan="11" class="text-center text-muted">No MIS payout records available</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- AJAX Payout Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.process-btn').click(function() {
            var index = $(this).data('index');
            var misId = $(this).data('id');
            var dueDate = $(this).data('due'); // likely in DD-MM-YYYY format


            var row = $('#payout-row-' + index);
            var principal = row.find('td:eq(3)').text().replace(/,/g, '');
            var interest = row.find('td:eq(4)').text().replace(/,/g, '');
            var tds = row.find('td:eq(5)').text().replace(/,/g, '');
            var net_interest = row.find('td:eq(6)').text().replace(/,/g, '');

            $.ajax({
                url: "{{ route('mis.processPayout', ['id' => $misAccount->id]) }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    misaccount_id: misId,
                    principal: principal,
                    interest: interest,
                    tds: tds,
                    net_interest: net_interest,
                    due_date: dueDate
                },
                success: function(response) {
                    if (response.success) {
                        // ✅ Update UI instantly
                        row.find('#processed-label-' + index).html(
                            '<span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Yes</span>'
                        );
                        row.find('#state-label-' + index).html(
                            '<span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Paid</span>'
                        );
                        row.find('.process-btn').remove();

                        setTimeout(function() {
                            location.reload();
                        }, 0);
                    } else {
                        alert(response.message || 'Failed to process payout.');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Something went wrong!');
                }
            });
        });
    });
</script>