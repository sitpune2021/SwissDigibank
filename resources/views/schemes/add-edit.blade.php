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
        <h3 class="h2">
            {!! (isset($show) && $show)
            ? 'Saving / Current Scheme - '.$schemes->scheme_name
            : (isset($schemes) ? 'Edit Saving / Current Scheme - '.$schemes->scheme_name : 'New Saving / Current Scheme
            ') !!}
        </h3>
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
        <form id="Schemes_Form" action="{{$route}}" method="POST"
            class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if(isset($schemes) && empty($show))
            @method('PUT')
            @endif

            @php
            $transferChargeSections = ['IMPS Charges', 'NEFT Charges', 'UPI Charges'];
            $limits = [1000, 2500, 5000, 10000,17500,25000,37500,50000,75000, 100000,150000,200000,300000,400000,500000,1000000];
            $transferCharges = [];
            @endphp

            @foreach ($sections as $sectionName => $fields)
            @if (in_array($sectionName, $transferChargeSections))
            @php
            $transferCharges[$sectionName] = $fields;
            @endphp
            @continue
            @endif

            {{-- Regular Section Heading --}}
            @if ($sectionName)
            <div class="col-span-2">
                <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
                    {{ str_replace('_', ' ', $sectionName) }}
                </h3>
            </div>
            @endif
            @if ($sectionName === 'IMPS/ NEFT TRANSFER LIMIT (DAILY / WEEKLY / MONTHLY)')
            <div class="col-span-2 w-full">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full">
                    @foreach ($fields as $field)
                    @php
                    $name = $field['name'];
                    $type = $field['type'] ?? 'text';
                    $label = $field['label'];
                    $id = $field['id'] ?? $field['name'];
                    $required = $field['required'] ?? false;
                    $value = old($name, $schemes[$name] ?? ($field['default'] ?? ''));

                    $step = $field['step'] ?? '';
                    $min = $field['min'] ?? '';
                    @endphp

                    <div>
                        @if ($label)
                        <label for="{{ $id }}" class="block text-sm font-medium mb-1">
                            {{ $label }}
                        </label>
                        @endif

                        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                            value="{{ $value }}"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-4 py-2"
                            placeholder="{{ ucfirst(str_replace('_', ' ', $name)) }}"
                            {{ isset($show) ? 'readonly' : '' }} />

                        @error($name)
                        <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            {{-- Your original input rendering logic --}}

            @foreach ($fields as $field)
            @php
            $name = $field['name'];
            $type = $field['type'] ?? 'text';
            $label = $field['label'];
            $id = $field['id'] ?? $field['name'];
            $required = $field['required'] ?? false;
            $value = old($name, $schemes[$name] ?? ($field['default'] ?? ''));
            $step = $field['step'] ?? '';
            $min = $field['min'] ?? '';
            @endphp
            <div class="col-span-2 md:col-span-1">
                @include('fields.label', [
                            'id' => $id,
                            'label' => $label,
                            'required' => $required,
                        ])
                        @include('fields.inputs', [
                            'id' => $id,
                            'label' => $label,
                            'required' => $required,
                            'type' => $type,
                            'name' => $name,
                            'value' => $value,
                            'readonly' => empty($show) ? '' : 'readonly',
                            'field' => $field,
                        ])

                        @error($name)
                            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                        @enderror
            </div>
            @endforeach
            @endif
            @endforeach

    </div>

    <div class="overflow-x-auto w-full box mb-4 xxxl:mb-6">
        <h3 class="text-xl font-semibold text-center text-gray-800 mb-4 capitalize">
            IMPS / NEFT / UPI CHARGES
        </h3>
        <table class="table-auto w-full border border-gray-300 mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Limit</th>
                    @foreach($transferChargeSections as $mode)
                    <th class="border px-4 py-2 text-center">{{ strtoupper($mode) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($limits as $limit)
                <tr>
                    <td class="border px-4 py-2 font-semibold">Up to ₹{{ number_format($limit) }}</td>
                    @foreach($transferChargeSections as $mode)
                    <td class="border px-4 py-2">
                        @php
                        // Find the matching scheme charge record for this limit
                        $field = $mode . '_charge';
                        $charge = $schemeCharges->firstWhere('limit', $limit);

                        if($mode == 'IMPS Charges')
                        $inputValue = $charge && isset($charge->imps_charge) ? $charge->imps_charge : '0';

                        if($mode == 'NEFT Charges')
                        $inputValue = $charge && isset($charge->neft_charge) ? $charge->neft_charge : '0';

                        if($mode == 'UPI Charges')
                        $inputValue = $charge && isset($charge->upi_charge) ? $charge->upi_charge : '0';

                        @endphp
                        @php
                        $inputName = str_replace(' ', '_', $mode) . "_$limit";
                        @endphp
                        <input
                            type="text"
                            name="{{ $inputName }}"
                            id="{{ $inputName }}"
                            class="border rounded px-2 py-1 w-full"
                            placeholder="{{ strtoupper($mode) }} ≤ ₹{{ $limit }}"
                            @if(empty($schemes))
                            value=""
                            @else
                            value="{{ old($inputName, $inputValue) }}"
                            @endif
                            @if(isset($show) && $show) disabled @endif>
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-span-1 md:col-span-3">
        <div class="flex flex-wrap gap-4 rounded-10 px-3 md:px-4 py-2">
            <label class="block text-sm font-medium mb-1">App Type <span class="text-red-500">*</span></label>
            {{-- Admin --}}
            <label class="flex items-center gap-2">
                <input type="hidden" name="app_type" value="0">
                <input type="checkbox" name="app_type" value="1" class="form-checkbox"
                    {{ old('app_type', isset($schemes) ? $schemes->app_type : 1) == 1 ? 'checked' : '' }}
                    @if(isset($show) && $show) disabled @endif>
                <span>Admin</span>
            </label>
            @error('app_type')
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror
            {{-- Associate --}}
            <label class="flex items-center gap-2">
                <input type="hidden" name="app_type_associate" value="0">
                <input type="checkbox" name="app_type_associate" value="1" class="form-checkbox"
                    {{ old('app_type_associate', isset($schemes) ? $schemes->app_type_associate :1) == 1 ? 'checked' : '' }}
                    @if(isset($show) && $show) disabled @endif>
                <span>Associate</span>
            </label>
            @error('app_type_associate')
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror
            {{-- Member --}}
            <label class="flex items-center gap-2">
                <input type="hidden" name="app_type_member" value="0">
                <input type="checkbox" name="app_type_member" value="1" class="form-checkbox"
                    {{ old('app_type_member', isset($schemes) ? $schemes->app_type_member : 0) == 1 ? 'checked' : '' }}
                    @if(isset($show) && $show) disabled @endif>
                <span>Member</span>
            </label>
            @error('app_type_member')
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror
        </div>


    </div>
    <div class="col-span-1 md:col-span-3">
        <div class="flex flex-wrap gap-4 rounded-10 px-3 md:px-4 py-2">
            <label class="block text-sm font-medium mb-2">
                Scheme Active <span class="text-red-500">*</span>
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-2">
                    <input type="radio" name="active" value="1"
                        {{ old('active', $schemes['active'] ?? 0) == 1 ? 'checked' : '' }}
                        @if(isset($show) && $show) disabled @endif>
                    Yes
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="active" value="0"
                        {{ old('active', $schemes['active'] ?? 0) == 0 ? 'checked' : '' }}
                        @if(isset($show) && $show) disabled @endif>
                    No
                </label>
            </div>
            @error('scheme_active')
            <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
        @if (isset($method) && empty($show))
        <button class="btn-primary" type="submit">
            {{ $method === 'PUT' ? 'Update' : 'Save' }} Scheme
        </button>
        @endif
        @if(!isset($schemes) && empty($show))
        <button class="btn-outline" type="reset" onclick="document.getElementById('Schemes_Form').reset();">
            Reset
        </button>
        @endif
        @if(!empty($isAdd) || isset($schemes) || !empty($show))
        <a href="{{ route('schemes.index') }}" class="btn-outline inline-flex items-center justify-center">
            Back
        </a>
        @endif
    </div>
    </form>
</div>
<!-- </div> -->
@endsection