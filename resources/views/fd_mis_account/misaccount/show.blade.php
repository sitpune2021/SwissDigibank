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

  .tableWidth {
    width: 90%;
    margin: auto;
  }

  .bg-yellow {
    background-color: #e17100;
  }

  .sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
  }

  /* Container for the toggle background */
  .blocks {
    width: 56px;
    /* 14 * 4px */
    height: 32px;
    /* 8 * 4px */
    border-radius: 9999px;
    /* Fully rounded */
    background-color: #9CA3AF;
    /* Tailwind gray-400 default */
    transition: background-color 0.3s ease;
  }

  /* The small white dot */
  .dot {
    position: absolute;
    top: 4px;
    /* 1 * 4px */
    left: 4px;
    /* 1 * 4px */
    width: 24px;
    /* 6 * 4px */
    height: 24px;
    /* 6 * 4px */
    background-color: white;
    border-radius: 9999px;
    transition: transform 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
  }

  /* When the checkbox is checked, change bg color */
  input[type="checkbox"].slider-toggle:checked+div .blocks {
    background-color: #228cc5;
    /* Tailwind green-500 */
  }

  /* Move the dot to right when checked */
  input[type="checkbox"].slider-toggle:checked+div .dot {
    transform: translateX(24px);
    /* 6 * 4px */
  }
</style>
<div class="main-inner">
   @if ($misaccount->status == 0)
    <div style="background:#f39c12; padding:20px; color:white; margin-bottom:20px; border-radius:5px;">
        <h4 style="margin:0;">PENDING REQUEST</h4>
        <p style="margin:5px 0;">
            Approval request has been made for the loan application & is pending for approval.
            To approve
            <a href="{{ route('approveAccounts') }}"
                style="background:#e74c3c; color:white; padding:6px 12px; text-decoration:none; border-radius:4px;">
                CLICK HERE
            </a>
        </p>
    </div>
    @endif
    {{-- @if ($hasPendingPrincipal) 
    <div style="background:#f39c12; padding:20px; color:white; margin-bottom:20px; border-radius:5px;">
        <h4 style="margin:0;"> ALERT PENDING TRANSACTION!</h4>
        <p style="margin:5px 0;">
            Some transactions are pending for approval. To approve
            <a href="{{ url('approvals/pending-transaction') }}"
                style="background:e74c3c; color:white; padding:6px 12px; text-decoration:none; border-radius:4px;">
                CLICK HERE
            </a>
        </p>
    </div>
@endif --}}
   
  <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
    <div class="flex items-start flex-col gap-2">
      <h1 class="text-lg font-semibold">MIS ACCOUNT - {{'' . $misaccount->mis_account_no}} </h1>
      <!-- <p class="text-gray-500">
        <a href="{{route('misaccount.index')}}" class="text-gray-500">MIS ACCOUNT</a> >
        <a href="#" class="text-gray-500"> {{'' . $misaccount->member_id}} </a>
      </p> -->
    </div>
  </div>

  <div class="flex flex-wrap gap-3">
    <!--  Payout Plan -->
    <a href="{{route('misaccount.mispayout', $misaccount->id)}}" class="btn-primary text-sm px-2 py-2 rounded-10 ">
      PAYOUT PLAN
    </a>

    <!-- View Transactions -->
    <a href="{{ route('mis.transaction',$misaccount->id) }}" class="btn-secondary text-sm px-2 py-2 rounded-10 ">
      VIEW TRANSACTIONS
    </a>

    <!-- Account Details -->
    <div class="relative inline-block text-left">
      <a id="accountButton" class="flex items-center px-2 py-2 rounded-10 btn-warning text-sm text-white">
        ACCOUNT DETAILS
        <i id="accountArrow" class="las la-angle-down ml-2"></i>
      </a>

      <!-- Dropdown menu -->
      <!-- <div id="accountMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
        <a href="#" class="block px-4 py-2 uppercase  hover:bg-warning">change Account info</a>
        <a href="#" class="block px-4 py-2 uppercase hover:bg-warning">Add Nominee</a>

      </div> -->

      <div id="accountMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
        @if($misaccount->status == 1)
        <a href="{{ route('misaccount.changeAccountInfo', $misaccount->id) }}"
          class="block px-4 py-2 uppercase hover:bg-warning">
          Change Account Info
        </a>
        <a href="{{ route('mis.accounts.nominee', ['type'=>'mis','id'=>base64_encode($misaccount->id)]) }}"
          class="block px-4 py-2 uppercase hover:bg-warning">
          Add Nominee
        </a>
        <a href="{{ route('misaccount.foreclose', $misaccount->id) }}"
          class="block px-4 py-2 uppercase hover:bg-warning">
          Fore Close
        </a>
        @endif
        <a href="{{ route('misaccount.removeAccount', $misaccount->id) }}"
          class="block px-4 py-2 uppercase hover:bg-warning">
          Remove Account
        </a>
      </div>


    </div>


    <!--   RELEASE INTEREStT-->
    @if($misaccount->status == 1)
    <a class="btn-primary text-sm px-2 py-2  rounded-10 ">
      RELEASE INTEREST
    </a>
    <!--   RELEASE INTEREStT-->
    <a href="{{route('misaccount.linkSavingsAccount',$misaccount->id)}}" class="btn-warning text-sm px-2 py-2  rounded-10 ">
      LINK SAVING ACCOUNT(AUTO CREDIT)
    </a>

    <!--  MARK LIEN AGAINST LOAN-->
    <a href="{{ route('misaccount.makelien', $misaccount->id) }}" class="btn-error text-sm px-2 py-2   rounded-10 ">
      MARK LIEN AGAINST LOAN
    </a>

    <!-- INTEREST/TDS Button -->
    <div class="relative inline-block text-left">
      <a id="interestButton" class="btn-secondary text-sm px-2 py-2 rounded-10 flex items-center">
        INTEREST/TDS
        <i id="interestArrow" class="las la-angle-down ml-2"></i>
      </a>

      <div id="interestMenu" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded-md shadow-lg z-50">
        <a href="{{ route('misaccount.creditDebitInterest', $misaccount->id) }}" class="block px-4 py-2 uppercase ">CREDIT/DEBIT INTEREST</a>
        <a href="{{ route('misaccount.deductReverseTds', $misaccount->id) }}" class="block px-4 py-2 uppercase ">DEDUCT/REVESRE TDS</a>

      </div>
    </div>
    @endif

    <div class="relative inline-block text-left">
      <a id="dropdownButton" class="flex cursor-pointer items-center text-sm px-2 py-2  rounded-10 btn-secondary text-white">
        <i class="las la-print mr-2"></i>
        PRINT DOCUMENTS
        <i id="dropdownArrows" class="las la-angle-down ml-2"></i>

      </a>

      <!-- Dropdown menu -->
      <div id="dropdownsMenu" class="hidden absolute right-0 mt-2 w-full bg-white border rounded-lg shadow-lg z-50">
        <a href="{{ route('misaccount.printbond.view',$misaccount->id) }}" class="block px-4 py-2">MIS BOND</a>
        <a href="{{ route('misaccount.openingform.preview',$misaccount->id) }}" class="block px-4 py-2">ACCOUNT OPENING FORM</a>
        <a href="{{ route('misaccount.closingform.preview',$misaccount->id) }}" class="block px-4 py-2">CLOSING FORM</a>
      </div>
    </div>




    <!-- Show Audit Trail -->
    <a class="btn-secondary text-sm px-2 py-2  rounded-10  ">
      SHOW AUDIT TRAIL
    </a>
  </div>

  <div class="flex flex-col dark:bg-bg3 lg:flex-row justify-between mt-7 gap-5">

    <!-- Left: Details -->
    <div class=" w-full  overflow-hidden">
      <div class="overflow-x-auto rounded-lg dark:bg-bg3 p-2  bg-white shadow-md">
        <table class="w-full text-sm text-left border-collapse">
          <tbody class="divide-y divide-gray-200">
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 w-1/3 uppercase">Customer</td>
              <td class="px-4 py-2">
                <a href="" class="text-primary hover:underline">
                  {{ $misaccount->member->member_no ?? ($misaccount->member_id ? str_pad($misaccount->member_id, 6, '0', STR_PAD_LEFT) : '-') }} - {{ $misaccount->member->member_info_first_name ?? 'N/A' }}
                </a>
              </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold  px-4 py-2 uppercase">Create on</td>
              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($misaccount->created_at)->format('d-m-Y') }}</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Created by</td>
              <td class="px-4 py-2">-</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">MIS No.</td>
              <td class="px-4 py-2"> {{ '' . $misaccount->mis_account_no}} </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Old MIS No.</td>
              <td class="px-4 py-2">—</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Scheme</td>
              <td class="px-4 py-2">{{ $misaccount->fdScheme->scheme_name ?? '-' }}</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Principal Amount</td>
              <td class="px-4 py-2">₹ {{ number_format($misaccount->mis_amount, 2) }}</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Open Date</td>
              <td class="px-4 py-2">
                {{ \Carbon\Carbon::parse($misaccount->open_date)->format('d-m-Y') }}
              </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Maturity Date</td>
              <td class="px-4 py-2">
                {{ \Carbon\Carbon::parse($misaccount->maturity_date)->format('d-m-Y') }}
              </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Close Date</td>
              <td class="px-4 py-2">{{ \Carbon\Carbon::parse($misaccount->closing_date)->format('d-m-Y') }}</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
              <td class="px-4 py-2">
                {{ $rate }} %
              </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Balance Available</td>
              <td class="px-4 py-2">₹{{ number_format($balance, 2) }}</td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Status</td>
              @if($misaccount->status == 0)
              <td class="px-4 py-2">Pending</td>
              @elseif($misaccount->status == 1)
              <td class="px-4 py-2">Active</td>
              @elseif($misaccount->status == 2)
              <td class="px-4 py-2">Rejected</td>
              @elseif($misaccount->status == 3)
              <td class="px-4 py-2">Foreclosed</td>
              @endif
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">TDS Deduction</td>
              <td class="px-4 py-2">
                @if($misaccount->tds_deduction === 'yes')
                <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                  Yes
                </span>
                @else
                <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                  No
                </span>
                @endif
              </td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Special Account</td>
              <td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium rounded ">-</span></td>
            </tr>

            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">IS Lien</td>
              <td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium rounded ">-</span></td>
            </tr>
            <tr class="border-b">
              <td class="font-semibold px-4 py-2 uppercase">Sweep In</td>
              <td class="px-4 py-2"><span class="px-2 py-1 text-xs font-medium rounded">-</span></td>
            </tr>
          </tbody>
        </table>
      </div>



      <!--MEMBER DETAILS-->
      <div class="bg-white shadow-md mt-5 box  dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="border-b px-4 py-3 rounded-10  bg-secondary/5">
          <h3 class="text-lg font-semibold text-black">CUSTOMER DETAILS</h3>
        </div>

        <!-- Body -->
        <div class="p-4 overflow-x-auto">
          <table class="w-full whitespace-nowrap text-sm text-left">
            <tbody class="divide-y divide-gray-200">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase ">Customer Name</td>
                <td class="px-4 py-2">
                  {{ ($misaccount->member->member_no ?? ($misaccount->member->id ? str_pad($misaccount->member->id, 6, '0', STR_PAD_LEFT) : '-'))
                      . ' - ' .
                      (($misaccount->member->member_info_first_name && $misaccount->member->member_info_last_name)
                      ? ucfirst($misaccount->member->member_info_first_name) . ' ' . ucfirst($misaccount->member->member_info_last_name)
                      : 'N/A') }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold uppercase px-4 py-2">Mobile No</td>
                <td class="px-4 py-2"> {{ $misaccount->member->member_info_mobile_no ?? 'N/A' }}</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold uppercase px-4 py-2">Address</td>
                <td class="px-4 py-2">{{ $misaccount->member->full_address ?? 'N/A' }}</td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-white shadow-md box mt-5 rounded-lg dark:bg-bg3 overflow-hidden">
        <!-- Header -->
        <div class="border-b px-4 py-3 flex items-center rounded-10  gap-4 justify-between bg-secondary/5">
          <h3 class="text-lg font-semibold uppercase  text-black">
            ALLOCATED PASSBOOK
          </h3>
          <a href="{{ route('passbook.create-passbook') }}" class="btn-primary px-3 py-2 rounded-10 text-sm uppercase text-white">
            <i class="las la-plus"></i>
            passbook
          </a>
        </div>

        <!-- Body -->
        <div class="p-4">
          <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
              <thead class="bg-gray-100  text-gray-700">
                <tr class="border-b bg-secondary/5">
                  <th class="px-4 py-2 font-semibold uppercase">Passbook No</th>
                  <th class="px-4 py-2 font-semibold uppercase">Issue Date</th>
                  <th class="px-4 py-2 font-semibold uppercase">Action</th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 whitespace-nowrap">
                @forelse($passbooks as $pass)
                <tr class="border-b text-center">
                  <td class="px-4 py-2">{{ $pass->passbook_no ?? 'N/A' }}</td>
                  <td class="px-4 py-2">{{ \Carbon\Carbon::parse($pass->issue_date)->format('d-m-Y')  ?? 'N/A' }}</td>
                  <td class="px-4 py-2">
                    <div class="w-full flex gap-3 justify-center">

                      <!-- Edit -->
                      <a href="{{ route('passbook.edit-passbook', $pass->id) }}"
                        class="btn-primary  p-1">
                        <i class="las la-edit "></i>
                      </a>

                      <!-- View -->
                      <a href="{{ route('passbook.show', $pass->id) }}"
                        class="btn-primary  p-1">
                        <i class="las la-eye "></i>
                      </a>

                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="py-3 text-center text-gray-500">
                    No MIS passbooks found.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>

      <!--documents-->
      <div class="bg-white dark:bg-bg3 box shadow-md mt-5 rounded-10 overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between rounded-10 bg-secondary/5 text-black px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('hidden')">
          <h3 class="text-lg font-semibold">DOCUMENTS</h3>
          <a href="{{ route('mis.uploadDocuments',$misaccount->id) }}" class=" btn-primary rounded-full p-1  w-2"><i class="las la-upload"></i>
          </a>
        </div>

        <!-- Body -->
        <div class="p-4">
          <div class="overflow-x-auto">
            @if($documents->isEmpty())
            <p class="capitalize text-gray-500">No documents found</p>
            @else
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md responsive-table">
              <thead class="bg-gray-100  text-gray-700">
                <tr class="border-b">
                  <th class="px-4 py-2 font-semibold">Name</th>
                  <th class="px-4 py-2 font-semibold">URL</th>
                  <th class="px-4 py-2 font-semibold">Action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach($documents as $doc)
                <tr class="border-b text-center">
                  <td class="px-4 py-2">{{ $doc->document_type }}</td>
                  <td class="px-4 py-2">
                    <a href="{{ asset('storage/'.$doc->file_path) }}" target="_blank" class="text-primary underline">
                      Show
                    </a>
                  </td>
                  <td class="px-4 py-2">
                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-800">
                        Delete
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif
          </div>
        </div>
      </div>

      <!--COMMENTS-->
      <div class="bg-white box dark:bg-bg3 shadow-md mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('hidden')">
          <h3 class="text-lg rounded-10 font-semibold">COMMENTS</h3>

        </div>

        <!-- Body -->
        <div class="p-4">

          <div class="overflow-x-auto">

            @if($misaccount->comments->count() == 0)
            <p class="capitalize text-gray-500">No comments found</p>
            @else
            <table class="w-full mt-3 text-sm text-left">
              <thead>
                <tr class="border-b bg-secondary/5">
                  <th class="px-4 py-2 uppercase font-semibold">Comment</th>
                  <th class="px-4 py-2 uppercase font-semibold">Commented By</th>
                  <th class="px-4 py-2 uppercase font-semibold">Date</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach($misaccount->comments as $comment)
                <tr class="hover:bg-gray-50 border-b">
                  <td class="px-4 py-2">{{ $comment->comment }}</td>
                  <td class="px-4 py-2">
                    {{ $comment->commented_by ? \App\Models\User::find($comment->commented_by)->name : '-' }}
                  </td>
                  <td class="px-4 py-2">{{ \Carbon\Carbon::parse($comment->date)->format('d-m-Y ') ?? '' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @endif
            <div class="overflow-x-auto text-center mt-5">
              @if($misaccount->comments->count() > 0)
              <a href="{{ route('mis.addComment', $misaccount->id) }}" class="btn-primary px-3 py-2 uppercase rounded-10 text-sm text-white">View All</a>
              @endif
              <a href="{{ route('mis.addComment', $misaccount->id) }}" class="btn-primary px-3 py-2 uppercase rounded-10 text-sm text-white">Add Comments</a>
            </div>
          </div>
        </div>

      </div>
      <!--Transactions Info-->
      <div class="bg-white shadow-md dark:bg-bg3 box  mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5  text-black rounded-10 px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('')">
          <h3 class="text-lg font-semibold uppercase">Transactions Info</h3>

        </div>

        <!-- Body -->
        <div class="p-4">
          <div class="overflow-x-auto text-center mt-5">
            <div class="whitespace-nowrap overflow-x-auto">
              <table class="w-full border-collapse whitespace-nowrap overflow-x-auto rounded-lg overflow-hidden shadow-md responsive-table">
                <thead class="bg-gray-100 text-start text-gray-700">
                  <tr class="border-b  bg-secondary/5">
                    <th class="px-4 py-2 text-start text-sm font-semibold">DATE</th>
                    <th class="px-4 py-2 text-start text-sm font-semibold">TYPE</th>
                    <th class="px-4 py-2 text-start text-sm font-semibold">PAYMENT MODE</th>
                    <th class="px-4 py-2 text-start text-sm font-semibold">AMOUNT</th>
                    <th class="px-4 py-2 text-start text-sm font-semibold">STATUS</th>
                  </tr>
                </thead>
                @forelse($misaccount->transactions as $transaction)
                <tr class="border-b">
                  <td class="px-4 py-2 text-start text-sm font-semibold">
                    {{ $transaction->created_at->format('d-m-Y') }}
                  </td>
                  <td class="px-4 py-2 text-start text-sm font-semibold"> {{ $transaction->credited }}</td>
                  <td class="px-4 py-2 text-start text-sm font-semibold">{{ ucfirst($transaction->pay_mode) }}</td>
                  {{-- <td>
                        @if($transaction->bank)
                        {{ $transaction->bank->name }}
                  @elseif($transaction->savingAccount)
                  Saving A/c: {{ $transaction->savingAccount->account_no }}
                  @else
                  -
                  @endif
                  </td> --}}
                  <td class="px-4 py-2 text-start text-sm font-semibold">{{ number_format($transaction->amount, 2) }}
                  </td>
                  <td class="px-4 py-2 text-start text-sm font-semibold">N/A</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4">No transactions found</td>
                </tr>
                @endforelse

              </table>
            </div>

            <a href="{{ route('mis.transaction',$misaccount->id) }}" class="btn-primary px-3 py-2 mt-5 rounded-10 uppercase text-sm text-white">View All</a>
          </div>
        </div>

      </div>

    </div>
    <!-- Right: Settings -->
    <div class=" w-full ">

      <!--settings-->
      <div class="box dark:bg-bg3 border-gray-200 shadow-md rounded-lg">
        <!-- Header -->
        <div class="px-4 py-3">
          <h3 class="text-lg border-b font-semibold text-black">SETTINGS</h3>
        </div>
        <div class="p-4 overflow-x-auto">
          <table class="min-w-full text-sm text-left">
            <tbody class="divide-y divide-gray-200">

              <!-- SMS Toggle -->
              <tr>
                <td class="font-semibold text-center align-middle px-4 py-3 w-1/3">SMS</td>
                <td class="px-4 py-3">
                  <!-- <input type="hidden" name="sms" id="smsValue" value="0"> -->
                  <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="smsToggle" class="sr-only slider-toggle" data-label-id="smsLabel" {{ $misaccount->sms ? 'checked' : '' }}>
                    <div class="relative">
                      <div class="blocks w-14 h-8 bg-gray-500 rounded-full peer-checked:bg-primary transition-all">
                      </div>
                      <div
                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                      </div>
                    </div>
                    <span id="smsLabel" class="ml-4 text-sm font-medium text-black">OFF</span>
                  </label>
                </td>
              </tr>

              <!-- DEDUCT TDS Toggle -->
              <tr>
                <td class="font-semibold text-center align-middle px-4 py-3">DEDUCT TDS</td>
                <td class="px-4 py-3">
                  <!-- <input type="hidden" name="tds" id="tdsValue" value="0"> -->
                  <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="tdsToggle" class="sr-only slider-toggle" data-label-id="tdsLabel" {{ $misaccount->tds ? 'checked' : '' }}>
                    <div class="relative">
                      <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                      </div>
                      <div
                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                      </div>
                    </div>
                    <span id="tdsLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span>
                  </label>
                </td>
              </tr>

              <!-- ACCOUNT ON HOLD Toggle -->
              <tr>
                <td class="font-semibold text-center align-middle px-4 py-3">ACCOUNT ON HOLD</td>
                <td class="px-4 py-3">
                  <!-- <input type="hidden" name="hold" id="holdValue" value="0"> -->
                  <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="holdToggle" class="sr-only slider-toggle" data-label-id="holdLabel" {{ $misaccount->hold ? 'checked' : '' }}>
                    <div class="relative">
                      <div class="blocks w-14 h-8 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-all">
                      </div>
                      <div
                        class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-6">
                      </div>
                    </div>
                    <span id="holdLabel" class="ml-4 text-sm font-medium text-gray-700">OFF</span>
                  </label>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>


      <!--AUTO RENEW SETTINGS-->
      <div class="box dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
        <!-- Header -->
        <div class=" bg-secondary/5 rounded-10 px-4 py-3">
          <h3 class="text-lg font-semibold text-black ">AUTO RENEW SETTINGS</h3>
        </div>

        <!-- Body -->
        <div class="p-4">
          <form class="space-y-6">

            <!-- AUTO RENEW -->
            <div class="flex flex-col md:flex-row md:items-center md:gap-6">
              <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW</label>
              <div class="flex gap-6  md:mt-0">
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="fd_account[auto_renew]" value=""
                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                  <span>Yes</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                  <input type="radio" name="fd_account[auto_renew]" value="false" checked
                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                  <span>No</span>
                </label>
              </div>
            </div>

            <!-- AUTO RENEW INSTRUCTION -->
            <div class="flex flex-col md:flex-row mt-5 md:items-center md:gap-6">
              <label class="md:w-1/3 font-medium text-gray-700">AUTO RENEW INSTRUCTION</label>

              <select name="fd_account[auto_renew_instruction]"
                class="w-full  rounded-10 bg-secondary/5 py-3  shadow-sm focus:ring-primary focus:border-blue-500 text-sm p-2">
                <option value="">Select Instruction</option>
                <option value="">REINVEST_PRINCIPAL</option>
                <option value="">REINVEST_PRINCIPAL_AND_INTEREST</option>
              </select>

            </div>

            <!-- Submit Button -->
            <div class="text-center mt-5">
              <button type="submit" class="btn-primary px-4 py-2 rounded-10 text-sm ">
                UPDATE
              </button>
            </div>
          </form>
        </div>
      </div>


      <!---->
      <div class="bg-white dark:bg-bg3 shadow-md mt-4 rounded-xl border border-gray-200">
        <!--Old MIS No.-->
        <form action="" class="mt-3 p-3">
          <label for="" class="block font-semibold uppercase">Old MIS No.</label>
          <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
            <input type="text" name="" id="" class="block w-full rounded-10 bg-secondary/5 border py-3 px-3 dark:text-white"
              placeholder="Enter Old MIS Number">
            <input type="button" value="UPDATE" class="block  text-sm rounded-10 btn-primary">
          </div>
        </form>

        <!--Branch-->
        <form action="{{ route('misaccount.update-branch', $misaccount->id) }}" method="POST" class="mt-2 px-3">
          @csrf
          @method('PUT')

          <label for="branch" class="block mb-2 font-semibold uppercase">Branch</label>
          <div class="flex flex-row items-center gap-3 justify-between">
            <select name="branch_id" id="branch_id"
              class="block w-full rounded-10 bg-secondary/5 border px-3 py-3 dark:text-white">
              <option value="">Select branch</option>
              @foreach ($branches as $branch)
              <option value="{{ $branch->id }}" {{ $misaccount->branch_id == $branch->id ? 'selected' : '' }}>
                {{ $branch->branch_name }}
              </option>
              @endforeach
            </select>

            <button type="submit" class="block btn-primary text-sm rounded-10 uppercase">UPDATE</button>
          </div>
        </form>

        <!--Advisor/ Staff-->
        <form action="" class="mt-2 px-3">
          <label for="" class="block uppercase font-semibold">Advisor/ Staff</label>
          <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
            <select class="w-full rounded-10 bg-secondary/5 border  px-3 py-3
           dark:bg-bg3 dark:text-white">
              <option>Select option</option>

              <option>Option 2</option>
            </select>

            <input type="button" value="UPDATE" class="block text-sm rounded-10  btn-primary">

          </div>
        </form>

        <div class=" px-6 flex py-4 flex-row items-center gap-6">
          <p class="w-full  uppercase font-semibold">Current Chart</p>
          <a href="#" class="text-primary w-full">MISVVPAT</a>
        </div>

        <!--Commission Chart-->
        <form action="" class="mt-2 px-3 pb-4">
          <label for="" class="block font-semibold uppercase">Commission Chart</label>
          <div class="mt-2 flex flex-row items-center gap-3 justify-between ">
            <select class="w-full rounded-10 bg-secondary/5 border  px-3 py-3
           dark:bg-bg3 dark:text-white">
              <option>Select option</option>

              <option>Option 2</option>
            </select>

            <input type="button" value="UPDATE" class="block text-sm rounded-10  btn-primary">

          </div>
        </form>

      </div>

      <!-- Fore Close  -->
      @if($misaccount->status == 3)
      <div class="bg-white shadow-md box mt-5 dark:bg-bg3 dark:border-lightbg1 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="border-b px-4 py-3 bg-secondary/5 rounded-10">
          <h3 class="text-lg font-semibold text-black uppercase ">Fore Closure Info</h3>
        </div>

        <!-- Body -->
        <div class="p-4 overflow-x-auto whitespace-nowrap">
          <table class="w-full overflow-x-auto whitespace-nowrap text-sm text-left">
            <tbody class="divide-y divide-gray-200">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 w-1/3 uppercase">Fore Close Date</td>
                <td class="px-4 py-2">
                  {{ $misaccount->foreclose_request_date 
                    ? \Carbon\Carbon::parse($misaccount->foreclose_request_date)->format('d-m-Y') 
                    : '-' }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Principal Amount</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($misaccount->mis_amount ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Current Balance (A)</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($balance ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Balance Interest to Credit (B)</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($misaccount->foreclose_interest_left ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">TDS on Balance Interest to Credit (C)</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($misaccount->foreclose_tds ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Penal Charges to Deduct (D)</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($misaccount->foreclose_penal_charges ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Fore Closure Charges (E)</td>
                <td class="px-4 py-2">
                  ₹ {{ number_format($misaccount->foreclose_cancellation_charges ?? 0, 2) }}
                </td>
              </tr>

              <tr class="border-b bg-gray-50 font-semibold">
                <td class="px-4 py-2 uppercase">
                  Final Payable Amount (A + B - C - D - E)
                </td>
                <td class="px-4 py-2 text-green-700">
                  ₹ {{ number_format($misaccount->foreclose_final_amount ?? 0, 2) }}
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
      @endif

      <!--Scheme Info-->
      <div class="bg-white shadow-md box dark:bg-bg3  mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('')">
          <h3 class="text-lg font-semibold uppercase">Scheme Info</h3>

        </div>

        <!-- Body -->

        <div class="overflow-x-auto   mt-5">
          <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Scheme Name</td>
                <td class="px-4 py-2 text-right md:text-left">
                  {{ $misaccount->fdScheme->scheme_name ?? '-' }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Scheme Code</td>
                <td class="px-4 py-2 text-right md:text-left">
                  {{ $misaccount->fdScheme->scheme_code ?? '-' }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Minimum Locking Period</td>
                <td class="px-4 py-2 text-right md:text-left capitalize">
                  {{ $misaccount->fdScheme->lock_in_period ?? '-' }} months
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Interest Locking Period</td>
                <td class="px-4 py-2 text-right md:text-left capitalize">
                  {{ $misaccount->fdScheme->interest_lock_in ?? '-' }} months
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Tenure of FD/ MIS</td>
                <td class="px-4 py-2 text-right md:text-left">
                  {{ $misaccount->tenure_year ? $misaccount->tenure_year . ' Year(s) ' : '' }}
                  {{ $misaccount->tenure_month ? $misaccount->tenure_month . ' Month(s) ' : '' }}
                  {{ $misaccount->tenure_day ? $misaccount->tenure_day . ' Day(s)' : '' }}
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Interest Payout</td>
                <td class="px-4 py-2 text-right md:text-left">
                  N/A
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Annual Interest Rate (%)</td>
                <td class="px-4 py-2 text-right md:text-left">
                  {{ $misaccount->fdScheme->fdslabs->first()->interest_rate ?? '' }}
                </td>
              </tr>

            </tbody>
          </table>
        </div>



      </div>


      <!--MIS Maturity Info-->
      <div class="bg-white shadow-md dark:bg-bg3  box mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('')">
          <h3 class="text-lg font-semibold uppercase">MIS Maturity Info</h3>

        </div>

        <!-- Body -->

        <div class="overflow-x-auto whitespace-nowrap mt-5">

          <table class="w-full border-collapse rounded-lg overflow-x-auto whitespace-nowrap shadow-md bg-white dark:bg-bg3">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Maturity Date</td>
                <td class="px-4 py-2 text-right md:text-left">{{ \Carbon\Carbon::parse($misaccount->maturity_date)->format('d-m-Y') }}</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Principal Amount (A)</td>
                <td class="px-4 py-2 text-right md:text-left">₹{{$misaccount->mis_amount ?? ''}}</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Total Interest (B)</td>
                <td class="px-4 py-2 text-right md:text-left">₹ {{$misaccount->total_interest ?? '' }}</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Total TDS Deducted (C)</td>
                <td class="px-4 py-2 text-right md:text-left">₹ {{$misaccount->tds ?? ''}}</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Maturity Bonus Amount (D)</td>
                <td class="px-4 py-2 text-right md:text-left">₹ 0.00</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Maturity Amount (A + B + D)</td>
                <td class="px-4 py-2 text-right md:text-left">₹ {{$misaccount->maturity_amount ?? ''}}</td>
              </tr>

              @php
              $principal = $misaccount->mis_amount ?? 0;
              $interest = $misaccount->total_interest ?? 0;
              $bonus = 0; // change if you have bonus column
              $tds = $misaccount->forclose_tds ?? 0;

              $netMaturityAmount = $principal + $interest + $bonus - $tds;
              @endphp

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">
                  Net Maturity Amount (A + B + D - C)
                </td>
                <td class="px-4 py-2 text-right md:text-left">
                  ₹ {{ number_format($netMaturityAmount, 2) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>



      </div>


      <!--MIS Info-->

      <div class="bg-white shadow-md dark:bg-bg3 box  mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5 text-black rounded-10 px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('')">
          <h3 class="text-lg font-semibold uppercase">MIS Info</h3>

        </div>

        <!-- Body -->

        <div class="overflow-x-auto whitespace-nowrap mt-5">
          <table class="w-full border-collapse rounded-lg overflow-x-auto whitespace-nowrap shadow-md bg-white dark:bg-bg3">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Interest Credited</td>
                <td class="px-4 py-2 text-right md:text-left">₹ N/A</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Interest Released</td>
                <td class="px-4 py-2 text-right md:text-left">₹ N/A</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">TDS Deducted</td>
                <td class="px-4 py-2 text-right md:text-left">₹ N/A</td>
              </tr>
            </tbody>
          </table>
        </div>



      </div>


      <!--MIS Branch Info-->

      <div class="bg-white shadow-md dark:bg-bg3 box  mt-5 rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between bg-secondary/5 text-black rounded px-4 py-3 cursor-pointer"
          onclick="this.nextElementSibling.classList.toggle('')">
          <h3 class="text-lg font-semibold uppercase">MIS Branch Info</h3>

        </div>

        <!-- Body -->

        <div class="overflow-x-auto mt-5">
          <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md bg-white dark:bg-bg3">
            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 w-1/2 md:w-1/3 uppercase">Branch</td>
                <td class="px-4 py-2 text-right md:text-left">
                  @if($misaccount->branch)
                  <option value="{{ $misaccount->branch->id }}" selected>
                    {{ $misaccount->branch->branch_name }}
                  </option>
                  @endif
                </td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Advisor/ Staff</td>
                <td class="px-4 py-2 text-right md:text-left">N/A</td>
              </tr>

              <tr class="border-b">
                <td class="font-semibold px-4 py-2 uppercase">Joint Account</td>
                <td class="px-4 py-2 text-right md:text-left">

                  @if($misaccount->joint_member_id)
                  <span class="block w-28 rounded-[30px] border border-n30 bg-primary/20 py-2 text-center text-xs text-primary dark:border-n500 dark:bg-bg3 xxl:w-16">
                    Yes
                  </span>
                  @else
                  <span class="block w-28 rounded-[30px] border border-n30 bg-error/20 py-2 text-center text-xs text-error dark:border-n500 dark:bg-bg3 xxl:w-16">
                    No
                  </span>
                  @endif

                </td>

              </tr>



            </tbody>
          </table>
        </div>



      </div>

    </div>

  </div>
</div>

<script>
  //Account Details
  const accountButton = document.getElementById('accountButton');
  const accountMenu = document.getElementById('accountMenu');
  const accountArrow = document.getElementById('accountArrow');

  accountButton.addEventListener('click', (e) => {
    e.stopPropagation();
    accountMenu.classList.toggle('hidden');

    // Toggle arrow
    if (accountMenu.classList.contains('hidden')) {
      accountArrow.classList.remove('la-angle-up');
      accountArrow.classList.add('la-angle-down');
    } else {
      accountArrow.classList.remove('la-angle-down');
      accountArrow.classList.add('la-angle-up');
    }
  });

  // Close dropdown if clicked outside
  window.addEventListener('click', () => {
    accountMenu.classList.add('hidden');
    accountArrow.classList.remove('la-angle-up');
    accountArrow.classList.add('la-angle-down');
  });

  //Interest/Tds
  const interestButton = document.getElementById('interestButton');
  const interestMenu = document.getElementById('interestMenu');
  const interestArrow = document.getElementById('interestArrow');

  interestButton.addEventListener('click', (e) => {
    e.stopPropagation();
    interestMenu.classList.toggle('hidden');

    // Toggle arrow
    if (interestMenu.classList.contains('hidden')) {
      interestArrow.classList.remove('la-angle-up');
      interestArrow.classList.add('la-angle-down');
    } else {
      interestArrow.classList.remove('la-angle-down');
      interestArrow.classList.add('la-angle-up');
    }
  });

  // Close dropdown if clicked outside
  window.addEventListener('click', () => {
    interestMenu.classList.add('hidden');
    interestArrow.classList.remove('la-angle-up');
    interestArrow.classList.add('la-angle-down');
  });




  //dropdownButton for print doc
  const button = document.getElementById('dropdownButton');
  const menu = document.getElementById('dropdownsMenu');
  const arrow = document.getElementById('dropdownArrows');

  button.addEventListener('click', (e) => {
    e.stopPropagation();
    menu.classList.toggle('hidden');

    // Toggle arrow
    if (menu.classList.contains('hidden')) {
      arrow.classList.remove('la-angle-up');
      arrow.classList.add('la-angle-down');
    } else {
      arrow.classList.remove('la-angle-down');
      arrow.classList.add('la-angle-up');
    }
  });
  window.addEventListener('click', () => {
    menu.classList.add('hidden');
    arrow.classList.remove('la-angle-up');
    arrow.classList.add('la-angle-down');
  });

  // Slider Toggle Functionality
  const mappings = {
    smsToggle: 'sms',
    tdsToggle: 'tds',
    holdToggle: 'hold'
  };

  const updateUrl = "{{ route('mis.updateSetting', $misaccount->id) }}";

  document.querySelectorAll('.slider-toggle').forEach(toggle => {

    toggle.addEventListener('change', function() {
      const field = mappings[this.id];
      const value = this.checked ? 1 : 0;
      const label = document.getElementById(this.dataset.labelId);

      // Update label
      label.textContent = value ? "" : "";

      fetch(updateUrl, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            field: field,
            value: value
          })
        })
        .then(res => res.json())
        .then(data => console.log(data))
        .catch(err => console.error('Error:', err));
    });

    toggle.dispatchEvent(new Event('change'));
  });
</script>


@endsection