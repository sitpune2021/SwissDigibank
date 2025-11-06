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

        <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
            <div class="flex items-start flex-col gap-2">
                <div class="flex items-center gap-2">
                    <h3  class="uppercase font-semibold">
                        MIS Account - {{$misaccount->id}} - Mark Lien Account 
                    </h3>
                </div>
            </div>
        </div>


        <div class="flex flex-col  dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
            <div class=" w-full  box overflow-hidden">

           <form action="">
           <label class="font-semibold text-lg uppercase block mb-4">Mark Lien against member's deposit loan account for security.</label> 
          <hr>
              <div class="col-span-2 md:col-span-1 mt-5 mb-2">
                    <label for="" class="md:text-lg uppercase font-medium block mb-4">
                        Select Deposit Loan Account 
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="" id=""
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                        <option value="">Select Type</option>
                       
                    </select>
                </div>
               
                
                <div class="col-span-2 md:col-span-1 mt-8 mb-2">
                    <div class="flex flex-col min-w-10 sm:flex-row justify-center gap-3 mt-5">
                        <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                            make lien account
                        </button>

                        <button class="btn-outline uppercase justify-center" type="reset">
                            <a href="#"> BACK</a>
                        </button>
                    </div>
                </div>
             </form>
            </div>


            <div class=" w-full  overflow-hidden">
                <!--  Application Info -->
                <div class="box bg-white dark:bg-bg3 border shadow-md rounded-lg">
                    <!-- Header -->
                    <div class="flex justify-between items-center px-4 py-2 bg-secondary/5 text-black rounded-10">
                        <h3 class="text-black uppercase font-semibold text-lg">MIS Account Info</h3>

                        <!-- Toggle Button -->
                        <button class="p-1 rounded transition" onclick="toggleSection(this)">
                            <span class="toggle-icon text-lg font-bold">+</span>
                        </button>

                    </div>

                    <!-- Content (Initially Hidden) -->
                    <div class="overflow-x-auto p-4 ">
                        <table class="w-full text-sm  text-gray-700 rounded-md">
                            <tbody>
                                <tr class="border-b border-gray-200">
                                    <td  class="uppercase font-semibold px-3 py-2 w-1/3">Customer</td>
                                    <td class="px-3 py-2">{{ $misaccount->member->member_info_first_name }} {{ $misaccount->member->member_info_last_name }} </td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td  class="uppercase font-semibold px-3 py-2">Open Date</td>
                                    <td class="px-3 py-2"> {{$misaccount->open_date}}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="uppercase font-semibold px-3 py-2">Maturity Date</td>
                                    <td class="px-3 py-2">{{$misaccount->maturity_date}}</td>
                                </tr>
                                <tr class="border-b border-gray-200">
                                    <td class="uppercase font-semibold px-3 py-2">Status</td>
                                    <td class="px-3 py-2">{{$misaccount->status}}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        function toggleSection(button) {
            const section = button.closest('.box').querySelector('.overflow-x-auto');
            const icon = button.querySelector('.toggle-icon');
            section.classList.toggle('hidden');
            icon.textContent = section.classList.contains('hidden') ? '+' : '−';
        }
    </script>
@endsection