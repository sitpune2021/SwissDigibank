@extends('layout.main')
@section('content')
    @php
        // Check if the promoter has nominees
        $hasNominee = $promoter->nominees()->exists();
    @endphp

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
    </style>

    <div class="main-inner dark:bg-gray-900 dark:text-gray-200">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-xl font-semibold dark:text-white">
                    DD ACCOUNT - {{ $promoter->dd_no }} - NOMINEE
                </h1>
            </div>
        </div>

        <div class="flex box flex-col lg:flex-col gap-6">
            <div>
                <h4 class="uppercase">Update Nominee Details</h4>
            </div>
            <div>
                <hr>
            </div>

            <form action="{{ route('nominee.update', ['type' => 'dd', 'id' => $nominee->id]) }}" method="POST">
                @csrf
                @method('PUT') {{-- Corrected: use PUT for update --}}

                <x-promoter-add-nominee :promoter="$promoter" type="dd" submitText="Save" backText="Back"
                    :isUpdate="true" />
            </form>
        </div>
    </div>
@endsection
