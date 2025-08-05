@extends('layout.main')

@section('content')
<div class="main-inner">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 lg:mb-8">
        <h2 class="h2">Reverse</h2>
    </div>
  
    <div class="mb-4 box xxxl:mb-6">
        <form class="grid grid-cols-2 gap-4 xxxl:gap-6" method="post" action="{{ route('reverse-transaction',['id' => base64_encode($transaction->id)])}}">
            @csrf
            <input type="hidden" name="id" value="{{ $transaction->id }}">

            <div class="col-span-2 md:col-span-1">
                <label for="name" class="block mb-2 font-medium md:text-lg">
                    Amount to be Reversed
                    <span class="text-red-500">*</span> <!-- Red star for required -->
                </label>

                <input type="text"
                    name="reverse_amount"
                    value="{{ $transaction->amount }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 !border border-n30 dark:border-n500 rounded-md px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Amount to be Reversed" id="reverse_amount" required />
                @error('reverse_amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <!-- Validation note just below input -->
                <p class="mt-1 text-xs text-gray-500">Amount should not be more than 1000.0</p>
            </div>

            <!-- Remarks Field -->
            <div class="col-span-2 md:col-span-1">
                <label for="" class="block mb-2 font-medium md:text-lg">
                    Remarks (if any)
                </label>
                <input type="text"
                    name="remarks" id="remarks"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 !border border-n30 dark:border-n500 rounded-md px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Remarks (if any)" id="" />
            </div>

            <!-- Buttons -->
            <div class="flex col-span-2 gap-4 mt-2 md:gap-6">
                <button class="btn-primary" type="submit">
                    Reverse Transaction
                </button>
                <button class="btn-outline" type="reset">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection