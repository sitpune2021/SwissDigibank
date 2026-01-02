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

    {{-- @php
        $deposit = $unencumberedDeposit ?? null;
        $isView = $mode === 'show';
    @endphp --}}
    @php
        $isView = $mode === 'view';
    @endphp
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h1 class="text-xl font-semibold uppercase">
                @if ($mode === 'create')
                    New Bank Account
                @elseif ($mode === 'edit')
                    Edit Bank Account
                @else
                    View Bank Account
                @endif
            </h1>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <form method="POST"
                action="{{ $mode === 'create' ? route('bank-account.store') : route('bank-account.update', $bankAccount->id ?? 0) }}"
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
                                {{ old('bank_id', $bankAccount->bank_id ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('bank_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Account Open Date --}}
                <div class="col-span-2 md:col-span-1 mt-3">
                    <x-datepicker-disabled label="ACCOUNT OPEN DATE" name="account_open_date" inputId="account_open_date"
                        value="{{ old('account_open_date', $bankAccount->account_open_date ?? '') }}" />

                    @error('account_open_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Account No --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Account No. <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="account_no" value="{{ old('account_no', $bankAccount->account_no ?? '') }}"
                        {{ $isView ? 'readonly' : '' }} placeholder="Enter Account No"
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('account_no')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- IFSC Code --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        IFSC Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ifsc_code" value="{{ old('ifsc_code', $bankAccount->ifsc_code ?? '') }}"
                        placeholder="Enter IFSC Code"
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    @error('ifsc_code')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Account Type --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Account Type <span class="text-red-500">*</span>
                    </label>

                    <select name="account_type" {{ $isView ? 'disabled' : '' }}
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3 uppercase">
                        <option value="">-- Select Account Type --</option>

                        <option value="saving"
                            {{ old('account_type', $bankAccount->account_type ?? '') == 'saving' ? 'selected' : '' }}>
                            Saving
                        </option>

                        <option value="current"
                            {{ old('account_type', $bankAccount->account_type ?? '') == 'current' ? 'selected' : '' }}>
                            Current
                        </option>

                        <option value="overdraft"
                            {{ old('account_type', $bankAccount->account_type ?? '') == 'overdraft' ? 'selected' : '' }}>
                            Overdraft
                        </option>
                    </select>

                    @error('account_type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                {{-- Address --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Address
                    </label>
                    <textarea name="address" {{ $isView ? 'readonly' : '' }}
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">{{ old('address', $bankAccount->address ?? '') }}</textarea>
                </div>

                {{-- Account Active --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Account Active
                    </label>
                    <div class="flex gap-6">
                        <label class="flex gap-2">
                            <input type="radio" name="account_active" value="1"
                                {{ old('account_active', $bankAccount->account_active ?? '') == 1 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            <p>Yes</p>
                        </label>

                        <label class="flex gap-2">
                            <input type="radio" name="account_active" value="0" checked
                                {{ old('account_active', $bankAccount->account_active ?? '') == 0 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            <p>No</p>
                        </label>
                    </div>
                </div>

                {{-- Use for Printing --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Use for Printing
                    </label>
                    <div class="flex gap-6">
                        <label class="flex gap-2">
                            <input type="radio" name="use_for_printing" value="1"
                                {{ old('use_for_printing', $bankAccount->use_for_printing ?? '') == 1 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            <p>Yes</p>
                        </label>

                        <label class="flex gap-2">
                            <input type="radio" name="use_for_printing" value="0" checked
                                {{ old('use_for_printing', $bankAccount->use_for_printing ?? '') == 0 ? 'checked' : '' }}
                                {{ $isView ? 'disabled' : '' }}>
                            <p>No</p>
                        </label>
                    </div>
                </div>

                <div class="text-xl font-semibold">Link With Software Accounting</div>

                {{-- Company Branch --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Company Branch
                    </label>

                    <select name="branch_id" {{ $isView ? 'disabled' : '' }}
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">-- Select Branch --</option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ old('branch_id', $bankAccount->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->branch_name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Accounting Bank --}}
                <div class="col-span-2 md:col-span-1">
                    <label class="md:text-lg font-medium block mb-4 uppercase">
                        Accounting Bank <span class="text-error">*</span>
                    </label>
                    <select name="accounting_bank" {{ $isView ? 'disabled' : '' }}
                        class="w-full text-sm bg-secondary/5 border border-n30 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">-- Select Bank --</option>
                        @foreach ($banks as $bank)
                            <option value="{{ $bank->id }}"
                                {{ old('accounting_bank', $bankAccount->accounting_bank ?? '') == $bank->id ? 'selected' : '' }}>
                                {{ $bank->name }}
                            </option>
                        @endforeach
                    </select>
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
