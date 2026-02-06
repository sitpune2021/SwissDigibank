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
                <h1 class="text-lg font-semibold dark:text-white">MIS - {{$account->id}}</h1>
                {{-- <p class="text-gray-500 dark:text-gray-400">
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">MIS Account</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">{{$account->id}}</a> >
                    <a href="#" class="text-gray-500 dark:text-gray-400 text-sm">Nominee</a>
                </p> --}}
            </div>
        </div>


        <div class="bg-white dark:bg-bg3 rounded-xl shadow p-6">
            <h1 class="text-lg font-semibold uppercase mb-4 border-b">
                Update Nominee Details
            </h1>

            <form method="POST" action="{{ route('mis.nominees.save', ['type'=>'mis','id'=>$account->id]) }}">
                @csrf
                <x-add-nominee
                :account="$account"
                :member="$member"
                type="mis"
                :isUpdate="true"
                submitText="Change account info"
                backText="Back" />
                
            </form>
        </div>
    </div>

    @endsection