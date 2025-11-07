@extends('layout.main')

<style>
    .breadcrumb {
        list-style: none;
        display: flex;
        padding: 0;
        margin-bottom: 1rem;
        font-size: 14px;
    }

    .breadcrumb li+li::before {
        content: "/";
        padding: 0 8px;
        color: #888;
    }

    .breadcrumb li a {
        text-decoration: none;
        color: #007bff;
    }

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

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

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

@section('content')


    <div class="main-inner ">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase font-semibold">
                Day Book
            </h3>
        </div>

        <div class="box mb-5">
            <div class="flex gap-3  items-center justify-center ">
                <div class="">
                    <select name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                        <option value="">All</option>
                    </select>
                </div>
                <div>
                    <input type="text" name="" id=""
                        class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                        placeholder="DD/MM/YYYY">
                      
                </div>
                <div class="">
                    <a href="" class="uppercase btn-primary py-2 rounded-10">
                        Get
                    </a>
                </div>
            </div>
            <div class="mt-5 flex justify-end">
                <div class="">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                        Format:
                    </label>
                    <select name="" id=""
                        class=" text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                        <option value="">Format 1</option>
                        <option value="">Format 2</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row lg:flex-row gap-4">
            <div class="box w-full  ">
                <div class="whitespace-nowrap px-6">
                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                            OPENING (27-10-2025)
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">
                       
                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                3,674,948.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    CASH BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">(54,053.59)</h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    BANK BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                0.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    WALLET BALANCE
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box w-full">
                  <div class=" whitespace-nowrap px-6">
                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                          CURRENT/ CLOSING (27-10-2025)
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">
                       
                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                3,674,948.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    CASH BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">(54,053.59)</h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    BANK BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                0.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    WALLET BALANCE
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
             <div class="box w-full">
                  <div class=" whitespace-nowrap px-6">
                    <div class="border-b py-3 text-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800 tracking-wide">
                        DAY TRANSACTIONS
                        </h3>
                    </div>

                    <div class="py-6 px-4 text-center space-y-5">
                       
                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                               0.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    CASH BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                0.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    BANK BOOK
                                </a>
                            </p>
                        </div>

                        <div class="py-3">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-1">
                                0.00
                            </h3>
                            <p>
                                <a href=""
                                    class="text-primary uppercase font-semibold">
                                    WALLET BALANCE
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 text-center">
            <a href="" class="btn-primary uppercase rounded-10">
                <i class="las la-print"></i>
                Print
            </a>
        </div>
    </div>


   <!-- Datepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

<!-- Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.datepicker-field').forEach(function(dateInput) {
        const picker = new Datepicker(dateInput, {
            autohide: true,
            format: 'dd-mm-yyyy',
            maxDate: new Date(),
        });

        if (!dateInput.value) {
            const today = new Date();
            const formattedDate = today.toLocaleDateString('en-GB').split('/').join('-');
            dateInput.value = formattedDate;
        }

        const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
        if (calendarIcon) {
            calendarIcon.addEventListener('click', () => picker.show());
        }
    });
});
</script>
@endsection