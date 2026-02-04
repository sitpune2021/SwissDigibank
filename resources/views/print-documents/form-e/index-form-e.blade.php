@extends('layout.main')
@section('content')
<div class="main-inner">

    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
        <h3 class=" flex text-lg   uppercase font-semibold">Form E</h3>
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
        
        <div class="flex justify-end gap-4">
            
            
            <div class="mb-5  text-end">
                <a href="{{ route('letterhead-e') }}" class="btn-warning rounded-10 uppercase py-2 px-2">
                    <i class="las la-print text"></i>   Letter Head
                </a>
            </div>
            <div class="mb-5  text-end">
                <a href="{{ route('eOneView') }}" class="btn-primary rounded-10 uppercase py-2 px-2">
                  
                   <i class="las la-print text"></i>  print Form E1   
                 
                </a>
               
            </div>
              <div class="mb-5  text-end">
                <a href="{{ route('eTwoView') }}" class="btn-secondary rounded-10 uppercase py-2 px-2">
                    <i class="las la-print text"></i>  print Form E2
                </a>
            </div>
        </div>
        <div class="pb-4 overflow-x-auto lg:pb-6">

            <table class="w-full  select-all-table" id="">

                <thead>
                    <tr class="bg-secondary/5 dark:bg-bg3">
                        <th class="text-start !py-5 px-3 min-w-[100px] cursor-pointer">
                            <div class="flex text-center uppercase justify-start gap-1">
                                SR.NO.
                            </div>
                        </th>
                        <th class="text-start !py-5 px-3 min-w-[100px] cursor-pointer">
                            <div class="flex text-center uppercase justify-start gap-1">
                                CUSTOMER NO
                            </div>
                        </th>
                        <th class="text-start !py-5 px-4 min-w-[100px] cursor-pointer">
                            <div class="flex text-start   uppercase justify-start gap-1">
                                CUSTOMER NAME
                            </div>
                        </th>
                        <th class="text-start !py-5 px-4 min-w-[100px] cursor-pointer">
                            <div class="flex text-start   uppercase justify-start gap-1">
                                Address
                            </div>
                        </th>


                    </tr>
                </thead>

                <tbody>
                    @foreach($members as $index => $member)
                    <tr class="border-b ">

                        <td class=" py-3 text-lg px-5 text-start">{{ $index + 1 }}</td>
                        <td class="text-primary py-3 text-lg px-5 text-start">
                            <a href="{{ $member?->id ? route('member.show', $member->id) : '#' }}">{{$member->member_no
                                }}
                            </a>
                        </td>
                        <td class=" py-3 text-lg px-5 text-start">
                            {{ $member->member_info_first_name }}
                            {{ $member->member_info_last_name }}
                        </td>
                        <td class=" py-3 text-lg px-5 text-start">
                            {{ $member->address->member_address_line_1 ?? '' }},<br>
                            {{ $member->address->member_address_line_2 ?? '' }}

                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>

             {{-- <div class="mt-4">  
                    <x-pagination :paginator="$members" />
             </div> --}}

        </div>
    </div>


    @endsection