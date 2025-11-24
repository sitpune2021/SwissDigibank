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

    .tableWidth {
        width: 90%;
        margin: auto;

    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <h1 class="text-xl font-semibold uppercase">
                Mortgage Loan - Auddit Trail
                </h1>
            </div>

        </div>



<section class="p-4">
  <div class="grid grid-cols-1 gap-6">

    <!-- FD ACCOUNT AUDIT TRAIL -->
    <div class="bg-white shadow-md rounded overflow-hidden p-2">
      <!-- Header -->
      <div class="flex items-center justify-between rounded-10 bg-secondary/5 px-4 py-3 cursor-pointer"
           onclick="this.nextElementSibling.classList.toggle('hidden')">
        <h3 class="text-lg text-black font-semibold">Mortgage LOAN ACCOUNT AUDIT TRAIL</h3>
      
      </div>

      <!-- Body -->
      <div class="p-4">
        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-sm">
            <thead>
              <tr class="bg-gray-100 text-gray-700">
                <th class=" px-4 py-2 text-left">Creator</th>
                <th class="px-4 py-2 text-left">Event</th>
                <th class=" px-4 py-2 text-left">Create On</th>
                <th class=" px-4 py-2 text-left">Change Logs</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data rows go here -->
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- MEMBER FD ACCOUNT SETTING AUDIT TRAIL -->
    <div class="bg-white shadow-md rounded p-2 overflow-hidden">
      <!-- Header -->
      <div class="flex items-center justify-between rounded-10 bg-secondary/5 px-4 py-3 cursor-pointer"
           onclick="this.nextElementSibling.classList.toggle('hidden')">
        <h3 class="text-lg font-semibold">Mortgage LOAN APPLICATION AUDIT TRAIL</h3>
        
      </div>

      <div class="p-4 hidden">
        <div class="overflow-x-auto">
          <table class="w-full border-collapse text-sm">
            <thead>
              <tr class="bg-gray-100 text-gray-700">
                <th class="px-4 py-2 text-left">Creator</th>
                <th class="px-4 py-2 text-left">Event</th>
                <th class=" px-4 py-2 text-left">Create On</th>
                <th class=" px-4 py-2 text-left">Change Logs</th>
              </tr>
            </thead>
            <tbody>
            
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>



</div>
        

          
         

               
@endsection