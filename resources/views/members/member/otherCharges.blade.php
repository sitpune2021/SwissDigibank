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
</style>
@section('page-title',
    isset($member)
    ? 'Members - ' .
    ($member->member_info_first_name ?? $member->member_code) .
    '
    Transactions'
    : 'Members Transactions')
@section('content')
    <div class="main-inner">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen">
            <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

                <form action="{{ route('members.other-charges.store', $member->id) }}" method="POST" target=""
                    class="space-y-6">
                    @csrf
                    {{-- @if ($method == 'PUT')
                        @method('PUT')
                    @endif --}}

                    <!-- Charge Type -->
                     <div class="mb-4">
                        <label for="ChargeType" class="block font-medium mb-2">
                            Charge Type <span class="text-red-500">*</span>
                        </label>
                        <select id="ChargeType" name="charge_type"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3">
                            <option value="">Select Type</option>
                            <option value="Locker Charges" {{ old('charge_type') == 'Locker Charges' ? 'selected' : '' }}>
                                Locker Charges
                            </option>
                        </select>

                        <!-- Laravel Error Message -->
                        @error('charge_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Transaction Date -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="date2">
                            Transaction Date <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="transaction_date" id="date"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Transaction Date"
                            value="{{ old('transaction_date', now()->format('d-m-Y')) }}">
                        @error('transaction_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Charges -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2" for="charges">
                            Charges <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="charges" id="charges"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Enter Amount" value="{{ old('charges') }}">
                        @error('charges')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Remarks -->
                    <div class="w-full mt-4">
                        <label class="block font-medium mb-2">
                            Remarks (if any)
                        </label>
                        <input type="text" name="remarks" placeholder="Enter Remarks (if any)"
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            value="{{ old('remarks') }}">
                        @error('remarks')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <p for="" class=" text-error text-sm block mt-3 mb-4">
                        Note: Please input charge amount exclusive GST amount here. The system will automatically calculate
                        and add up the GST amount at the time of collection.
                    </p>
                    <!-- Buttons -->
                    <div class="w-full mt-4">
                        <div class="flex justify-center gap-4 pt-6">
                            <button type="submit" class="btn-primary">
                                Debit
                            </button>
                            <a href="#" class="btn-outline">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
