@extends('layout.main')

@section('page-title', isset($member) ? 'Members - ' . ($member->member_info_first_name ?? $member->member_code) . ' Transactions' : 'Members Transactions')

@section('content')
<div class="main-inner">

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class="box w-full bg-white  overflow-hidden">
        <form action="{{ route('members.transactions.share-amount.store', ['id' => $member->id]) }}" method="POST">
            @csrf
            <h3 class="text-lg font-semibold items-center text-black">Share Amount Collected</h3>

            <!-- Transaction Date -->
            <div>
                <label>Transaction Date *</label><br>
                <input type="date" name="transaction_date" value="{{ old('transaction_date') }}" required>
            </div>

            <!-- Share Amount -->
            <div>
                <label>Share Amount *</label><br>
                <input type="number" step="0.01" name="membership_fee" placeholder="Enter Share Amount" value="{{ old('membership_fee') }}" required>
            </div>

            <!-- Remarks -->
            <div>
                <label>Remarks (if any)</label><br>
                <textarea name="remarks" placeholder="Enter Remarks (if any)">{{ old('remarks') }}</textarea>
            </div>

            <!-- Payment Mode -->
            <div class="mt-4">
                <label>Payment Mode *</label>
                <div class="flex flex-wrap gap-4 mt-2">
                    <label><input type="radio" name="charges_pay_mode" value="cash" onclick="togglePaymentMode('cash')" checked> Cash</label>
                    <label><input type="radio" name="charges_pay_mode" value="online" onclick="togglePaymentMode('online')"> Online Tr.</label>
                    <label><input type="radio" name="charges_pay_mode" value="cheque" onclick="togglePaymentMode('cheque')"> Cheque</label>
                </div>
            </div>

            <!-- Online Transfer Fields -->
            <div id="online-fields" class="hidden mt-4">
                <div>
                    <label>Transfer Date *</label>
                    <input type="date" name="transfer_date">
                </div>
                <div>
                    <label>UTR / Transaction No *</label>
                    <input type="text" name="online_utr_no" placeholder="Enter UTR / Transaction No">
                </div>
                <div>
                    <label>Transfer Mode *</label>
                    <label><input type="radio" name="transfer_mode" value="IMPS"> IMPS</label>
                    <label><input type="radio" name="transfer_mode" value="VPA"> VPA</label>
                    <label><input type="radio" name="transfer_mode" value="NEFT/RTGS"> NEFT/RTGS</label>
                </div>
            </div>

            <!-- Cheque Fields -->
            <div id="cheque-fields" class="hidden mt-4">
                <div>
                    <label>Bank Name *</label>
                    <input type="text" name="cheque_bank_name" placeholder="Enter Bank Name">
                </div>
                <div>
                    <label>Cheque No *</label>
                    <input type="text" name="cheque_no" placeholder="Enter Cheque No">
                </div>
                <div>
                    <label>Cheque Date *</label>
                    <input type="date" name="cheque_date">
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function togglePaymentMode(mode) {
        // Hide all
        document.getElementById('online-fields').classList.add('hidden');
        document.getElementById('cheque-fields').classList.add('hidden');

        if (mode === 'online') {
            document.getElementById('online-fields').classList.remove('hidden');
        } else if (mode === 'cheque') {
            document.getElementById('cheque-fields').classList.remove('hidden');
        }
    }

    // On load, initialize based on selected radio
    document.addEventListener('DOMContentLoaded', function () {
        const selected = document.querySelector('input[name="charges_pay_mode"]:checked');
        if (selected) {
            togglePaymentMode(selected.value);
        }
    });
</script>
@endsection
