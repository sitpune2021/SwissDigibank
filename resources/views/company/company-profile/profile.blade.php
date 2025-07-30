@php
    $companyprofile = config('companyprofile_form');
@endphp
@extends('layout.main')

@section('page-title', 'SWISS PAYMENTS-DIGITAL BANKING')

@section('content')

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
    <form action="{{ $route }}" method="POST" class="relative">
        @csrf
        @if (isset($method))
            @method($method)
        @endif

        <div class="grid grid-cols-12 gap-4 xxxxxl:gap-6">
            @foreach ($companyprofile as $key => $section)
                <div class="col-span-6 ">
                    <div class="mb-6 box xxl:p-8 xxxl:p-10" style="height: 100%;">
                        <div class="pb-4 mb-4  bb-dashed md:mb-6 md:pb-6 flex justify-between">
                            <h4 class="h4">{{ $section['heading'] }}</h4>
                            @if ($key == 'company' && Route::currentRouteName() === 'company.index')
                                <a href="{{ route('company.edit', $company->id) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-white rounded-full bg-primary hover:bg-green-700">
                                    <i class="text-lg las la-edit"></i>
                                </a>
                            @endif
                        </div>
                        @php
                            $isForm = !isset($show) || !$show;
                        @endphp
                        @if ($isForm)
                            <section class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                                @include('company.company-profile.partial.sectionLoop', [
                                    'section' => $section,
                                    'model' => $company,
                                    'show' => false,
                                ])
                            </section>
                        @else
                            <form class="grid grid-cols-2 gap-4 mt-6 xl:mt-8 xxxxxl:gap-6">
                                @include('company.company-profile.partial.sectionLoop', [
                                    'section' => $section,
                                    'model' => $company,
                                    'show' => true,
                                ])
                            </form>
                        @endif

                    </div>
                </div>
            @endforeach
            @if (!isset($show) || !$show)
                <div class="absolute bottom-0 right-0 flex col-span-2 gap-4 mt-2 md:gap-6">
                    <button class="btn-primary" type="submit">Update</button>
                    <a href="{{ route('company.index') }}" class="btn-outline">Cancel</a>
                </div>
            @endif
        </div>
    </form>
@endsection
