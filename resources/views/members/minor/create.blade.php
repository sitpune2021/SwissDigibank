@extends('layout.main')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        button[type="reset"]:active {
            transform: scale(0.95);
            opacity: 0.7;
            transition: 0.1s;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        input[type="radio"] {

            width: 24px;

            height: 24px;

            accent-color: green;

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
            <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if (isset($method) && $method == 'PUT')
                    @method('PUT')
                @endif
                @php
                    $promoterId = request()->query('promotor_id') ?? ($minor->promotor_id ?? null);
                    $memberId = request()->query('member_id') ?? ($minor->member_id ?? null);
                    $type = request()->query('type');

                    if (!$type) {
                        $type = $memberId ? 'member' : ($promoterId ? 'promotor' : null);
                    }
                @endphp

                <input type="hidden" name="type" value="{{ $type }}">
                @if ($type === 'member')
                    <input type="hidden" name="member_id" value="{{ $memberId }}">
                @elseif ($type === 'promotor')
                    <input type="hidden" name="promotor_id" value="{{ $promoterId }}">
                @endif

                @foreach ($sections as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'];
                        $id = $field['id'] ?? $field['name'];
                        $required = $field['required'] ?? false;
                        $value = old($name, $minor[$name] ?? ($field['default'] ?? ''));
                    @endphp
                    <div class="col-span-4 md:col-span-1">
                        <label for="{{ $id }}" class="md:text-lg font-medium block mb-4">
                            {{ $label }} @if ($required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        @if ($type === 'select')
                            <select name="{{ $name }}" id="{{ $id }}"
                                class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10  px-3 md:px-6 py-2 md:py-3"
                                {{ isset($show) ? 'readonly' : '' }}>
                                <option value="">-- Select {{ $label }} --</option>

                                @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                    @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}
                                            {{ !empty($show) ? 'readonly' : '' }}>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                @elseif(!empty($field['options']))
                                    @foreach ($field['options'] as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}
                                            {{ !empty($show) ? 'readonly' : '' }}>
                                            {{ $optionLabel }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        @elseif ($type === 'radio')
                            <div class="flex gap-2">
                                @foreach ($field['options'] as $optionValue => $optionLabel)
                                    <label class="flex items-center space-x-4 class=ml-2 gap-1">
                                        <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                            {{ $value == $optionValue ? 'checked' : '' }}
                                            {{ isset($show) ? 'disabled' : '' }}>
                                        <span>{{ $optionLabel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @elseif ($type === 'checkbox')
                            <label class="switch">
                                <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="1"
                                    {{ $value ? 'checked' : '' }} {{ isset($readonly) ? 'disabled' : '' }}>
                                <div class="slider round">
                                    <span class="switch-on">ON</span>
                                    <span class="switch-off">OFF</span>
                                </div>
                            </label>
                        @else
                            <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                value="{{ $value }}"
                                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                placeholder="Enter {{ strtolower($label) }}" {{ !empty($show) ? 'readonly' : '' }} />
                        @endif

                        @error($name)
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
                {{-- member  --}}
                {{-- 18-09-22 changes  --}}
                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    @if (empty($show))
                        <button class="btn-primary" type="submit">
                            {{ ($method ?? '') === 'PUT' ? 'UPDATE' : 'SAVE' }} MINOR
                        </button>
                        @if (($method ?? '') === 'POST')
                            <button class="btn-outline" type="reset"
                                onclick="document.getElementById('companyForm').reset();">
                                RESET
                            </button>
                        @endif
                    @endif
                    <button class="btn-outline" type="button" onclick="window.location.href='{{ route('minor.index') }}'">
                        BACK
                    </button>
                </div>

            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const titleRadios = document.querySelectorAll('input[name="title"]');
            const genderRadios = document.querySelectorAll('input[name="gender"]');

            titleRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const title = this.value.toLowerCase(); // ensure lowercase
                    let genderToSelect = '';

                    if (title === 'md' || title === 'mr') {
                        genderToSelect = 'male';
                    } else if (title === 'ms' || title === 'mrs') {
                        genderToSelect = 'female';
                    }

                    genderRadios.forEach(genderRadio => {
                        genderRadio.checked = (genderRadio.value === genderToSelect);
                    });
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const aadhaarInput = document.getElementById('aadhaar_no');
            if (!aadhaarInput) return;

            aadhaarInput.addEventListener('input', function() {
                // Only digits, max 12 characters
                this.value = this.value.replace(/\D/g, '').slice(0, 12);
            });

            aadhaarInput.addEventListener('blur', function() {
                if (this.value && this.value.length !== 12) {
                    alert('Aadhaar number must be exactly 12 digits.');
                    this.focus();
                }
            });
        });
    </script>

@endsection
