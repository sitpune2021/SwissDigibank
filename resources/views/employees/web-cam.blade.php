@extends('layout.main')
@section('content')
    <div class="main-inner">

        <head>
            <style>
                input[type="radio"] {
                    width: 24px;
                    height: 24px;
                    accent-color: green;
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
            </style>
        </head>

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center flex-row gap-2">
                <h3 class="text-xl font-semibold uppercase">
                    Upload manoj Photo
                </h3>

            </div>
        </div>

        <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <!-- Left: Details -->
            <div class=" w-full  overflow-hidden">
                <div class="box dark:bg-bg3 border mb-4 border-gray-200 shadow-md rounded-lg">
                    <form action="">

                        <div class="col-span-2 md:col-span-1 flex justify-center text-center mb-8">
                        
                            <div class="rounded-10" style="height: 150px ; width:150px"></div>
                            
                        </div>
                        <div class="col-span-2 md:col-span-1  text-center mb-8">

                            <button class="btn-warning uppercase rounded-10 " type="submit" name="save_scheme">
                                Take Photo
                            </button>

                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                Upload
                            </button>

                            <button class="btn-outline uppercase justify-center" type="reset">
                                <a href="#"> BACK</a>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!--Rigth: Do Not Remove it -->
            <div class=" w-full  overflow-hidden">
                <!--  Do Not Remove it -->
            </div>

        </div>

    </div>
@endsection