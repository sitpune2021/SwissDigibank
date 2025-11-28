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
            <h1 class="text-xl font-semibold dark:text-white">FD ACCOUNT - 03767 - NOMINEE</h1>
            <!-- <p class="text-gray-500 dark:text-gray-400">
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">FD ACCOUNTS</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">03754</a> >
                <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Nominee</a>
            </p> -->
        </div>
    </div>

    <div class="flex box flex-col lg:flex-col gap-6">
        <div>
            <h4 class="uppercase">Update Nominee Details</h4>
        </div>

        <div>
            <hr>
        </div>

        <form action="{{ route('fd.nominees.save', ['type' => 'fd', 'id' => $account->id]) }}" method="POST">
            @csrf
            <x-add-nominee
                :account="$account"
                :member="$member"
                type="fd"
                submitText="Save"
                backText="Back"
                :isUpdate="true" />
        </form>
    </div>


    @endsection