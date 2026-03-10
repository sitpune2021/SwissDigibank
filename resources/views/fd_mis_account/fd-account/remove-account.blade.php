@extends('layout.main')

@section('content')
<div class="main-inner">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase text-lg font-semibold">FD Account - {{$fdAccount->id}} - Remove</h3>
            <!-- <p class="text-gray-500">
                <a href="#" class="text-gray-500 text-sm">MIS Accounts</a> >
                <a href="#" class="text-gray-500 text-sm">{{$fdAccount->id}} </a>>
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
            <form action="{{ route('fdaccount.confirmRemove', $fdAccount->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to remove this account? This action cannot be undone.')">

                @csrf
                @method('DELETE')

                <button type="submit"
                    class="btn-error uppercase px-6 py-2 rounded text-white bg-red-600 hover:bg-red-700">
                    REMOVE ACCOUNT
                </button>

            </form>

            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="{{ route('fd-mis-schemes.fd_show', $fdAccount->id) }}"> BACK</a>
            </button>
        </div>
    </div>

</div>
@endsection