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
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 lg:mb-8">
            <h3 class="h2">Add Promoters</h3>
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
            <form id="companyForm" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
                @csrf
                @php
                    $sections = config('promoter_form');
                @endphp

                @foreach ($sections as $sectionName => $fields)
                    {{-- Section Heading --}}
                    @if ($sectionName)
                        <div class="col-span-2">
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
                                    class="w-full text-sm  bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-3xl px-3 md:px-6 py-2 md:py-3"
                                    {{ $required ? 'required' : '' }}>
                                    <option value="">-- Select {{ $label }} --</option>

                                    @if (!empty($field['dynamic']) && !empty($field['options_key']) && isset($dynamicOptions[$field['options_key']]))
                                        @foreach ($dynamicOptions[$field['options_key']] as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}"
                                                {{ $value == $optionValue ? 'selected' : '' }}>
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

                <div class="col-span-2 flex gap-4 justify-center mt-6">
                    <button class="btn-primary" type="submit">Save Promotor</button>
                    <button class="btn-outline" type="reset"
                        onclick="window.location.href='{{ route('manage.promotor') }}'">Back</button>
                    <button class="btn-outline" type="reset"
                        onclick="document.getElementById('companyForm').reset();">Reset</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const oldBranchId = $('#oldState').val();
        $.ajax({
            url: "{{ url('/get-branches') }}",
            type: "GET",
            success: function(response) {
                $('#branchDropdown').append('<option value="">Select Branch</option>');
                $.each(response, function(key, branch) {
                    let selected = (branch.id == oldBranchId) ? 'selected' : '';
                    $('#branchDropdown').append(
                        `<option value="${branch.id}" ${selected}>${branch.branch_name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to fetch branches.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const oldMariatal = $('#oldMariatalStatus').val();
        $.ajax({
            url: "{{ url('/get-marital-statuses') }}",
            type: 'GET',
            success: function(response) {
                $('#mariatal_status').append('<option value="">Select Marital Status</option>');
                $.each(response, function(index, status) {
                    let selected = (status.id == oldMariatal) ? 'selected' : '';
                    $('#mariatal_status').append(
                        `<option value="${status.id}" ${selected}>${status.status}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        const oldReligion = $('#oldReligion').val();
        $.ajax({
            url: "{{ url('/get-religion-statuses') }}",
            type: 'GET',
            success: function(response) {
                $('#member_religion').append('<option value="">Select Member Religion</option>');
                $.each(response, function(index, religion) {
                    let selected = (religion.id == oldReligion) ? 'selected' : '';
                    $('#member_religion').append(
                        `<option value="${religion.id}" ${selected}>${religion.name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to load marital statuses.');
            }
        });
    });
</script>
