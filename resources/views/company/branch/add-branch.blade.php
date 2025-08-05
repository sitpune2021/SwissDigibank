@extends('layout.main')

@section('page-title', isset($branch) ? (!empty($show) ? 'View ' . $branch->branch_name . ' Branch' : 'Edit ' .
    $branch->branch_name . ' Branch') : 'Add Branch')

@section('content')
    @include('fields.errormessage')

    <div class="box mb-4 xxxl:mb-6">
        <form id="companyForm" action="{{ $route }}" method="POST" class="grid grid-cols-2 gap-4 xxxl:gap-6">
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
                    $value = old($name, $branch[$name] ?? ($field['default'] ?? ''));
                    
                    if ($name === 'open_date') {
                        $value = old(
                            $name,
                            $branch?->$name instanceof \Carbon\Carbon
                                ? $branch?->$name->format('D M d Y')
                                : $branch?->$name ?? ($field['default'] ?? ''),
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
                    <button class="btn-primary" type="submit">
                        {{ $method === 'PUT' ? 'Update' : 'Save' }} Branch
                    </button>
                    <button class="btn-outline" type="reset" onclick="document.getElementById('companyForm').reset();">
                        Reset
                    </button>
                @endif
                <button class="btn-outline" type="reset"
                    onclick="window.location.href='{{ route('branch.index') }}'">Back</button>
            </div>
        </form>
    </div>
@endsection

