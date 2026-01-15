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

        <div class=" flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-semibold uppercase">
                 Mailer Settings
                    </h1>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
            <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

                <div class="box">
                    <div class="flex border-b justify-between  py-3">
                       <p class="text-lg font-semibold">
                         MAIL SETTINGS
                       </p>
                        <a href="{{ route('software-settings.edit-mail-setting') }}"
                            class="btn-primary p-2"><i class="las la-pencil-alt"></i></a>
                    </div>
                    <div class="whitespace-nowrap overflow-x-auto">
                    <table class="w-full text-lg rounded-md">

                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Display Name</th>
                            <td class="px-3 py-2">
                               Noreply(static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Domain Name</th>
                            <td class="px-3 py-2">
                              smtp.gmail.com(static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">Server Name</th>
                            <td class="px-3 py-2">
                               smtp.gmail.com(static)
                            </td>
                        </tr>
                         <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">SMTP Port No</th>
                            <td class="px-3 py-2">
                                587(static)
                            </td>
                        </tr>
                        <tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">User Name</th>
                            <td class="px-3 py-2">
                              your_username@gmail.com(static)
                            </td>
                        </tr><tr class="text-start border-b border-gray-200">
                            <th class="text-start font-semibold uppercase px-3 py-2 w-1/3">App Password</th>
                            <td class="px-3 py-2">
                                XXXXXXXXXXXXXXXX (static)
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