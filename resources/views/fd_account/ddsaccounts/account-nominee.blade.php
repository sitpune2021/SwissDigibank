@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
    }

    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
    }
</style>

<div class="main-inner dark:bg-gray-900 dark:text-gray-200">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col gap-2">
            <h1 class="text-lg font-semibold dark:text-white">
                DD ACCOUNT - {{ $account->dd_no }} - NOMINEE
            </h1>
        </div>
    </div>

    <div class="flex box flex-col lg:flex-col gap-6">
        <div>
            <h4 class="uppercase text-lg">Update Nominee Details</h4>
        </div>
        <div>
            <hr>
        </div>

        <form action="{{ route('accounts.nominees.save',['type' => 'dd', 'id' => $account->id]) }}" method="POST">
            @csrf
            <x-add-nominee
                :account="$account"
                :member="$member"
                type="dd"
                submitText="Save"
                backText="Back"
                :isUpdate="true" />
        </form>
    </div>
</div>
@endsection