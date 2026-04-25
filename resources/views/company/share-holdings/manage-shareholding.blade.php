@extends('layout.main')
@section('page-title', 'PROMOTERS SHARE HOLDING DETAILS')

@section('action-button')
<a class="btn-primary" href="{{ route('shareholding.create') }}">
    ADD
</a>
@endsection

<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

@section('content')

<div class="box col-span-12 lg:col-span-6">

    <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
        
        <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
          
        </form>

        <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
            <form action="{{ route('shareholding.index') }}"
                class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] ">
                <input type="text" name="search" id="transaction-search" placeholder="Search"
                    value="{{ request('search') }}"
                    class="bg-transparent  border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
                <button
                    class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                    <i class="las la-search text-lg"></i>
                </button>
                @if (request('search'))
                <a href="{{ route('shareholding.index') }}"
                    class="w-7 h-7 bg-grey-500 hover:bg-grey-900 text-dark rounded-full flex items-center justify-center transition duration-200"
                    title="Clear Search">
                    <i class="las la-times text-lg"></i>
                </a>
                @endif
            </form>
        </div>

    </div>

    <div class="flex flex-wrap gap-4 justify-between mb-4 pb-4 lg:mb-6 lg:pb-6" style="flex-direction: row-reverse;">
        <x-alert />
    </div>

    <div class="overflow-x-auto pb-4  lg:pb-6">

        <table class="w-full whitespace-nowrap overflow-x-auto  select-all-table " id="transactionTable1">
            
            <thead class="bg-gray-100 dark:bg-bg3 sticky top-0" style="background-color: bisque;">
                <tr class="text-gray-700 dark:text-gray-200 text-sm font-semibold uppercase tracking-wider">

                    <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            PROMOTERS
                        </div>
                    </th>
                    <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            FIRST DISTINCTIVE NO.
                        </div>
                    </th>
                    <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            LAST DISTINCTIVENO.
                        </div>
                    </th>
                    <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            TOTAL SHARESHELD
                        </div>
                    </th>
                   <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            SHARE NOMINALVal.
                        </div>
                    </th>
                    <th class="text-start py-4 px-6 min-w-[160px] cursor-pointer">
                        <div class="flex items-center gap-1">
                            TOTAL VAL.
                        </div>
                    </th>
                    <th class="text-center !py-5" data-sortable="false">ACTION</th>
                </tr>
            </thead>

            <tbody>
                @forelse($share_holdings as $index => $share)
                <tr class="table-row dark:even:bg-bg3 border-b hover:bg-gray-50 dark:hover:bg-bg3"
                    style="animation-delay: {{ $loop->index * 0.05 }}s">
                    
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full">
                                <i class="las la-user text-blue-600"></i>
                            </div>

                            <div>
                                <a href="{{ $share?->promotor?->id ? route('promotor.show', base64_encode($share->promotor->id)) : '#' }}"
                                class="font-semibold text-green-600 hover:text-green-700 transition">

                                    {{ $share->promotor->first_name }} {{ $share->promotor->last_name }}
                                </a>

                                <p class="text-xs text-gray-400">
                                    CUSTOMER NO: 000{{ $share->promotor->id }}
                                </p>
                            </div>

                        </div>
                    </td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->first_share }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->share_no }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->total_share_held ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->nominal_value ?? '-' }}</td>
                    <td class="px-4 py-3 text-center font-medium text-gray-700">{{ $share->total_share_value ?? '-' }}</td>
                    <!-- <td class="px-6 py-4">{{ \Carbon\Carbon::parse($share->allotment_date)->format('d-m-Y') }}</td> -->
                    <td class="px-4 py-3 text-center font-medium text-gray-700">
                        <div class="flex justify-center">
                            @include('partials._vertical-options', [
                            'id' => base64_encode($share->id),
                            'viewRoute' => 'shareholding.show',
                            'editRoute' => 'shareholding.edit',
                            ])
                        </div>
                    </td>
                    
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">No records found.</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-4">
        <x-pagination :paginator="$share_holdings"/>
    </div>

</div>

<div class="flex items-center mt-5 justify-center gap-4 xxl:gap-6">
    <div class="col-span-12 lg:col-span-7 xxl:col-span-8">
        <div class="box xl:p-8">
            <h4 class="h4 bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
                Select Promoter who's Shares need to split for New Membership Registrations
            </h4>
            @php
            $field = [
            'dynamic' => true,
            'options_key' => 'promoter',
            ];
            $name = 'is_transfer'; 
            @endphp
            <form action="{{ route('shareholding.transfer') }}" method="POST" class="flex items-center justify-center gap-4 xl:gap-6">
                @csrf
                @include('fields.inputs', [
                'id' => 'transfer',
                'label' => 'Promoter',
                'required' => true,
                'type' => 'select',
                'name' => $name,
                'value' => isset($transfoer) ? $transfoer->id : '',
                'field' => $field,
                ])

                @error($name)
                <span class="text-red-500 text-xs block mt-1">{{ $message }}</span>
                @enderror
                <button class="btn-primary rounded-10 " type="submit"> UPDATE </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionTable1').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100]
        });
    });
</script>
<script>
    document.getElementById('transaction-search').addEventListener('input', function() {
        if (this.value === '') {
            this.form.submit();
        }
    });
</script>
@endpush