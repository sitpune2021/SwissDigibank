    @extends('layout.main')

    @section('content')

    <head>
        <style>
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
    </head>
    <div class="main-inner dark:bg-gray-900 dark:text-gray-200">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-2xl font-semibold dark:text-white">RD - {{$account->id}}</h1>

            </div>
        </div>


        <div class="bg-white dark:bg-bg3 rounded-xl shadow p-6">
            <h1 class="text-lg font-semibold mb-4 border-b">
                Update Nominee Details
            </h1>
     <form action="{{ route('rd-accounts.saveNominee', ['type' => 'rd', 'id' => $account->id]) }}" method="POST">
                @csrf
                <x-add-nominee
                    :account="$account"
                    :member="$member"
                    type="rd"
                    submitText="Save"
                    backText="Back"
                    :isUpdate="true" />
            </form>
        </div>
    </div>

    @endsection