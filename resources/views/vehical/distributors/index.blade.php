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
</style>

@section('content')

 @if(session('success'))
        <div 
            id="successMessage" 
            class="max-w-md mx-auto mt-4 bg-green-100 border border-green-300 text-green-800 text-center px-4 py-3 rounded-lg shadow-md transition-opacity duration-500 ease-in-out"
        >
            {{ session('success') }}
        </div>

        <script>
            // Auto hide after 30 seconds (30000 ms)
            setTimeout(() => {
                const msg = document.getElementById('successMessage');
                if (msg) {
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500); // smooth fade-out
                }
            }, 30000);
        </script>
    @endif
    
    <div class="main-inner">

        <div class="flex flex-wrap items-center justify-between gap-4 mb-6 px-4 lg:mb-8">
            <h3 class=" flex text-xl block uppercase font-semibold">
                Vehicle lone Distributors
            </h3>
            <a href="{{ route('vehical.distributors.create') }}" class=" block flex btn-primary uppercase ">add
                {{-- <i class="las la-plus text-lg"></i> --}}
            </a>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class="pb-4 overflow-x-auto lg:pb-6">
                
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                                <div class="flex items-center gap-1 uppercase">
                                    DISTRIBUTOR CODE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    DISTRIBUTOR NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    DISTRIBUTOR TYPE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    CONTACT NO
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    EMAIL
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    STATE
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    ACTIVE
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
                    @forelse($distributors as $row)
                        <tr class="border-b">
                            <td class="py-3 px-6 uppercase text-primary"><a href="{{ route('distributors.show', $row->id) }}" class="single-option capitalize" style="color:#007bff">{{ $row->distributor_code }}</a></td>
                            <td class="py-3 px-6 uppercase">{{ $row->distributor_name }}</td>
                            <td class="py-3 px-6 uppercase">{{ $row->distributor_type }}</td>
                            <td class="py-3 px-6 lowercase">{{ $row->contact_no }}</td>
                            <td class="py-3 px-6 lowercase">{{ $row->email }}</td>
                            <td class="py-3 px-6">{{ $row->state }}</td>
                            <td class="py-3 px-6">
                                @if($row->active)
                                    <span class="block w-20 rounded-full border border-n30 bg-primary/20 py-1 text-center text-xs text-primary">Yes</span>
                                @else
                                    <span class="block w-20 rounded-full border border-n30 bg-error/20 py-1 text-center text-xs text-error">No</span>
                                @endif
                            </td>
                    
                            <!-- Actions -->
                            <td class="text-start !py-5 px-6">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li><a href="{{ route('distributors.show', $row->id) }}" class="single-option capitalize">View</a></li>                            
                                            <li><a href="{{ route('edit', $row->id) }}" class="single-option capitalize">Edit</a></li>              
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-gray-500">No distributors found.</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

@endsection