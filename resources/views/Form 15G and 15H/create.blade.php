@extends('layout.main')

@section('content')
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
    </style>
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="h2">Form 15G/15H</h3>
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

            <form action="{{ route('Form 15G and 15H.create') }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                <div class="flex items-start gap-4 mb-4">
                    <label for="member" class="w-48 text-sm font-medium">
                        Member <span class="text-red-500">*</span>
                    </label>
                    <div class="w-full">
                        <select name="member" id="member"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
            rounded-3xl px-3 md:px-6 py-2 md:py-3">
                            <option value="">-- Select a Member --</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ old('member') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('member')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>


                <div class="flex items-start gap-4 mb-4">
                    <label for="financial_year" class="w-48 text-sm font-medium">Financial Year <span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="date" name="financial_year" id="date" placeholder="e.g. 2024-2025"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                rounded-3xl px-3 md:px-6 py-2 md:py-3"
                            value="{{ old('financial_year') }}">
                        @error('financial_year')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-start gap-4 mb-4">
                    <label for="form_15_upload" class="w-48 text-sm font-medium">Upload Form 15G/15H <span
                            class="text-red-500">*</span></label>
                    <div class="w-full">
                        <input type="file" name="form_15_upload" id="form_15_upload"
                            class="block w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 
                rounded-3xl px-3 md:px-6 py-2 md:py-3 file:mr-4 file:py-2 file:px-4 file:rounded-full 
                file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary 
                hover:file:bg-primary/20">
                        @error('form_15_upload')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="col-span-2 flex gap-4 md:gap-6 mt-2">
                    <button class="btn-primary" type="submit">
                        UPLOAD FORM 15G/ 15H
                    </button>
                  <a href="{{ route('Form 15G and 15H.index') }}" class="btn-outline">
                       Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
        {{-- {{-- <div class="box mb-4 xxxl:mb-6">
            <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if ($method === 'PUT')
                    @method('PUT')
                @endif

                @foreach ($formFields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'];
                        $id = $field['id'] ?? $field['name'];
                        $required = $field['required'] ?? false;
                        $value = old($name, $branch[$name] ?? ($field['default'] ?? ''));
                    @endphp

                    <div class="col-span-2 md:col-span-1">
                        <label for="{{ $id }}" class="md:text-lg font-medium block mb-4">
                            {{ $label }} @if ($required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        @if ($type === 'select')
                            <select name="{{ $name }}" id="{{ $id }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                {{ $required ? 'required' : '' }}>
                                <option value="">-- Select {{ $label }} --</option>

                                @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                    @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif ($type === 'radio')
                            <div class="flex gap-4">
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                            {{ $value == $optionValue ? 'checked' : '' }}>
                                        <span>{{ $optionLabel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                value="{{ $type !== 'file' ? $value : '' }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter {{ strtolower($label) }}" {{ $required ? 'required' : '' }}
                                {{ $type === 'file' ? '' : '' }}>
                        @endif

                        @error($name)
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Form 15G/15H
                    </button>
                    <button class="btn-outline" type="reset">
                        Reset
                    </button>
                    <button class="btn-outline" type="button"
                        onclick="window.location.href='{{ route('manage.promotor') }}'">
                        Back
                    </button>
                </div>
            </form>
        </div>  --}}

    @endsection
