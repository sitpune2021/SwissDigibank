@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg uppercase font-semibold">RD - {{ $rdAccount->id }} - Installments</h1>
        </div>
    </div>

    <!-- Installments Table -->
    <div class="p-4 bg-white dark:bg-bg3  rounded-lg">
        <table class="w-full border-collapse rounded-lg dark:bg-bg3 overflow-hidden">
            <thead class="bg-secondary/5 text-gray-700">
                <tr>
                    <th class="px-4 py-3">INSTALLMENT NO</th>
                    <th class="px-4 py-3">AMOUNT</th>
                    <th class="px-4 py-3">DUE DATE</th>
                    <th class="px-4 py-3">STATUS</th>
                    <th class="px-4 py-3">PAID ON</th>
                    <th class="px-4 py-3">ACTION</th>
                </tr>
            </thead>

            <tbody>
                @foreach($installments as $index => $inst)
                @php
                // $today = \Carbon\Carbon::today()->format('Y-m-d');
                $today = '2026-05-11';
                $previousPending = false;

                // check previous installments
                for ($x = 0; $x < $index; $x++) {
                    if ($installments[$x]['status'] !== 1) {
                    $previousPending=true;
                    break;
                    }
                    }

                    $showProcessButton = (
                        $inst['status'] !== 1 &&
                        !$previousPending &&
                        //\Carbon\Carbon::parse($inst['due_date'])->lte(\Carbon\Carbon::today())
                        \Carbon\Carbon::parse($inst['due_date'])->lte(\Carbon\Carbon::parse($today))
                    );
                    @endphp

                    <tr class="border-b hover:bg-gray-50 text-center"
                    data-id="{{ $inst['id'] }}"
                    data-rd="{{ $rdAccount->id }}"
                    data-no="{{ $inst['installment_no'] }}"
                    data-amount="{{ $inst['amount'] }}"
                    data-due="{{ $inst['due_date'] }}">

                    <!-- Installment No -->
                    <td class="px-4 py-3">{{ $inst['installment_no'] }}</td>

                    <!-- Amount -->
                    <td class="px-4 py-3">₹{{ number_format($inst['amount'], 2) }}</td>

                    <!-- Due Date -->
                    <td class="px-4 py-3">{{ $inst['display_due_date'] }}</td>

                    <!-- Status -->
                    <td class="installment-status px-4 py-3">
                        @if($inst['status'] === 1)
                        <span class="block px-2 py-2 rounded-[30px] border border-n30 bg-primary/20 text-primary text-xs">
                            Paid
                        </span>
                        @else
                        <span class="block px-2 py-2 rounded-[30px] border border-n30 bg-error/20 text-error text-xs">
                            Pending
                        </span>
                        @endif
                    </td>

                    <!-- Paid On -->
                    <td class="installment-paid-on px-4 py-3">
                       
                        {{  $inst['paid_on'] ?  \Carbon\Carbon::parse($inst['paid_on'])->format('d-m-Y') : '-' }}
                    </td>

                    <!-- Action -->
                    <td class="flex justify-center gap-2">

                        {{-- PROCESS BUTTON --}}
                        @if($showProcessButton)
                        <button class="btn btn-primary rounded-10 mt-2 py-2 process-btn"
                            data-index="{{ $index }}">
                            Process
                        </button>
                        @endif

                        {{-- PRINT BUTTON --}}
                        <a href="
                        {{-- {{ route('rd.installment.receipt', ['id' => $inst['id']]) }} --}}
                         " target="_blank"
                            class=" print-btn inline-flex items-center justify-center mt-2 py-2 text-sm
                             text-black btn-primary rounded-10 gap-2"
                            @if($inst['print_flag'])
                            style="display:inline-flex"
                            @else
                            style="display:none"
                            @endif>
                            <i class="las la-print"></i> PRINT
                        </a>

                    </td>
                    </tr>
                    @endforeach

            </tbody>
        </table>

        <!-- AJAX Script -->
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.process-btn').forEach(btn => {

                    btn.addEventListener('click', function() {

                        const row = this.closest('tr');
                        const installmentId = row.dataset.id;

                        // Data attributes required by controller
                        const payload = {
                            rd_account_id: row.dataset.rd,
                            installment_no: row.dataset.no,
                            amount: row.dataset.amount,
                            due_date: row.dataset.due
                        };

                        fetch("{{ url('/mds-rds-dds/installments') }}/" + installmentId + "/process", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(res => res.json())
                            .then(data => {

                                if (data.success) {
console.log(data.success);
                                    // Update Status to Paid
                                    row.querySelector('.installment-status').innerHTML = `
                        <span class="block px-2 py-2 rounded-[30px] border border-n30 bg-primary/20 text-primary text-xs">
                            Paid
                        </span>
                    `;

                                    // Update Paid-On Date
                                    row.querySelector('.installment-paid-on').textContent = data.paid_on;

                                    // Hide Process Button
                                    btn.style.display = 'none';

                                    // Show Print Button
                                    row.querySelector('.print-btn').style.display = 'inline-flex';
                                }
                            })
                            .catch(err => console.error("AJAX Error:", err));

                    });

                });

            });
        </script> -->


<script>
$(document).ready(function () {

    $('.process-btn').each(function () {

        $(this).on('click', function () {

            const row = $(this).closest('tr');
            const installmentId = row.data('id');

            const payload = {
                rd_account_id: row.data('rd'),
                installment_no: row.data('no'),
                amount: row.data('amount'),
                due_date: row.data('due')
            };

            //fetch("{{ url('/mds-rds-dds/installments') }}/" + installmentId + "/process", {
            fetch("/mds-rds-dds/installments/" + installmentId + "/process", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {

                if (data.success) {
                    console.log(data.success);
                    // Update status
                    location.reload();
                }
            })
            .catch(err => console.error("AJAX Error:", err));

        });

    });

});
</script>


        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {

                document.querySelectorAll('.process-btn').forEach(button => {

                    button.addEventListener('click', function() {

                        const row = button.closest('tr');
                        const installmentId = row.dataset.id;

                        // FIXED URL (no double slash)
                        let url = "{{ url('installments/process') }}/" + installmentId;

                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    rd_account_id: row.dataset.rd,
                                    installment_no: row.dataset.no,
                                    amount: row.dataset.amount,
                                    due_date: row.dataset.due
                                })
                            })
                            .then(response => response.json())
                            .then(data => {

                                if (data.success) {

                                    // Update Paid status
                                    row.querySelector('.installment-status').innerHTML = `
                        <span class="block px-2 py-2 rounded-[30px] border border-n30 bg-primary/20 text-primary text-xs">
                            Paid
                        </span>
                    `;

                                    // Update Paid On date
                                    row.querySelector('.installment-paid-on').textContent = data.paid_on;

                                    // Hide Process button
                                    button.style.display = 'none';

                                    // Show Print button
                                    row.querySelector('.print-btn').style.display = 'inline-flex';
                                }

                            })
                            .catch(err => console.error("Process Installment Error:", err));

                    });

                });

            });
        </script> -->


    </div>
</div>
@endsection
