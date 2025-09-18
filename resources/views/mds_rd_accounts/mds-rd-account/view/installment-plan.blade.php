@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-2xl font-semibold">RD - {{ $rdAccount->id }} - Installments</h1>
            <p class="text-gray-500">
                <a href="{{ route('mds-rd-account.index') }}" class="text-gray-500">Recurring Deposits</a> >
                <a href="#" class="text-gray-500">{{ $rdAccount->id }}</a> >
                <span class="text-gray-500">Installments</span>
            </p>
        </div>
    </div>

    <!-- Installments Table -->
    <div class="p-4 bg-white dark:bg-bg3 shadow rounded-lg">
        <table class="w-full border-collapse rounded-lg dark:bg-bg3 overflow-hidden shadow-md">
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
                @foreach($installments as $inst)
                <tr data-id="{{ $inst->id }}" class="border-b hover:bg-gray-50 text-center">
                    <td class="px-4 py-3">{{ $inst->installment_no }}</td>
                    <td class="px-4 py-3">₹{{ number_format($inst->amount, 2) }}</td>
                    <td class="px-4 py-3">
                        {{ $inst->due_date ? \Carbon\Carbon::parse($inst->due_date)->format('d M Y') : '—' }}
                    </td>
                    <td>
                        @if($inst->approve_status === 'Approved')
                        <span class="px-2 py-1 rounded-full text-xs bg-primary text-white">
                            Paid
                        </span>
                        @elseif($inst->approve_status === 'Pending')
                        <span class="px-2 py-1 rounded-full text-xs bg-error text-white">
                            Pending
                        </span>
                        @else
                        
                        @endif
                    </td>

                    <td class="installment-paid-on">
                        {{ $inst->paid_on ? \Carbon\Carbon::parse($inst->paid_on)->format('d M Y') : '—' }}
                    </td>
                    <td class="flex justify-center gap-2">
                        <!-- Print Button -->
                        <a href="#"
                            class="print-btn inline-flex items-center justify-center px-3 py-1 text-sm text-black btn-outline rounded gap-2"
                            @if($inst->print_flag)
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
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.process-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const row = this.closest('tr');
                        const installmentId = row.dataset.id;
                        // alert('Processing installment ID: ' + installmentId);
                        fetch("{{ url('/installments') }}/" + installmentId + "/process", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                            })

                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Installment processed:', data);
                                    // Update status
                                    const statusEl = row.querySelector('.installment-status');
                                    statusEl.textContent = 'Paid';
                                    statusEl.classList.replace('bg-yellow-200', 'bg-green-200');
                                    statusEl.classList.replace('text-yellow-700', 'text-green-700');

                                    // Update paid on date
                                    row.querySelector('.installment-paid-on').textContent = data.paid_on;
                                    console.log(row.querySelector('.installment-paid-on').textContent = data.paid_on);

                                    // Hide process button
                                    btn.style.display = 'none';

                                    // Show print button if applicable
                                    const printBtn = row.querySelector('.print-btn');
                                    if (data.print_flag && printBtn) printBtn.style.display = 'inline-flex';
                                } else {

                                    alert('Error: ' + data.error);
                                }
                            })
                            .catch(err => console.error(err));
                    });
                });
            });
        </script>
    </div>
</div>
@endsection