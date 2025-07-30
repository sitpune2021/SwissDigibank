@extends('layout.main')

@push('style')
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
@endpush
@section('page-title',
    isset($member)
    ? (!empty($show)
    ? 'View ' .
    $member->first_name .
    '
    Members'
    : 'Edit ' . $member->first_name . ' Members')
    : 'Add Members')

@section('content')
    @include('fields.errormessage')
    <div class="box mb-4 xxxl:mb-6">
        <form action="{{ isset($route) && isset($method) ? $route : '' }}" method="POST"
            class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif
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
                        $value = old($name, $member[$name] ?? ($field['default'] ?? ''));
                    @endphp
                    <div class="col-span-4 md:col-span-1">
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
            @endforeach

            <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                @if (isset($method))
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Member
                    </button>
                @endif
                <a href="{{ route('member.index') }}" class="btn-outline inline-flex items-center justify-center">
                    Back
                </a>
                <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                    Reset
                </button>
            </div>
        </form>

    </div>
@endsection
