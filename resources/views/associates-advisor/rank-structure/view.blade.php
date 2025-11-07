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

    input[type="radio"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-start gap-3 mb-6 px-4 lg:mb-8">
            <h3 class="flex text-xl block  uppercase font-semibold">
                Field Head Officer
            </h3>
            <p class="text-xs text-gray-500">
                Rank
            </p>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="text-end p-2">
                        <a href="" class="btn-primary p-1 rounded-10">
                            <i class="las la-pencil-alt"></i>
                        </a>
                    </div>
                    <div class="w-full p-4">
                        <table class="w-full ">
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 px-4 py-3 w-1/2 sm:w-1/3 bg-gray-50 uppercase">Name</td>
                                    <td class="px-4 py-3 text-gray-800">Field Head Officer</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 px-4 py-3 bg-gray-50 uppercase">Position</td>
                                    <td class="px-4 py-3 text-gray-800">1</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 px-4 py-3 bg-gray-50 uppercase">Display Position</td>
                                    <td class="px-4 py-3 text-gray-800">1</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="font-semibold text-gray-700 px-4 py-3 bg-gray-50 uppercase">Collection Commission
                                        Enabled</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-1">
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                Yes
                                            </span>
                                            <span
                                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                                                No
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-x-auto "></div>
        </div>
    </div>



    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">

    <!-- Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const datepickers = document.querySelectorAll('.datepicker-field');

            datepickers.forEach(function (dateInput, index) {
                // Create the datepicker with maxDate = today
                const picker = new Datepicker(dateInput, {
                    autohide: true,
                    format: 'dd-mm-yyyy',
                    maxDate: new Date(),
                });

                // Determine which default date to set
                let defaultDate;
                const today = new Date();

                if (index === 0) {
                    // First datepicker → first day of this month
                    defaultDate = new Date(today.getFullYear(), today.getMonth(), 1);
                } else {
                    // Second datepicker → today's date
                    defaultDate = today;
                }

                // Format as dd-mm-yyyy
                const formattedDate = defaultDate.toLocaleDateString('en-GB').split('/').join('-');
                dateInput.value = formattedDate;

                // If there’s a calendar icon near the field, make it open the picker
                const calendarIcon = dateInput.parentElement.querySelector('.la-calendar');
                if (calendarIcon) {
                    calendarIcon.addEventListener('click', () => picker.show());
                }
            });
        });
    </script>
@endsection