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
                <h1 class="text-2xl font-semibold dark:text-white">RD - {{$rdAccount->id}}</h1>
                <p class="text-gray-500 dark:text-gray-400">
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Recurring Deposits</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">{{$rdAccount->id}}</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Nominee</a>
                </p>
            </div>
        </div>


        <div class="bg-white dark:bg-bg3 rounded-xl shadow p-6">
            <h1 class="text-lg font-semibold mb-4 border-b">
                Update Nominee Details
            </h1>

            <form method="POST" action="{{ route('rd-accounts.saveNominee', $rdAccount->id) }}">
                @csrf

                <x-add-nominee
                    :rdAccount="$rdAccount"
                    submitText="{{ $rdAccount->nominees->isNotEmpty() ? 'Update' : 'Add' }}"
                    backText="Back" />

                <!-- Buttons -->
                <div class="flex flex-col mt-6 sm:flex-row gap-3 justify-center">
                    <button type="submit"
                        class="sm:w-auto btn-primary uppercase justify-center">
                        {{ $rdAccount->nominees->isNotEmpty() ? 'Update' : 'Add' }}
                    </button>
                    <a href="{{ $backUrl ?? 'javascript:history.back()' }}"
                        class="sm:w-auto btn-outline uppercase justify-center">
                        {{ $backText ?? 'Back' }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    @endsection