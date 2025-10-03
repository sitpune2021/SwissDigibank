@extends('layout.main')

<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
    }

    .tableWidth {
        width: 90%;
        margin: auto;
    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
<div class="main-inner dark:bg-gray-900 dark:text-gray-200">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-xl font-semibold dark:text-white">FD Account - 03754 - Remove</h1>
            <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Fd Accounts</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">03754</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Remove Account</a>
            </p>
        </div>
    </div>


    <div class="box dark:bg-bg3 shadow-md rounded-lg p-6">
        <!-- Heading -->
        <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Remove FD and its details and transactions.
        </h3>
        <hr class="my-4 border-gray-300 dark:border-gray-600">

        <!-- Description -->
        <p class="text-lg md:text-base text-black dark:text-white">
            Remove FD will delete the following details:
        </p>

        <!-- Warning List -->
        <ul class="list-disc list-inside space-y-1 text-sm md:text-base text-gray-700 dark:text-gray-300 mt-3">
            <li>Remove FD and all its transactions.</li>
            <li>Remove transactions from accounting module.</li>
            <li>Remove all the tracking if any.</li>
            <li>Sequence numbers will get unused in future.</li>
            <li>May lead to data corruption if any inter link account transactions are present.</li>
            <li>No data backup will be provided for this action.</li>
        </ul>

        <!-- Form -->
        <form class="mt-6">

            <!-- Buttons -->
            <div class="flex flex-col mt-6 sm:flex-row  gap-3 justify-center">
                <button type="submit"
                    class="w-1/2 sm:w-auto btn-primary uppercase justify-center">
                    Remove Account
                </button>
                <a href="#"
                    class="w-1/2 sm:w-auto btn-outline uppercase justify-center">
                    back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection