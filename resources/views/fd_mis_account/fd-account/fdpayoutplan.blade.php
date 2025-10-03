@extends('layout.main')

<style>
  input[type="checkbox"] {
    width: 28px;
    height: 28px;
    accent-color: green;
    /* For modern browsers */
  }

  /* Fallback for browsers without accent-color support */
  input[type="checkbox"]:checked {
    background-color: green;
    border: none;
  }

  input[type="radio"] {
    width: 24px;
    height: 24px;
    accent-color: green;
    /* Modern browser support */
  }

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
  <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
    <div class="flex items-start flex-col  gap-2">
      <h1 class="text-xl font-semibold"> FD PAYOUTS -{{$fdAccount->id}} </h1>
      <p class="text-gray-500">
        <a href="{{route('fd-mis-schemes.fd_index')}}" class="text-gray-500 text-sm">MIS Accounts</a> >

        {{-- @foreach($misaccounts as $mis) --}}
        {{-- <a href="{{ route('misaccount.show', $mis->id) }}" class="text-gray-500 text-sm"> --}}
        {{-- {{'DEMO-' . $mis->member->id }}</a> > --}}
        {{-- @endforeach --}}

        <a href="#" class="text-gray-500  text-sm"> Payouts</a>
      </p>
      {{-- {{ 'DEMO-' . $misaccount->member_id}} - {{ $misaccount->member->member_info_first_name ?? 'N/A' }} --}}
    </div>

  </div>
  <div class="overflow-x-auto box">
    <table class="min-w-full  text-sm">
      <thead class="bg-secondary/5 rounded-10  text-black text-sm font-semibold uppercase tracking-wider">
        <tr>
          <th class="px-4 py-2 text-center">Year</th>
          <th class="px-4 py-2 text-center">Period</th>
          <th class="px-4 py-2 text-center">Days</th>
          <th class="px-4 py-2 text-right">Principal</th>
          <th class="px-4 py-2 text-right">Interest <br>(A)</th>
          <th class="px-4 py-2 text-right">TDS <br>(B)</th>
          <th class="px-4 py-2 text-right">Net Interest <br>(A - B)</th>
          <th class="px-4 py-2 text-right">Net Interest <br>on Due Date</th>
          <th class="px-4 py-2 text-center">Due Date</th>
          <th class="px-4 py-2 text-center">Payout <br>State</th>
          <th class="px-4 py-2 text-center">Processed</th>
          <th class="px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @if(!empty($payouts) && count($payouts) > 0)
        @php
        // Group payouts by year (assuming 12 periods = 1 year)
        $groupedPayouts = collect($payouts)->groupBy(function($payout) {
        return ceil($payout['period'] / 12);
        });
        @endphp

        @foreach($groupedPayouts as $year => $yearPayouts)
        @foreach($yearPayouts as $index => $payout)
        <tr id="payout-row-{{ $loop->parent->index ?? $index }}">
          {{-- Year column with rowspan --}}
          @if($loop->first)
          <td class="text-center" rowspan="{{ count($yearPayouts) }}">
            {{ $year }}
          </td>
          @endif

          <!-- <td class="text-center">{{ $payout['period'] }}</td> -->
          <td class="text-center">{{ $payout['from'] }} - {{ $payout['to'] }}</td>
          <td class="text-center">{{ $payout['days'] }}</td>
          <td class="text-right">{{ $payout['principal'] }}</td>
          <td class="text-right">{{ $payout['interest'] }}</td>
          <td class="text-right">{{ $payout['tds'] }}</td>
          <td class="text-right">{{ $payout['net_interest'] }}</td>
          <td class="text-right">{{ $payout['net_interest'] }}</td>
          <td class="text-center">{{ $payout['due_date'] }}</td>
          <td class="text-center">
            @if($payout['status']==="Yes" )
            <span
              class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16 text-center">
              Paid
            </span>
            @endif
          </td>

          <td class="text-center">
            <span id="processed-label-{{ $loop->parent->index ?? $index }}">
              @if($payout['processed'] == 1)
              <span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Yes</span>
              @else
              <span class="block w-28 rounded-[30px] border bg-warning/10 py-2 text-xs text-warning">No</span>
              @endif
            </span>
          </td>

          {{-- Actions --}}
          <!-- <td class="text-center">
            @if($index == 0 || ($yearPayouts[$index-1]['processed'] ?? false))
            @if($payout['processed'] == 0)
            <button class="btn btn-primary process-btn"
              data-index="{{ $loop->parent->index ?? $index }}"
              data-id="{{ $fdAccount->id }}"
              data-due="{{ $payout['due_date'] }}">
              Process
            </button>
            @endif
            @endif
          </td> -->
          <td class="text-center">
            @php
            // Show button only for the first unprocessed period in each year

            $today = \Carbon\Carbon::today();
            $showButton = false;

            // Show button only if payout is unprocessed AND today's date >= period start and <= period end
              $periodStart=\Carbon\Carbon::parse($payout['from']);
              $periodEnd=\Carbon\Carbon::parse($payout['to']);

              if($payout['processed']==0 && $today->between($periodStart, $periodEnd)) {
              $showButton = true;
              }
              @endphp

              @if($showButton)
              <button class="btn btn-primary process-btn"
                data-index="{{ $loop->parent->index ?? $index }}"
                data-id="{{ $fdAccount->id }}"
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
          <td colspan="13" class="text-center text-muted">No payout records available</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
  @endsection

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.process-btn').click(function() {
        var index = $(this).data('index');
        var fdId = $(this).data('id');
        var dueDate = $(this).data('due');

        var row = $('#payout-row-' + index);
        var principal = row.find('td:eq(3)').text().replace(/,/g, '');
        var interest = row.find('td:eq(4)').text().replace(/,/g, '');
        var tds = row.find('td:eq(5)').text().replace(/,/g, '');
        var net_interest = row.find('td:eq(6)').text().replace(/,/g, '');

        $.ajax({
          url: "{{ route('fd.processPayout') }}",
          type: "POST",
          data: {
            _token: "{{ csrf_token() }}",
            fd_account_id: fdId,
            principal: principal,
            interest: interest,
            tds: tds,
            net_interest: net_interest,
            due_date: dueDate
          },
          success: function(response) {
            if (response.success) {
              row.find('#processed-label-' + index).html(
                '<span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Yes</span>'
              );
              row.find('#state-label-' + index).html(
                '<span class="block w-28 rounded-[30px] border bg-primary/20 py-2 text-xs text-primary">Paid</span>'
              );
              row.find('.process-btn').remove();
            } else {
              alert(response.message);
            }
          },
          error: function(err) {
            alert('Something went wrong!');
          }
        });
      });
    });
  </script>