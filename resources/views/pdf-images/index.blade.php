@extends('layout.main')

@section('content')
<div class="main-inner">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-3 lg:mb-8">
        <h4 class="text-lg uppercase">
            Logo And Letter head Chnage
        </h4>
    </div>

    @if(session('success'))

    {{-- @if(session('success')) --}}
    {{-- //alert msg --}}
    <div class="w-44 mb-5 flex justify-end">
        <x-alert />
    </div>
    @endif
    {{-- @if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
    @endif --}}


    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 p-2 min-h-screen md-4">
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">

            @if(auth()->user()?->isSuperAdmin())
            <form method="POST" action="{{ route('pdf-images.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="">
                    <input type="hidden" name="type" value="logo">
                    <label class="font-semibold">Upload Logo </label>
                    <div class="mt-3">
                        <input type="file" name="image"
                            class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                    </div>
                    @error('image')
                    <div style="color:red; font-size:14px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn-primary uppercase text-sm px-2 py-2  rounded-10">Save Logo</button>
                </div>
            </form>

            <br>

            <form method="POST" action="{{ route('pdf-images.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="letterhead">
                <label class="font-semibold ">Upload Letterhead</label>
                <div class="mt-3">
                    <input type="file" name="image"
                        class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">
                </div>
                @error('image')
                    <div style="color:red; font-size:14px;">{{ $message }}</div>
                    @enderror
                <div class="mt-5">
                    <button type="submit" class="btn-primary uppercase text-sm px-2 py-2  rounded-10">Save
                        Letterhead</button>
                </div>
            </form>
            @endif
        </div>
        <div class="col-span-2 md:col-span-1 bg-white dark:bg-bg3 rounded-2xl p-6">
            <div class="">
                <h4 class="mt-3 uppercase">Logo</h4>
                @if($logo)
                <img src="{{ asset($logo->image_path) }}" width="200">
                @else
                <p class="text-gray-500 mt-5">No logo uploaded yet.</p>

                @endif
            </div>
            <div class="">
                <h4 class="mt-3 uppercase">Letter head</h4>
                @if($letterhead)
                <img src="{{ asset($letterhead->image_path) }}" width="200">
                @else
                <p class="text-gray-500 mt-5">No letterhead uploaded yet.</p>
                @endif
            </div>

        </div>
    </div>




</div>


@endsection