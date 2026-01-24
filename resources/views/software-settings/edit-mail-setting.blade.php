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
                    Mailer Settings - Edit

                </h1>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6  min-h-screen md-4">
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="box">

                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Display Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Display Name">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Domain Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Domain Name ">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            Server Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="Server Name ">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            SMTP Port No
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="SMTP Port No ">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            User Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="User Name ">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="overflow-x-auto">
                    <div class="mb-4">
                        <label for="" class="block font-medium mb-2">
                            App Password
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="" name=""
                            class="w-full border rounded-10 px-3 py-3 text-sm bg-secondary/5 dark:bg-bg3"
                            placeholder="App Password ">

                    </div>
                    @error('branch_id')
                    <p class="text-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-5 justify-center mt-5">
                    <button class="btn-primary uppercase">Update</button>
                    <a href="{{ route('software-settings.mail-setting') }}" class="btn-outline uppercase">Back</a>
                </div>
            </div>
        </div>
        <div class="col-span-2 md:col-span-1  dark:bg-bg3 rounded-2xl ">

            <div class="box">

                <div class="overflow-x-auto">
                    <p class="text-lg font-semibold">Tips</p>
                    <p class=" mt-5 text-sm font-semibold">Gmail Setting :</p>
                    <div class="mt-3 overflow-x-auto">
                        <table class="w-full border border-gray-300 rounded-md text-left">
                            <tbody class="divide-y divide-gray-200">
                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50 w-1/3">
                                        Display Name
                                    </td>
                                    <td class="px-4 py-2">
                                        Noreply (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50">
                                        Mail Server
                                    </td>
                                    <td class="px-4 py-2">
                                        smtp.gmail.com (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50">
                                        SMTP Port
                                    </td>
                                    <td class="px-4 py-2">
                                        587 (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50">
                                        Domain Name
                                    </td>
                                    <td class="px-4 py-2">
                                        gmail.com (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50">
                                        User Name
                                    </td>
                                    <td class="px-4 py-2">
                                        your_username@gmail.com (static)
                                    </td>
                                </tr>

                                <tr class="border-b">
                                    <td class="px-4 py-2 font-semibold uppercase bg-gray-50">
                                        Password
                                    </td>
                                    <td class="px-4 py-2">
                                        App password (static)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5">
                        <p class="text-error font-semibold">Q.How to get App Password?</p>
                        <p class="text-primary mt-2 font-semibold">
                            Solution
                        </p>
                        <p class="mt-3">
                            <span> Please follow these steps to obtain the app password</span>

                        <ol>
                            <li class="flex gap-2 mt-3">
                                <p>1)</p>
                                <p>
                                    Turn on 2-step verification for your Google account (skip this step if it's already
                                    on).
                                    <a href="" class="text-secondary">
                                        Click here
                                    </a>
                                    for open two step verification tab.
                                </p>
                            </li>
                            <li class="flex gap-2">
                                <p>2)</p>
                                <p>
                                    Click on the 2-step verification tab & scroll down to the "App password"
                                    option.
                                </p>
                            </li>
                            <li class="flex gap-2">
                                <p>3)</p>
                                <p>
                                    Click on "Select app" & choose "Mail" from the options. Then click "Select
                                    device" &
                                    choose "Other (Custom name)". Type "Mail" in the text field & click "GENERATE".
                                </p>
                            </li>
                            <li class="flex gap-2">
                                <p>4)</p>
                                <p>
                                    You will now see a 16-digit app password that you can copy & paste into the
                                    password
                                    field.
                                </p>
                            </li>
                        </ol>

                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</div>






@endsection