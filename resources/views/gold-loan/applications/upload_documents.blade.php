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
            <h1 class="text-2xl font-semibold">Upload Loan Against Property Application Documents</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Loan Applications</a> >
                <a href="#" class="text-gray-500">100136</a> >
                <a href="#" class="text-gray-500">Documents</a>
            </p>
        </div>
    </div>
    <form class="box">
        <x-upload-documents />
        <!-- Loan Disbursement Date Field -->


    </form>
</div>



@endsection