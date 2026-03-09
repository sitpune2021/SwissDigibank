@extends('layout.main')

@section('content')

    <head>
        <style>
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
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col gap-2">
                <h1 class="text-2xl font-semibold">Upload Mortgage Account Documents</h1>

            </div>
        </div>
        <form class="box" action="{{ route('mortgage.storeDocuments', $loan->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <x-upload-documents :hideSanctionCheckbox="true" />

        </form>
    </div>
@endsection
