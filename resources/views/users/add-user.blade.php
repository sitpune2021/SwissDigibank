@extends('layout.main')



@section('content')

<div class="main-inner">

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">

        <h3 class="h2">New User</h3>

    </div>

    @if (session('success'))

    <div id="success-alert"

        style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">

        <strong>Success:</strong> {{ session('success') }}

        <span onclick="document.getElementById('success-alert').style.display='none';"

            style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>

    </div>

    @endif



    @if (session('error'))

    <div id="error-alert"

        style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">

        <strong>Error:</strong> {{ session('error') }}

        <span onclick="document.getElementById('error-alert').style.display='none';"

            style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>

    </div>

    @endif



    <div class="box mb-4 xxxl:mb-6">

        <form id="companyForm" action="" method="POST"

            class="grid grid-cols-2 gap-4 xxxl:gap-6">

            @csrf



            <div class="col-span-2 md:col-span-1">

                <label for="rate" class="md:text-lg font-medium block mb-4">Employee

                    <select name="employee" id="employeeDropdown"

                        class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                        <option value="">Select Employee</option>

                    </select>



                    @error('employee')

                    <span class="text-red-500 text-xs">{{ $message }}</span>

                    @enderror

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="designation" class="md:text-lg font-medium block mb-4">Designation</label>

                <input type="text" name="designation" id="designation" value="{{ old('designation') }}"

                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter Designation like 'Executive'" value="">

                @error('designation')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="user_name" class="md:text-lg font-medium block mb-4">Login User Name <span

                        class="text-red-500">*</span></label>

                <input type="text" name="user_name" id="user_name" value="{{ old('user_name') }}"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter User Name" value="">

                @error('user_name')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="first_name" class="md:text-lg font-medium block mb-4">First Name<span

                        class="text-red-500">*</span></label>

                <input name="address_line1" id="first_name" value="{{ old('first_name') }}"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter First Name">

                @error('first_name')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="last_name" class="md:text-lg font-medium block mb-4">Last Name</label>

                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter Last Name" value="">

                @error('last_name')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="email" class="md:text-lg font-medium block mb-4">Email</span></label>

                <input type="text" name="email" value="{{ old('email') }}" id="email"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    placeholder="Enter Email" value="">

                @error('email')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="mobile_no" class="md:text-lg font-medium block mb-4">Mobile No.<span

                        class="text-red-500">*</span></label>

                <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no') }}"

                    placeholder="Enter Mobile No."

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="">

                @error('mobile_no')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="back_date" class="md:text-lg font-medium block mb-4">Back Date Entry Days <span class="text-red-500">*</span></label>

                <input type="text" name="back_date" id="back_date" placeholder="Enter Days"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"

                    value="0">

                @error('back_date')

                <span class="text-red-500 text-xs">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="permission_role" class="md:text-lg font-medium block mb-4">Permissions / Roles <span

                        class="text-red-500">*</span></label>

                <select name="permission_role" id="roleDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Role</option>

                </select>

                @error('permission_role')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>



            <div class="col-span-2 md:col-span-1">

                <label for="branch" class="md:text-lg font-medium block mb-4">Branch<span

                        class="text-red-500">*</span></label>

                <select name="branch" id="branchDropdown"

                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

                    <option value="">Select Branch</option>

                </select>

                @error('branch')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="rate" class="md:text-lg font-medium block mb-4">

                    Login on Holidays<span class="text-red-500">*</span>

                </label>



                <label>

                    <input type="radio" name="disable_recharge" value="yes"

                        {{ old('disable_recharge') == 'yes' ? 'checked' : '' }}>

                    Yes

                </label>



                <label>

                    <input type="radio" name="disable_recharge" value="no"

                        {{ old('disable_recharge', 'no') == 'no' ? 'checked' : '' }}>

                    No

                </label>



                @error('disable_recharge')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="searchable_account" class="md:text-lg font-medium block mb-4">

                    Searchable Accounts<span class="text-red-500">*</span>

                </label>



                <label>

                    <input type="radio" name="searchable_account" value="yes"

                        {{ old('searchable_account', 'no') == 'yes' ? 'checked' : '' }}>

                    Yes - All

                </label>



                <label>

                    <input type="radio" name="searchable_account" value="no"

                        {{ old('searchable_account', 'no') == 'no' ? 'checked' : '' }}>

                    No - Only Assigned

                </label>



                @error('searchable_account')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>

            <div class="col-span-2 md:col-span-1">

                <label for="user_active" class="md:text-lg font-medium block mb-4">

                    User Active<span class="text-red-500">*</span>

                </label>



                <label>

                    <input type="radio" name="user_active" value="yes"

                        {{ old('user_active', 'no') == 'yes' ? 'checked' : '' }}>

                    Yes

                </label>



                <label>

                    <input type="radio" name="disable_neft" value="no"

                        {{ old('user_active', 'no') == 'no' ? 'checked' : '' }}>

                    No

                </label>

                @error('disable_neft')

                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>

                @enderror

            </div>

            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">

                <button class="btn-primary" type="submit">

                    Save Branch

                </button>

                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">

                    Reset

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

    setTimeout(function() {

        var successAlert = document.getElementById('success-alert');

        var errorAlert = document.getElementById('error-alert');

        if (successAlert) successAlert.style.display = 'none';

        if (errorAlert) errorAlert.style.display = 'none';

    }, 5000);

</script>



<!-- <script>

    $(document).ready(function() {

        $.ajax({

            url: '/api/states',

            type: 'GET',

            dataType: 'json',

            success: function(states) {

                let select = $('#stateDropdown');

                select.empty();

                select.append('<option value="">Select State</option>');

                let oldState = $('#oldState').val();

                $.each(states, function(index, state) {

                    let selected = (state.id == oldState) ? 'selected' : '';

                    select.append('<option value="' + state.id + '" ' + selected + '>' +

                        state

                        .name + '</option>');

                });

            },

            error: function(xhr, status, error) {

                console.error('Error fetching states:', error);

            }

        });

    });

</script>

<script>

    $(document).ready(function() {

        $.ajax({

            url: '/api/states',

            type: 'GET',

            dataType: 'json',

            success: function(states) {

                let select = $('#incorporation_state');

                select.empty();

                select.append('<option value="">Select State</option>');



                $.each(states, function(index, state) {

                    select.append('<option value="' + state.id + '">' + state.name +

                        '</option>');

                });

            },

            error: function(xhr, status, error) {

                console.error('Error fetching states:', error);

            }

        });

    });

</script> -->