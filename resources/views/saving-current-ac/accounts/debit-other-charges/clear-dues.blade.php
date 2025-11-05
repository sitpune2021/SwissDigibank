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

    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
        <div class=" w-full  box overflow-hidden">
            <div class="">
                <h3>CHARGES - CLEAR DUES</h3>
            </div>
            <hr class="mt-3">
            <form action="{{ route('saving.other.charge.debit', $account->id) }}" method="POST">
                @csrf
                <div class="col-span-2 md:col-span-1 mt-5 mb-2 ">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Charges / Penalty Due
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="charges_due" id="charges_due" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" readonly>
                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Waived Amount
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="waived_amount" id="waived_amount" placeholder="0.0"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">


                </div>
                <div class="col-span-2 md:col-span-1 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mt-4">
                        Amount
                        <span class="text-red-500">*</span>
                    </label>
                    <table class="min-w-full text-sm md:text-base whitespace-nowrap">
                        <tbody>
                            <!-- Column Labels -->
                            <tr class="">
                                <th class="text-center uppercase px-3 py-1 ">Amount</th>
                                <th class="text-center uppercase px-3 py-1 ">GST Rate (%) </th>
                                <th class="text-center uppercase px-3 py-1 ">Total Amount</th>

                            </tr>

                            <!-- Input Row -->
                            <tr class="">

                                <td class="px-2 py-2 ">
                                    <input type="text" name="amount" id="amount" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>


                                <td class="px-2 py-2 ">
                                    <input type="text" name="gst_rate" id="gst_rate" placeholder="0" readonly
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>


                                <td class="px-2 py-2 ">
                                    <input type="text" name="total_amount" id="total_amount" placeholder="0"
                                        class="w-full px-2 py-2 text-center bg-secondary/5 border  rounded-10 text-sm md:text-base" />
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Remarks (if any)

                    </label>

                    <textarea name="remarks" id="remarks"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                        placeholder="Enter Remarks (if any)"></textarea>

                </div>
                <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <x-datepicker-disabled label="Transaction Date" name="charge_date" class="md:text-lg uppercase font-medium block mb-4"
                        placeholder="Select Charge Date" />
                </div>
                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            Debit
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                </div>
            </form>
        </div>


        <div class=" w-full  overflow-hidden">

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