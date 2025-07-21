@extends('layout.main')

@section('content')

<div class="main-inner">
    <div class="mb-6 lg:mb-8">
        <h3 class="h2">{!! (isset($show) && $show)
            ? $shareholding->promoters->first_name . ' <small class="text-sm text-gray-500">Share Holding</small>'
            : (isset($shareholding) ? 'Edit Allocated Shares' : 'Allocate New Shares to Promoter') !!}
        </h3>
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
       
        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
                class="grid grid-cols-2 gap-4 xxxl:gap-6">
            {{-- <form action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4" id="dynamicForm"> --}}
                @csrf

                @foreach ($formFields as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $label = $field['label'] ?? ucfirst($name);
                        $id = $field['id'] ?? $name;
                        $required = $field['required'] ?? false;
                        $value = old($name, $data[$name] ?? '');
                        $hasHtml = isset($field['html']);
                        $options = $field['option'] ?? [];

                        // Handle dynamic options from controller
                        if (
                            !empty($field['dynamic']) &&
                            !empty($field['objectKey']) &&
                            isset($dynamicOptions[$field['objectKey']])
                        ) {
                            $options = $dynamicOptions[$field['objectKey']];
                        }
                    @endphp

                    <div class="col-span-2 md:col-span-1 relative">
                        <label for="{{ $id }}" class="block mb-2 font-medium">
                            {{ $label }} @if ($required)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>

                        {{-- SELECT FIELD --}}
                        @if ($type === 'select')
                            <select name="{{ $name }}" id="{{ $id }}"
                                class="w-full bg-white border border-gray-300 rounded px-3 py-2"
                                {{ $required ? 'required' : '' }}>
                                <option value="">-- Select {{ $label }} --</option>
                                @foreach ($options as $optionValue => $optionLabel)
                                    <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                                        {{ $optionLabel }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- RADIO FIELD --}}
                        @elseif ($type === 'radio')
                            <div class="flex gap-4 mt-1">
                                @foreach ($options as $optionValue => $optionLabel)
                                    <label class="flex items-center space-x-2">
                                        <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                            {{ $value == $optionValue ? 'checked' : '' }}
                                            {{ $required ? 'required' : '' }}>
                                        <span>{{ $optionLabel }}</span>
                                    </label>
                                @endforeach
                            </div>

                            {{-- TEXT FIELD --}}
                        @else
                            <div class="relative">
                                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                                    value="{{ $value }}"
                                    class="w-full bg-white border border-gray-300 rounded px-3 py-2 pr-10"
                                    placeholder="Enter {{ strtolower($label) }}" {{ $required ? 'required' : '' }} />
                                {!! $hasHtml ? $field['html'] : '' !!}
                            </div>
                        @endif

                        {{-- Validation Error --}}
                        @error($name)
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach

                <div class="col-span-2 flex gap-4 mt-6">
                    <button type="submit" class="btn-primary">Save</button>
                    <button type="reset" class="btn-outline">Reset</button>
                </div>
            </form>

        </div>
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

<script>
    $(document).ready(function() {
        const selectedId = $('#selectedId').val(); // Corrected
        $.ajax({
            url: "{{ url('/get-promoters') }}",
            type: "GET",
            success: function(response) {
                let dropdown = $('#promoterDropdown');
                dropdown.empty();
                dropdown.append('<option value="">Select Promoter</option>');
                $.each(response, function(index, member) {
                    let selected = (selectedId == member.id) ? 'selected' : '';
                    dropdown.append(
                        `<option value="${member.id}" ${selected}>${member.member_no} - ${member.first_name}</option>`
                    );
                });
            },
            error: function() {
                alert('Failed to fetch promoters.');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const firstShareInput = document.getElementById('first_share');
        const lastShareInput = document.getElementById('share_no');
        const totalShareHeldInput = document.getElementById('total_share_held');
        const totalValueInput = document.getElementById('total_share_value');
        const shareNominalInput = document.getElementById('share_nominal'); // ✅ Nominal value field
        const amountInput = document.getElementById('amount');

        function calculateSharesAndValue() {
            const first = parseInt(firstShareInput.value) || 0;
            const last = parseInt(lastShareInput.value) || 0;
            const nominal = parseFloat(shareNominalInput.value) || 0;

            if (last >= first) {
                const totalShares = last - first + 1;
                const totalValue = totalShares * nominal;
                amountInput.value = totalValue.toFixed(2);

                totalShareHeldInput.value = totalShares;
                totalValueInput.value = totalValue.toFixed(2);

                console.log(totalValue);

            } else {
                totalShareHeldInput.value = 0;
                totalValueInput.value = '';
                amountInput.value = '';
            }
        }

        firstShareInput.addEventListener('input', calculateSharesAndValue);
        lastShareInput.addEventListener('input', calculateSharesAndValue);
    });
</script>