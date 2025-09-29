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
            <h1 class="text-2xl font-semibold">UPLOAD LOAN AGAINST PROPERTY APPLICATION CIBIL SCORE</h1>
            <p class="text-gray-500">
                <a href="#" class="text-gray-500">Loan Applications</a> >
                <a href="#" class="text-gray-500">100136</a> >
                <a href="#" class="text-gray-500">Cibil Score</a>
            </p>
        </div>
    </div>
    <form class="box">
        <div class="px-4 py-3 ">
            <h3 class="text-lg border-b mb-4 font-semibold text-black">Cibil Score</h3>
        </div>
        <hr>
        <x-credit-score-details />

        <!-- Buttons -->
        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
            <button class="btn-primary uppercase justify-center" type="submit" name="upload_cibil">
                submit
            </button>
            <button class="btn-outline uppercase justify-center" type="reset">
                <a href="#"> BACK</a>
            </button>
        </div>
    </form>
</div>
@endsection