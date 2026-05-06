@extends('layout.main')

@section('page-title', isset($director) ? (!empty($show) ? 'View DIRECTOR – ' . $director->director_name : 'Edit
    DIRECTOR – ' . $director->director_name) : 'Add DIRECTORS')


@section('content')

    <head>
        <style>
            input[type="radio"] {

                width: 24px;

                height: 24px;

                accent-color: green;

            }

            button[type="reset"]:active {
                transform: scale(0.95);
                opacity: 0.7;
                transition: 0.1s;
            }
        </style>
    </head>
    @include('fields.errormessage')
    <div class="box mb-4 xxxl:mb-6">
        <form id="companyForm" action="{{ $route }}" method="POST" enctype="multipart/form-data"
            class="grid grid-cols-2 gap-4 xxxl:gap-6">
            @csrf
            @if ($method == 'PUT')
                @method('PUT')
            @endif

            @foreach ($formFields as $field)
                @php
                    $name = $field['name'];
                    $type = $field['type'] ?? 'text';
                    $label = $field['label'];
                    $id = $field['id'] ?? $field['name'];
                    $required = $field['required'] ?? false;
                    $value = old($name, $director[$name] ?? ($field['default'] ?? ''));
                    if ($name === 'appointment_date' || $name === 'resignation_date') {
                        $value = old(
                            $name,
                            $director?->$name instanceof \Carbon\Carbon
                                ? $director?->$name->format('d-m-Y')
                                : $director?->$name ?? ($field['default'] ?? ''),
                        );
                    }
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

            <div class="col-span-2 flex gap-4 md:gap-6 mt-4">
                @if (empty($show))
                    <button class="btn-primary" type="submit" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;">
                        {{ $method === 'PUT' ? 'UPDATE' : 'SAVE' }} DIRECTOR
                    </button>
                    @if ($method === 'POST')
                        <button class="btn-outline" type="reset" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;"
                            onclick="document.getElementById('companyForm').reset();">
                            RESET
                        </button>
                    @endif
                @endif
                <button class="btn-outline" type="reset" style="background: linear-gradient(90deg, #e1d315, #e30f0f) !important; color: black;"
                    onclick="window.location.href='{{ route('director.index') }}'">BACK</button>
            </div>
        </form>
    </div>
@endsection
