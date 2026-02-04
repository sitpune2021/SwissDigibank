@extends('layout.main')
@section('page-title', 'Sweep In Fixed Deposits')
@section('action-button')
@endsection

@section('content')

<style>
.form-content {
    overflow: hidden;
    transition: all 0.3s ease-in-out;
}
.form-content:not(.open) {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    opacity: 0;
}
.form-content.open {
    max-height: 2000px;
    opacity: 1;
}
</style>

<div class="box">
    <div class="flex justify-between border-b" id="formHeader">
        <div class="text-lg font-semibold uppercase">
            Search Box
        </div>
        <button type="button"
            class="text-gray-500 hover:text-gray-700 focus:outline-none transition-transform duration-300"
            id="toggleBtn">

           
         <i id="minusIcon" class="las la-minus text-xl"></i>


            <i id="plusIcon" class="las la-plus text-xl hidden"></i>
        </button>
    </div>

    <div class="form-content open" id="formContent">
        <form method="POST" action="" id="searchForm" class="p-6 box dark:bg-bg3 rounded-lg ">
            @csrf

            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 font-medium md:text-lg">Branch</label>
                    <select name="account_type"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select Branch</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Associate</label>
                    <select name="account_type"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select Associate</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Collection Center</label>
                    <select name="account_type"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select Collection Center</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Group</label>
                    <select
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select Group</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Account No</label>
                    <input type="text"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3"
                        placeholder="Enter Account No">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">A/C Status</label>
                    <select
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                        <option value="">Select A/C Status</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Scheme Name</label>
                    <input type="text" placeholder="Enter Scheme Name"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Scheme Code</label>
                    <input type="text" placeholder="Enter Scheme Code:"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Open Date From</label>
                    <input type="text" placeholder="DD/MM/YYYY"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Open Date To</label>
                    <input type="text" placeholder="DD/MM/YYYY"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Close Date From</label>
                    <input type="text" placeholder="DD/MM/YYYY"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Close Date To</label>
                    <input type="text" placeholder="DD/MM/YYYY"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Customer No</label>
                    <input type="text" placeholder="Enter Customer No"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Customer First Name</label>
                    <input type="text" placeholder="Enter Customer First Name"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Customer Last Name</label>
                    <input type="text" placeholder="Enter Customer Last Name"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium md:text-lg">Mobile No</label>
                    <input type="text" placeholder="Enter Mobile No"
                        class="w-full px-3 py-2 text-sm border bg-secondary/5 dark:bg-bg3 border-n30 dark:border-n500 rounded-10 md:px-6 md:py-3">
                </div>
            </div>

            <div class="flex gap-4 mt-6 justify-center items-center">
                <button class="btn-primary uppercase" type="submit">
                    <i class="las la-search"></i> Search
                </button>

                <button class="btn-outline uppercase" type="button" id="clearBtn">
                    Clear Form
                </button>
            </div>
        </form>
    </div>
</div>
<div class="mt-5 box">
    <p>No FD Found</p>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const formHeader = document.getElementById('formHeader');
    const toggleBtn = document.getElementById('toggleBtn');
    const formContent = document.getElementById('formContent');
    const minusIcon = document.getElementById('minusIcon');
    const plusIcon = document.getElementById('plusIcon');
    const clearBtn = document.getElementById('clearBtn');
    const searchForm = document.getElementById('searchForm');

    function toggleForm() {
        formContent.classList.toggle('open');
        const isOpen = formContent.classList.contains('open');
        minusIcon.classList.toggle('hidden', !isOpen);
        plusIcon.classList.toggle('hidden', isOpen);
        toggleBtn.style.transform = isOpen ? '' : '';
    }

    formHeader.addEventListener('click', toggleForm);

    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleForm();
    });

    clearBtn.addEventListener('click', function () {
        searchForm.reset();
    });

});
</script>

@endsection
