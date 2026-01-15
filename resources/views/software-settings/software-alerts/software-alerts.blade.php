@extends('layout.main')

@section('content')

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

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }
</style>

<div class="main-inner">

    <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
        <div class="flex items-start flex-col  gap-2">
            <div class="flex items-center gap-3 px-6">
                <h1 class="text-lg font-semibold capitalize">
                    SOFTWARE ALERTS
                </h1>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-6 min-h-screen md-4">
        <div class="col-span-2 md:col-span-1 box dark:bg-bg3 rounded-2xl p-6">
            <div class=" border-b flex py-2 items-center justify-between">
                <p class="text-lg  font-semibold"> ALERTS</p>
                <a href="{{ route('software-settings.software-alerts.update-software-alerts') }}" class="btn-primary p-2">
                    <i class="las la-pencil-alt"></i>
                </a>
            </div>
            <div class="  flex py-2 items-center justify-between">
                <p class="text-lg  font-semibold"> SMS</p>
            </div>
            <div class=" ">
                    <div class="text-end">
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                        <table class="w-full text-sm rounded-md">

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Low Balance Alert -</th>
                                <td class="px-3 py-2">

                                </td>
                            </tr>
                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Alert Mob No. -</th>
                                <td class="px-3 py-2">

                                </td>
                            </tr>
                           
                        </table>
                    </div> 
            </div>

             <div class=" mt-5 flex py-2 items-center justify-between">
                <p class="text-lg  font-semibold"> MOBILE WALLET</p>
            </div>
            <div class="mt-4 ">
                    <div class="text-end">
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                        <table class="w-full text-sm rounded-md">

                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Low Balance Alert -</th>
                                <td class="px-3 py-2">

                                </td>
                            </tr>
                            <tr class="text-start border-b border-gray-200">
                                <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Alert Mob No. -</th>
                                <td class="px-3 py-2">

                                </td>
                            </tr>
                           
                        </table>
                    </div> 
            </div>
        </div>


    </div>
</div>
</div>



@endsection