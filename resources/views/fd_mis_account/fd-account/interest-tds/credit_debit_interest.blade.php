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

            /* Fallback for browsers without accent-color support */
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
                    FD - {{$fdAccount->id}}
                </h3>
                <p class="text-gray-500 uppercase text-sm">Update Interest</p>
            </div>
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class=" w-full  box overflow-hidden">

            <form action="{{ route('fd.creditdebit.store', $fdAccount->id) }}" method="POST">
                @csrf
                <label class="font-semibold text-lg uppercase block mb-4">
                    CREDIT / REVERSE INTEREST
                </label>
                <hr>

                {{-- Transaction Date --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-4">
                    <x-datepicker-disabled label="Transaction Date" name="transaction_date"
                        class="md:text-lg uppercase font-medium block mt-4" required />
                </div>

                {{-- Transaction Type --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label class="md:text-lg uppercase font-medium block mb-4">
                        Transaction Type <span class="text-red-500">*</span>
                    </label>

                    <select name="transaction_type"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        required>
                        <option value="">Select Type</option>
                        <option value="credit">Credit</option>
                        <option value="debit">Debit</option>
                    </select>
                    @error('transaction_type')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                </div>

                {{-- Interest Amount --}}
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label class="md:text-lg uppercase font-medium block mb-4">
                        Interest Amount <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="amount" id="interestAmount"
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
                            Update Interest
                        </button>

                        <a href="{{ route('mis.transaction.view', $fdAccount->id) }}" class="btn-outline uppercase justify-center text-center">
                            Back
                        </a>
                    </div>
                </div>
            </form>

        </div>


        <div class=" w-full  overflow-hidden">
            <!--  Application Info -->
            <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                <!-- Header -->
                <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                    <h3 class="text-black uppercase font-semibold text-lg">fd Account Info</h3>

                    <!-- Toggle Button -->
                    <button class="p-1 rounded transition" onclick="toggleSection(this)">
                        <span class="toggle-icon text-lg font-bold">+</span>
                    </button>

                </div>

                <!-- Content (Initially Hidden) -->
                <div class="overflow-x-auto p-4 ">
                    <table class="w-full text-sm  text-gray-700 rounded-md">
                        <tbody>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2 w-1/3">Customer</td>
                                <td class="px-3 py-2">{{ $fdAccount->member->member_info_first_name }} {{ $fdAccount->member->member_info_last_name }} </td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Fd No.</td>
                                <td class="px-3 py-2"> {{$fdAccount->id}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Scheme</td>
                                <td class="px-3 py-2">{{$fdAccount->maturity_date}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Principal Amt.</td>
                                <td class="px-3 py-2">₹{{$fdAccount->mis_amount}}</td>
                            </tr>
                            <tr class="border-b border-gray-200">
                                <td class="uppercase font-semibold px-3 py-2">Balance Available</td>
                                <td class="px-3 py-2">₹{{$balance}}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
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