@extends('layout.main')
@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg   uppercase font-semibold">Management Information System</h3>
        {{-- <a href="" class="btn-primary">Add</a> --}}
    </div>
    @if(session('success'))
    <div class="">
        <div class="w-44 mb-5 flex justify-end">
            <x-alert />
        </div>
        {{-- {{ session('success') }} --}}
    </div>
    @endif
    <div class="col-span-12 box lg:col-span-12">
        
        <div class="flex justify-start gap-4">
            
            
          
            <div class="mb-5  text-end">
                <a href="{{ route('MisOneView') }}" class="btn-primary rounded-10 uppercase py-2 px-2">
                  
                   <i class="las la-print text"></i> MIS 1 (A4) 
                 
                </a>
               
            </div>
              <div class="mb-5  text-end">
                <a href="{{ route('MisTwoView') }}" class="btn-secondary rounded-10 uppercase py-2 px-2">
                    <i class="las la-print text"></i>  MIS 2 (LANDSCAPE) 
                </a>
            </div>
        </div>
      
    </div>


    @endsection     