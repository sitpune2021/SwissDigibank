@extends('layout.main')
@section('content')
    <style>
        input[type="checkbox"] {
            width: 28px;
            height: 28px;
            accent-color: green;
            /* For modern browsers */
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
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

    @php
        $deposit = $unencumberedDeposit ?? null;
        $isView = $mode === 'show';
    @endphp

    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h1 class="text-xl font-semibold uppercase">
                @if ($mode === 'create')
                    New Unencumbered Deposit
                @elseif ($mode === 'edit')
                    Edit Unencumbered Deposit
                @else
                    View Unencumbered Deposit
                @endif
            </h1>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form method="POST"
                action="{{ $mode === 'create'
                    ? route('unencumbered-deposits.store')
                    : route('unencumbered-deposits.update', $deposit->id ?? 0) }}"
                enctype="multipart/form-data" class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

                @csrf
                @if ($mode === 'edit')
                    @method('PUT')
                @endif

                {{-- Bank --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Bank Name <span class="text-red-500">*</span>
                    </label>
                    <select name="bank_id" {{ $isView ? 'disabled' : '' }}
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">-- Select Bank --</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('bank_id', $deposit->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- FD No --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        FD NO <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="fd_no" value="{{ old('fd_no', $deposit->fd_no ?? '') }}"
                        {{ $isView ? 'readonly' : '' }} placeholder="Enter fd no"
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('fd_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- FD Amount --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        FD Amount <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="fd_amount" value="{{ old('fd_amount', $deposit->fd_amount ?? '') }}"
                        {{ $isView ? 'readonly' : '' }} placeholder="Enter fd amount"
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('fd_amount')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Interest --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Annual Interest Rate (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="annual_interest_rate"
                        value="{{ old('annual_interest_rate', $deposit->annual_interest_rate ?? '') }}"
                        {{ $isView ? 'readonly' : '' }} placeholder="Enter fd annual interest rate"
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('annual_interest_rate')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Open Date --}}
                <div class="col-span-2 md:col-span-1">
                    <x-datepicker-disabled label="OPEN DATE" name="open_date" inputId="open_date"
                        value="{{ old('open_date', $deposit->open_date ?? '') }}" />

                    @error('open_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Maturity Date --}}
                <div class="col-span-2 md:col-span-1">
                    <x-datepicker-disabled label="MATURITY DATE" name="maturity_date" inputId="maturity_date"
                        value="{{ old('maturity_date', $deposit->maturity_date ?? '') }}" />

                    @error('maturity_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Receipt --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Receipt Scan Copy <span class="text-red-500">*</span>
                    </label>

                    @if (!empty($deposit?->receipt_scan_copy))
                        <a href="{{ asset('storage/' . $deposit->receipt_scan_copy) }}" target="_blank"
                            class="text-blue-600 underline block mb-2">
                            View Receipt
                        </a>
                    @endif

                    @if (!$isView)
                        <input type="file" name="receipt_scan_copy"
                            class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @endif
                </div>

                {{-- FD from deposit --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Is FD made from Deposit Money?
                    </label>

                    <div class="flex gap-6">
                        <label>
                            <input type="radio" name="fd_from_deposit_money" value="1"
                                {{ old('fd_from_deposit_money', $deposit->fd_from_deposit_money ?? '') == 1 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            Yes
                        </label>

                        <label>
                            <input type="radio" name="fd_from_deposit_money" value="0" checked
                                {{ old('fd_from_deposit_money', $deposit->fd_from_deposit_money ?? '') == 0 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            No
                        </label>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-center gap-3 mt-6 col-span-2">
                    @if (!$isView)
                        <button type="submit" class="btn-primary uppercase">
                            {{ $mode === 'edit' ? 'UPDATE' : 'SAVE' }}
                        </button>
                    @endif


                    <a href="{{ route('unencumbered-deposits.index') }}" class="btn-outline uppercase">
                        BACK
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection
