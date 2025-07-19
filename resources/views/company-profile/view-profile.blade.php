@php
    $companyprofile = config('companyprofile_form');
@endphp
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
</style>
@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <div class="flex items-center gap-2">
                <h1 class="text-xl font-semibold">SWISS PAYMENTS-DIGITAL BANKING</h1>
                <a href="{{ route('company.edit') }}"
                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white hover:bg-green-700">
                    <i class="las la-edit text-lg"></i>
                </a>
                <hr class="my-2 border-gray-300" />
            </div>
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
        <form>

            <div class="grid grid-cols-12 gap-4 xxxxxl:gap-6">

                @foreach ($companyprofile as $section)
                    <div class="col-span-6 ">
                        <div class="box xxl:p-8 xxxl:p-10 mb-6">
                            <h4 class="h4 bb-dashed mb-4 pb-4 md:mb-6 md:pb-6">{{ $section['heading'] }}</h4>
                            <form class="mt-6 xl:mt-8 grid grid-cols-2 gap-4 xxxxxl:gap-6">
                                @foreach ($section['fields'] as $field)
                                    <div class="col-span-2 md:col-span-1">
                                        <label for="{{ $field['id'] }}" class="md:text-lg font-medium block mb-4">
                                            {{ $field['label'] }}
                                            @if (!empty($field['required']))
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>

                                        @if ($field['type'] === 'textarea')
                                            <textarea id="{{ $field['id'] }}" name="{{ $field['name'] }}" rows="4"
                                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3 resize-none"
                                                placeholder="Enter {{ strtolower($field['label']) }}" readonly>{{ old($field['name'], $company->{$field['name']} ?? '') }}</textarea>
                                        @elseif ($field['type'] === 'date')
                                            <input type="date" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                                readonly />
                                        @elseif ($field['type'] === 'number')
                                            <input type="number" id="{{ $field['id'] }}" name="{{ $field['name'] }}"
                                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                                placeholder="Enter {{ strtolower($field['label']) }}"
                                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                                readonly />
                                        @else
                                            <input type="{{ $field['type'] }}" id="{{ $field['id'] }}"
                                                name="{{ $field['name'] }}"
                                                class="w-full text-sm bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                                placeholder="Enter {{ strtolower($field['label']) }}"
                                                value="{{ old($field['name'], $company->{$field['name']} ?? '') }}"
                                                readonly />
                                        @endif
                                    </div>
                                @endforeach
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
           
        </form>
    </div>
@endsection