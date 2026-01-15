@extends('layout.main')

<style>
    input[type="radio"] {
        width: 24px !important;
        height: 24px !important;
        accent-color: green;
        /* Modern browsers */
    }

    input[type="checkbox"] {

        accent-color: green;
        width: 24px !important;
        height: 24px !important;
        /* Modern browsers */
    }
</style>

@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg  uppercase font-semibold">
            Edit Internet Banking Settings
        </h3>

    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif
    <div class="box">
        <form action="">
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-5 border-b py-2 xxxl:gap-6">
                <p class="text-lg  font-semibold">Internet Banking Active <span class="text-error">*</span></p>
                <p class="col-span-2 flex items-center gap-2 md:col-span-1">
                    <input type="radio" name="ib-active" id="">
                    <span>Yes </span>
                    <input type="radio" name="ib-active" id="">
                    <span> No</span>
                </p>

            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-5  xxxl:gap-6">
                <div
                    class="col-span-2 md:col-span-1 flr  py-3 rounded-10 px-3 bg-secondary/5 text-lg uppercase font-semibold">
                    <div class="flex items-center justify-between">
                        <div class=""> Member Net Banking Settings</div>
                        <div class="">
                            <input type="checkbox" id="" name="" value=""
                                class="check-all  item-checkbox form-checkbox h-5 w-5 text-primary">
                        </div>
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 xxxl:gap-6">
               <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Share Holding Details
                        </label>
                    </div>
                </div>
              <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Saving Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Open New Saving Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show RD/ DD Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Open New RD/ DD Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Close RD/ DD Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show FD Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Open New FD/ MIS Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Close FD/ MIS Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Gold Loan Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Property Loan Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Deposit Loan Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Other/ Business Loan Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Vehicle Loan Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Personal Loan Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show Fixed Loan Accounts

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Show CC Limit Accounts
                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Deposit Amount CC Limit Accounts from Saving Ac

                        </label>
                    </div>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 space-x-2">
                        <input type="checkbox" id="" name="" value=""
                            class="check-child item-checkbox form-checkbox h-5 w-5 text-primary">
                        <label for="" class="text-base font-semibold cursor-pointer mb-0">
                            Withdrawal Amount CC Limit Accounts to Saving Ac

                        </label>
                    </div>
                </div>
            </div>
            <div class="flex gap-5 items-center justify-center mt-5">
                <button class="btn-primary uppercase">Update</button>
                <a href="{{ route('software-settings.internet-banking.internet-banking') }}" class="btn-outline uppercase">Back</a>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

    const checkAll = document.querySelector('.check-all');
    const children = document.querySelectorAll('.check-child');

    // Parent → Children
    checkAll.addEventListener('change', function () {
        children.forEach(child => {
            child.checked = this.checked;
        });
    });

    // Children → Parent
    children.forEach(child => {
        child.addEventListener('change', function () {
            const allChecked = Array.from(children).every(c => c.checked);
            checkAll.checked = allChecked;
        });
    });

});
    </script>

    @endsection