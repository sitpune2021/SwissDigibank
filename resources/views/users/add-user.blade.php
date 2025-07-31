@extends('layout.main')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@section('content')
<div class="main-inner">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
        <!-- <h3 class="h2">Add User</h3> -->
        <h3 class="h2"> {!! isset($show) && $show ? $user->fname : (isset($user) ? 'Edit User' : 'New User') !!}</h3>
        <!-- Image + Button -->
         <!-- @if(isset($show) )
        <div class="flex items-center gap-4">
            <div
                style="width: 90px;height: 90px;border: 2px dashed #ccc;border-radius: 12px;background-color: #f9f9f9;display: flex;align-items: center;justify-content: center;cursor: pointer;">

            </div>
            <div x-data="{ open: false }">
                <button type="button" class="px-2 py-1 text-white rounded-pill btn-primary hover:bg-white-700"
                    @click="open = true">
                    Upload Photo
                </button>

                <div x-show="open" x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                    @click.self="open = false">

                    <div class="max-w-md bg-white rounded-lg shadow-lg w-small">
                        <div class="flex items-center justify-between px-4 py-2 border-b">
                            <h5 class="text-lg font-semibold">Upload Image</h5>
                            <button class="text-2xl leading-none text-gray-600 hover:text-gray-800"
                                @click="open = false">
                                &times;
                            </button>
                        </div>

                        <div class="px-4 py-4">
                            <input type="file" accept="image/*" class="w-full p-2 border rounded" />
                        </div>


                        <div class="flex justify-end gap-2 px-4 py-2 border-t">
                            <button class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300"
                                @click="open = false">
                                Cancel
                            </button>
                            <button class="px-4 py-2 text-white rounded btn-primary">
                                Upload
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif -->
    </div>

    @if (session('success'))
    <div id="success-alert" style="background-color: #d4edda; border: 1px solid #28a745; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Success:</strong> {{ session('success') }}
        <span onclick="document.getElementById('success-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #155724;">&times;</span>
    </div>
    @endif

    @if (session('error'))
    <div id="error-alert" style="background-color: #f8d7da; border: 1px solid #dc3545; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; position: relative;">
        <strong>Error:</strong> {{ session('error') }}
        <span onclick="document.getElementById('error-alert').style.display='none';" style="position: absolute; top: 5px; right: 10px; cursor: pointer; color: #721c24;">&times;</span>
    </div>
    @endif

    <div class="box mb-4 xxxl:mb-6">
        <!-- <div class="flex justify-end gap-2 mb-3">

            <button class="flex items-center gap-1 px-2 py-1 text-xs text-white rounded "
                style="background-color: #f39c12">
                <i class="fa-solid fa-id-card-clip"></i> ID Card
            </button>

            <button class="flex items-center justify-center rounded text-dark w-7 h-7 "
                style="background-color:#f4f4f4">
                <i class="text-xs fa-solid fa-pen"></i>
            </button>

            <button class="flex items-center justify-center rounded text-dark w-7 h-7 "
                style="background-color:#f4f4f4">
                <i class="text-xs fa-solid fa-rotate-left"></i>
            </button>

            <button class="flex items-center justify-center rounded text-dark w-7 h-7 "
                style="background-color:#f4f4f4">
                <i class="text-xs fa-solid fa-lock"></i>
            </button>

            <button class="flex items-center justify-center rounded text-dark w-7 h-7 "
                style="background-color:#f4f4f4">
                <i class="text-xs fa-solid fa-arrow-right"></i>
            </button>
        </div> -->
        <form id="companyForm" action="{{  isset($user) ? ($show ?? false ? '#' : route('users.update', base64_encode($user->id))) : route('users.store') }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if(isset($user) && empty($show))
            @method('PUT')
            @endif
            @php $isView = !empty($show); @endphp
            <div class="col-span-2 md:col-span-1">
                <label for="rate" class="md:text-lg font-medium block mb-4">Employee
                    <select name="employee" id="employeeDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" @if($isView) disabled @endif>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}" {{old('employee', isset($user) && $user->emp_id == $emp->id? 'selected' : '' )}}>
                            {{ $emp->name }}
                        </option>
                        @endforeach
                    </select>
                </label>
                @error('employee')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1"></div>

            <div class="col-span-2 md:col-span-1">
                <label for="designation" class="md:text-lg font-medium block mb-4">Designation</label>
                <input type="text" name="designation" id="designation" value="{{ old('designation', $user->designation ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" placeholder="Enter Designation like 'Executive'"
                    @if($isView) disabled @endif>
                @error('designation')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="user_name" class="md:text-lg font-medium block mb-4">Login User Name <span class="text-red-500">*</span></label>
                <input type="text" name="user_name" id="user_name" value="{{ old('user_name', $user->username ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter User Name" @if($isView) disabled @endif>
                @error('user_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="first_name" class="md:text-lg font-medium block mb-4">First Name<span class="text-red-500">*</span></label>
                <input name="first_name" id="first_name" value="{{ old('first_name', $user->fname ?? '') }}"
                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter First Name" @if($isView) disabled @endif>
                @error('first_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="last_name" class="md:text-lg font-medium block mb-4">Last Name</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->lname ?? '') }}" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Last Name" @if($isView) disabled @endif>
                @error('last_name')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="email" class="md:text-lg font-medium block mb-4">Email <span class="text-red-500">*</span></label>
                <input type="text" name="email" value="{{ old('email', $user->email ?? '') }}"
                    id="email" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Email" @if($isView) disabled @endif>
                @error('email')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="mobile_no" class="md:text-lg font-medium block mb-4">Mobile No.<span class="text-red-500">*</span></label>
                <input type="text" name="mobile_no" id="mobile_no" value="{{ old('mobile_no', $user->mobile ?? '') }}"
                    placeholder="Enter Mobile No." class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    @if($isView) disabled @endif>
                @error('mobile_no')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="back_date" class="md:text-lg font-medium block mb-4">Back Date Entry Days <span class="text-red-500">*</span></label>
                <input type="text" name="back_date" id="back_date"
                    placeholder="Enter Days" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    value="{{ old('back_date', $user->back_edate_days ?? '0') }}
                " @if($isView) disabled @endif>
                @error('back_date')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="permission_role" class="md:text-lg font-medium block mb-4">Permissions / Roles <span class="text-red-500">*</span></label>
                <select name="permission_role" id="roleDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" @if($isView) disabled @endif>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{old('permission_role', isset($user) && $user->role_id == $role->id? 'selected' : '' )}}>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('permission_role')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="branch" class="md:text-lg font-medium block mb-4">Branch<span class="text-red-500">*</span></label>
                <select name="branch" id="branchDropdown" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" @if($isView) disabled @endif>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{old('branch', isset($user) && $user->branch_id == $branch->id? 'selected' : '' )}}>{{ $branch->branch_name }}</option>
                    @endforeach
                </select>
                @error('branch')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>


            <div class="col-span-2 md:col-span-1">
                <label for="branch" class="md:text-lg font-medium block mb-4">Login on Holidays<span class="text-red-500">*</span></label>
                <select name="login_on_holidays" id="login_on_holidays" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" @if($isView) disabled @endif>
                    <option value="">Select Login on Holidays</option>
                    <option value="1" {{ old('login_on_holidays', $user->login_on_holidays ?? '') == '1' ? 'selected' : '' }}> YES</option>
                    <option value="0" {{ old('login_on_holidays', $user->login_on_holidays ?? '') == '0' ? 'selected' : '' }}> NO </option>

                </select>
                @error('login_on_holidays')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="user_active" class="md:text-lg font-medium block mb-4">User Active<span class="text-red-500">*</span></label>
                <select name="user_active" id="user_active" class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3" @if($isView) disabled @endif>
                    <option value="">Select User Active</option>
                    <option value="1" {{ old('user_active', $user->user_active ?? '') == '1' ? 'selected' : '' }}> YES</option>
                    <option value="0" {{ old('user_active', $user->user_active ?? '') == '0' ? 'selected' : '' }}> NO </option>
                </select>
                @error('branch')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-2 md:col-span-1">
                <label for="searchable_account" class="md:text-lg font-medium block mb-4">Searchable Accounts<span class="text-red-500">*</span></label>
                <label><input type="radio" name="searchable_account" value="1" {{ old('searchable_account', '0') == '1' ? 'checked' : '' }} @if($isView) disabled @endif> Yes - All</label>
                <label><input type="radio" name="searchable_account" value="0" {{ old('searchable_account', '0') == '0' ? 'checked' : '' }} @if($isView) disabled @endif> No - Only Assigned</label>
                @error('searchable_account')
                <span class="text-red-500 text-xs ml-52 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary" type="submit">Save</button>
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">Reset</button>
            </div> -->
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                {{-- Show Submit button only if not view page --}}
                @if(empty($isView))
                <button class="btn-primary" type="submit">
                    {{ isset($user) ? 'Update User' : 'Save User' }}
                </button>
                @endif

                {{-- Reset button only on Add page --}}
                @if(!isset($user) && empty($isView))
                <button class="btn-outline" type="reset">
                    Reset
                </button>
                @endif

                {{-- Back button on Add, Edit, and View pages --}}
                @if(!empty($isAdd) || isset($user) || !empty($isView))
                <button class="btn-outline" type="button" onclick="window.location.href='{{ route('users.index') }}'">
                    Back
                </button>
                @endif
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