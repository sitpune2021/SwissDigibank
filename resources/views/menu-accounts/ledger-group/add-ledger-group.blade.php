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
                ADD LEDGER GROUP
            </h3>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full overflow-x-auto   overflow-hidden">
                <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
                    <div class="min-w-full p-4">
                        <form>
                            <div>
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                    Group Type 
                                    <span class="text-error">*</span>
                                </label>
                                <select id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                     <option >Select Group Type</option>
                                    <option >Asset</option>
                                    <option >Liability</option>
                                    <option >Equity</option>
                                    <option >Expense</option>
                                    <option >Revenue</option>
                                </select>
                            </div>
                            <div class="mt-5">
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                 Display Name
                                     <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Group Display Name">
                                    <p class="text-primary mt-2 text-sm">
                                        (e.g. Current Assets)
                                    </p>
                            </div>

                           <div class="mt-5">
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                               System Name
                                     <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Group System Name">
                                    <p class="text-primary mt-2 text-sm">
                                      (e.g. Current Assets)
                                    </p>
                            </div>

                              <div class="mt-5">
                                <label for="" class="md:text-lg font-medium block mb-2 mt-2 uppercase ">
                                 Weight-age/ Position 
                                     <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="" name=""
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 "
                                    placeholder="Enter Group Weight-age/ Position ">
                                    <p class="text-primary mt-2 text-sm">
                                       (e.g. Highest - 1. used to sort the groups in while listing)
                                    </p>
                            </div>

                            
                            <!-- Buttons -->
                            <div class="flex flex-wrap gap-3 justify-center pt-4">
                                <button type="submit" class="btn-primary uppercase">
                                    Add GROUP
                                </button>
                                <a href="" class="btn-outline uppercase ">
                                    BACK
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Right: Settings -->
            <div class=" w-full overflow-x-auto "></div>
        </div>
    </div>



@endsection