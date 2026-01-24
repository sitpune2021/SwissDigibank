@extends('layout.main')

<style>
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

    .breadcrumb li.active {
        color: #555;
    }

    .custom-thead {
        background-color: #e6f4ea;
        color: #14532d;
    }

    .custom-thead th {
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }

    @media (prefers-color-scheme: dark) {
        .custom-thead {
            background-color: #14532d;
            color: #d1fae5;
        }
    }

    .bg-greens {
        background-color: #14532d;
    }

    .backdrop {
        backdrop-filter: blur(1px);
        -webkit-backdrop-filter: blur(1px);
        background-color: rgba(0, 0, 0, 0.1);


    }
</style>

@section('content')
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl  uppercase font-semibold">
              Notice Board 

            </h3>
            <a href="{{ route('notice-boards.create') }}" class="btn-primary">Add</a>
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
            
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                                <div class="flex items-center gap-1 uppercase">
                                   TITLE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    IMAGE/ FILE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                   START DATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                  END DATE
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                   APP TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    CREATED BY
                                </div>
                            </th>


                          
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    ACTIONS
                                </div>
                            </th>
                        </tr>
                    </thead>
                 <tbody>
    @forelse ($notices as $notice)
        <tr class="border-b hover:bg-secondary/5">

            {{-- TITLE --}}
            <td class="px-6 py-4">
                {{ $notice->notice_title }}
            </td>

            {{-- IMAGE / FILE --}}
            <td class="px-6 py-4">
            
            </td>

            {{-- START DATE --}}
            <td class="px-6 py-4">
               {{ \Carbon\Carbon::parse( $notice->start_date)->format('d-m-Y') }}

            </td>

            {{-- END DATE --}}
            <td class="px-6 py-4">
              {{ \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') }}

            </td>

            {{-- APP TYPE --}}
            <td class="px-6 py-4 uppercase">
                {{ $notice->app_type }}
            </td>

            {{-- CREATED BY  --}}
            <td class="px-6 py-4">
               {{ $notice->user?->fname ?? 'N/A' }}  {{ $notice->user?->lname ?? 'N/A' }}
            </td>

            {{-- ACTIONS --}}
             <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="{{ route('notice-boards.edit', base64_encode($notice->id)) }}
" class="single-option uppercase">edit</a>
                                            </li>
                                             <li>
                                                <a href="{{ route('notice-boards.show', base64_encode($notice->id)) }}" class="single-option uppercase">view</a>
                                            </li>

                                        </ul>
                                        {{-- @include('partials._vertical-options', [
                                        /* 'id' =>base64_encode($director->id),
                                        'viewRoute' => 'director.show',
                                        'editRoute' => 'director.edit'*/
                                        ]) --}}
                                    </div>
                                </div>
                            </td>

        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center py-6 text-gray-500">
                No notices found
            </td>
        </tr>
    @endforelse
</tbody>


                </table>

            </div>
          

        </div>
    </div>


@endsection