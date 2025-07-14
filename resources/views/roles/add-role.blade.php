@extends('layout.main')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 30px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 30px;
        text-align: center;
        line-height: 30px;
        font-size: 12px;
        font-weight: bold;
        color: white;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4CAF50;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .slider .switch-on,
    .slider .switch-off {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider .switch-on {
        left: 0;
    }

    .slider .switch-off {
        right: 0;
    }

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
</style>
@section('content')
<div class="main-inner">

    <div class="box mb-4 xxxl:mb-6">
        <div class="mb-6 pb-6 bb-dashed flex justify-between items-center">
            <h4 class="h4">Add New Role / Permission</h4>
            <ol class="breadcrumb flex text-sm text-gray-600 mt-1 space-x-1">
                <li><a href="{{ url('/manage-permission') }}" class="text-blue-600 hover:underline">Roles</a></li>
                <li class="text-gray-500">New</li>
            </ol>
            <hr class="my-2 border-gray-300" />
        </div>
        <form class="grid grid-cols-2 gap-4 xxxl:gap-6">
            <div class="col-span-2 md:col-span-1">
                <label for="name" class="mb-4 md:text-lg font-medium block">
                    Role Name
                </label>
                <input type="text"
                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter role" id="name" required />
            </div>
            <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                <button class="btn-primary type=" submit">
                    Create Role
                </button>
                <button class="btn-outline" type="reset">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection