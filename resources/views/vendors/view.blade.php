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
       Vendor - Nitin Aarun Shete
      </h3>
    </div>

    <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">
      <!-- Left: Details -->
      <div class=" w-full overflow-x-auto   overflow-hidden">
        <div class="overflow-x-auto box rounded-lg dark:bg-bg3 p-2 bg-white shadow-md">
          <div class="flex items-center justify-end gap-2">
            <div>
              <a href=""  class="btn-primary p-1 rounded-10">
                <i class="las la-pencil-alt"></i>
              </a>
            </div>
            <div >
              <a href="" class="btn-error p-1 rounded-10">
                <i class="las la-trash-alt"></i>
              </a>
            </div>
          </div>
          <div class="w-full p-4">
            <div class="overflow-x-auto ">
              <table class="w-full text-sm text-left border-collapse">
                <tbody class="divide-y divide-gray-200">
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2 w-1/3">Branch</td>
                    <td class="px-4 py-2">
                     	RANPISE NAGAR BRANCH
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase  px-4 py-2"> 
                      Name	
                    </td>
                    <td class="px-4 py-2 capitalize  ">
                      NITIN AARUN SHETE
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">
                      Description
                    </td>
                    <td class="px-4 py-2 capitalize ">
                      GURU SHREE GRAPHICE
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold  uppercase px-4 py-2">
                      Address
                    </td>
                    <td class="px-4 py-2 capitalize">
                      Kunal Commercial Complex , Ranpise nagar chouk akola -444001
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">GST No</td>
                    <td class="px-4 capitalize py-2">
                      NA
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold px-4 uppercase py-2">
                      Linked Accounting Ledger
                    </td>
                    <td class="px-4 py-2 ">
                      <a href="" class="text-primary uppercase" >
                        Liability - Nitin Aarun Shete
                      </a>
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">Bank A/C Name</td>
                    <td class="px-4 capitalize py-2">
                      
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">Bank Name</td>
                    <td class="px-4 capitalize  py-2">
                      
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">IFSC Code	</td>
                    <td class="px-4 capitalize py-2">

                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">
                      Bank Account No	
                    </td>
                    <td class="px-4 capitalize py-2">
                      
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2"> 
                      Linked Saving A/c
                    </td>
                    <td class="px-4 capitalize py-2">
                      <a href="" class="uppercase text-primary">
                        S04974
                      </a>
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2"> Is Active</td>
                    <td class="px-4 py-2">
                        <span
                                class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                               Yes
                            </span>
                            <span
                                class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                               No
                            </span>
                    </td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2"> Created at	</td>
                    <td class="px-4 py-2">10-10-2024</td>
                  </tr>
                  <tr class="border-b">
                    <td class="font-semibold uppercase px-4 py-2">Updated at	</td>
                    <td class="px-4 py-2">10-10-2024</td>
                  </tr>
                 
                </tbody>
              </table>
            </div>

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

  <script>
    const checkbox = document.getElementById('autoLedgerCheckbox');
    const ledgerSelect = document.getElementById('ledgerSelect');
    const note = document.getElementById('ledgerNote');

    // Handle checkbox state change
    checkbox.addEventListener('change', () => {
      if (checkbox.checked) {
        ledgerSelect.disabled = true;
        note.classList.add('hidden');
      } else {
        ledgerSelect.disabled = false;
        note.classList.remove('hidden');
      }
    });
  </script>
@endsection