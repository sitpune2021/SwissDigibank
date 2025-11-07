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

    .bg-greens {
        background-color: #14532d;
    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block  uppercase  font-bold">
                Add New Locker
            </h3>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">

            <div class=" col-span-2 box md:col-span-1 ">
                <form action="">
                <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                        Branch
                        <span class="text-red-500">*</span>
                    </label>

                    <select name="" id="schemeSelect"
                        class=" scheme-select w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 ">
                        <option value="" class="opt-default">Select Branch</option>

                    </select>
                </div>
                <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                       Locker No 
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="" id=""
                        class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " placeholder="Enter Locker No ">
                </div>
                <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                      Locker Name 
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="text" name="" id=""
                        class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " placeholder="Enter Locker Name">
                </div>
                  <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                    <label for="" class="md:text-lg font-medium block mb-2 uppercase">
                     Charges (Monthly)  
                        <span class="text-red-500">*</span>
                    </label>

                    <input type="number" name="" id=""
                        class=" w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3 " placeholder="Enter Locker charges monthly">
                </div>
                 <div class="col-span-2 md:col-span-1 mt-4 mb-3">
                    <div class="flex   min-w-10 sm:flex-row justify-center gap-3 mt-5">
                            <div class="">
                                <button class="btn-primary uppercase justify-center" type="submit" name="save_scheme">
                                    Add Locker
                                </button>
                            </div>

                            <div class="">
                                <button class="btn-outline uppercase justify-center" type="reset">
                                    <a href="#"> BACK</a>
                                </button>
                            </div>
                 </div>
            </div>
          </form>
        </div>
        
        </div>
@endsection