@extends('layout.main')

@section('content')
    <div class="main-inner">

        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h4>Transfer Shares</h4>
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
            <form id="companyForm" action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @if ($method == 'PUT')
                    @method('PUT')
                @endif
                @foreach ($sections as $sectionName => $fields)
                    {{-- Section Heading --}}
                    @if ($sectionName)
                        <div class="col-span-2">
                            <hr class="border-t border-gray-300 mb-4">
                            <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
                                {{ str_replace('_', ' ', $sectionName) }}
                            </h3>
                        </div>
                    @endif
                    @foreach ($fields as $field)
                        @php
                            $name = $field['name'];
                            $type = $field['type'] ?? 'text';
                            $label = $field['label'];
                            $id = $field['id'] ?? $field['name'];
                            $required = $field['required'] ?? false;
                            $value = old($name, $sharesholdings[$name] ?? ($field['default'] ?? ''));
                            if ( $name === 'transferor' ) 
                            {
                          $value = old($name, $sharesholdings[$name] ?? ($field['dynamic'] ? $Promotor->first_name :  ''));
                        }

                        @endphp
                        <div class="col-span-2 md:col-span-1">
                            <label for="{{ $id }}" class="md:text-lg font-medium block mb-4">
                                {{ $label }} @if ($required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            @if ($name === 'shares' && isset($memberShareCount) && $memberShareCount >= 10)
                                <span class="text-red-500 text-xs block mt-1">
                                    Note: Member already has the required number of shares. No need to transfer more.
                                </span>
                            @endif

                            @if ($type === 'select')
                                <select name="{{ $name }}" id="{{ $id }}"
                                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    {{ $required ? 'required' : '' }}>
                                    <option value="">-- Select {{ $label }} --</option>

                                    @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                        @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'selected' : '' }}>
                                                <!-- {{ $optionValue }}{{ $value }} -->
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    @elseif(!empty($field['options']))
                                        @foreach ($field['options'] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'selected' : '' }}>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if (!empty($field['create']))
                                    <a href="{{ route('member.create') }}"
                                        class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                                        Add New Member
                                    </a>
                                @endif
                            @elseif ($type === 'radio')
                                <div class="flex gap-5">
                                    @foreach ($field['options'] as $optionValue => $optionLabel)
                                        <label class="flex items-center gap-1 cursor-pointer">
                                            <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'checked' : '' }}>
                                            <span>{{ $optionLabel }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif ($type === 'checkbox')
                                <label class="switch">
                                    <input type="checkbox" name="{{ $name }}" id="{{ $id }}"
                                        value="1" {{ $value ? 'checked' : '' }}>
                                    <div class="slider round">
                                        <span class="switch-on">ON</span>
                                        <span class="switch-off">OFF</span>
                                    </div>
                                </label>
                            @else
                                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                    value="{{ $value }}"
                                    class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                                    placeholder="Enter {{ strtolower($label) }}" />
                            @endif

                            @error($name)
                                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endforeach
                @endforeach

                <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Transfer Share
                    </button>
                    <a href="{{ route('shares-holdings.index') }}"
                        class="btn-outline inline-flex items-center justify-center">
                        Back
                    </a>
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>

                </div>

            </form>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sharesInput = document.getElementById('shares');
        const faceValueInput = document.getElementById('face_value');
        const totalInput = document.getElementById('total_consideration');

        function calculateTotal() {
            const shares = parseFloat(sharesInput.value) || 0;
            const faceValue = parseFloat(faceValueInput.value) || 0;
            const total = shares * faceValue;
            totalInput.value = total.toFixed(2);
        }

        sharesInput.addEventListener('input', calculateTotal);
        faceValueInput.addEventListener('input', calculateTotal);
        calculateTotal(); // Calculate on page load
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('transferor').readOnly  = true;
    });
</script>

