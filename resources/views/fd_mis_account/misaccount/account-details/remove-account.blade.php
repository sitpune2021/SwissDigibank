@extends('layout.main')

@section('content')
<div class="main-inner">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase text-lg font-semibold">MIS Account - {{$misaccount->id}} - Remove</h3>
            <!-- <p class="text-gray-500">
                <a href="#" class="text-gray-500 text-sm">MIS Accounts</a> >
                <a href="#" class="text-gray-500 text-sm">{{$misaccount->id}} </a>>
                <a href="#" class="text-gray-500 text-sm"> Remove Account </a>
            </p> -->
        </div>
    </div>

    <div class="box dark:bg-bg3 shadow-md rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <!-- Title -->
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
            Remove FD and it's details and transactions.
        </h2>

        <!-- Content -->
        <ul class="list-disc pl-6 text-sm leading-relaxed text-gray-700 dark:text-gray-300 space-y-2">
            <li>Remove FD and all its transactions.</li>
            <li>Remove transactions from accounting module.</li>
            <li>Remove all the tracking if any.</li>
            <li>Sequence numbers will get unused in future.</li>
            <li>May lead to data corruption if any inter link account transactions are present.</li>
            <li>No data backup will be provided for this action.</li>
        </ul>

        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button class="btn-error uppercase justify-center" type="submit" name="save_scheme">
                REMOVE ACCOUNT
            </button>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="#"> BACK</a>
            </button>
        </div>
    </div>

</div>
@endsection