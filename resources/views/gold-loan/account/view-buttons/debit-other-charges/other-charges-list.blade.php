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

    <div class=" flex flex-wrap items-center justify-between gap-4 ">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase text-lg font-semibold">
                Gold Loan - Link Saving Account for Auto Debit EMI
            </h3>
            
        </div>
    </div>


    <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-2 gap-5">
        <div class="col-span-2 md:col-span-1 mt-2 mb-2">
            <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                <button class="btn-primary rounded-10 text-sm uppercase justify-center"
                    onclick="window.location.href='{{ route('gold-loan.debitOtherCharges.form', $goldLoan->id) }}'">
                    Debit other charges
                </button>

                <button class="btn-outline uppercase  rounded-10  justify-center" type="reset">
                    <a href="{{route('gold-loan.clear-due.form',$goldLoan->id)}}" class="text-sm"> clear dues</a>
                </button>
            </div>
        </div>

    </div>
    <div class="flex flex-col box dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

        <h5 class="capitalize">No Charges Found</h5>

    </div>

</div>


@endsection