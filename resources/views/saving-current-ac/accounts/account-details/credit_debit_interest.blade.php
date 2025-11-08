@extends('layout.main')
@section('content')
<div class="main-inner">

    <head>
        <style>
            input[type="radio"] {
                width: 24px;
                height: 24px;
                accent-color: green;
            }

            input[type="checkbox"] {
                width: 28px;
                height: 28px;
                accent-color: green;
                /* For modern browsers */
            }

            input[type="checkbox"]:checked {
                background-color: green;
                border: none;
            }
        </style>
    </head>

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <div class="flex items-center gap-2">
                <h3 class="uppercase font-semibold">
                  Saving Account - 
                </h3>
               
            </div>
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class=" w-full  box overflow-hidden">
            <form action="{{route('storeCreditDebitInterest',$account->id?? 0)}}" method="POST">
                @csrf
                <hr>

                {{-- Transaction Date --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-4">
                    <x-datepicker-disabled label="Transaction Date" name="transaction_date"
                        class="md:text-lg uppercase font-medium block mt-4" required />
                </div>

                {{-- Interest Amount --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label class="md:text-lg uppercase font-medium block mb-4">
                        Interest Amount <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="amount" id="interestAmount" placeholder="Enter Interest Amount to Credit"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        step="0.01" min="0" required />

                    <x-number-to-word for="interestAmount" />
                     @error('amount')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                </div>

                {{-- Remarks --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label class="md:text-lg uppercase font-medium block mb-4">
                        Remarks (if any)
                    </label>

                    <textarea name="remarks"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Remarks (if any)"></textarea>
                </div>

                {{-- Submit / Back Buttons --}}
                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit">
                           Save
                        </button>

                        <a href="" class="btn-outline uppercase justify-center text-center">
                            Back
                        </a>
                    </div>
                </div>
            </form>
        </div>
         <div class=" w-full overflow-hidden">
            
        </div>
    </div>

</div>

<script>
    function toggleSection(button) {
        const section = button.closest('.box').querySelector('.overflow-x-auto');
        const icon = button.querySelector('.toggle-icon');
        section.classList.toggle('hidden');
        icon.textContent = section.classList.contains('hidden') ? '+' : '−';
    }
</script>
@endsection