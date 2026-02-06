@extends('layout.main')

@section('content')
<div class="main-inner">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6 lg:mb-8">
        <h2 class="text-lg uppercase font-semibold">
            {{ $passbook->passbook_no }}
            <span class="text-gray-500 text-sm font-normal">Passbook</span>
        </h2>
    </div>

   

    <!-- Passbook Details Card -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6   md-4">
            <div class="col-span-2 md:col-span-1  box dark:bg-bg3 rounded-2xl ">
        <!-- Action Buttons -->
        <div class="flex justify-end gap-2 mb-4">
            <!-- Edit Button -->
            <a href="{{ route('passbook.edit', $passbook->id) }}"
                class="flex items-center gap-2 px-2 py-2 btn-primary text-black  shadow-md transition">
                <i class="las la-edit"></i>
            </a>
            <!-- Delete Button -->
            @if(session('success'))
            <div id="toast-success" class="fixed top-5 right-5 bg-green-500 text-white px-4 py-2  shadow-md z-50">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if (toast) toast.remove();
                }, 3000);
            </script>
            @endif

            <form action="{{ route('passbook.destroy', $passbook->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this passbook?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="flex items-center gap-2 p-2 btn-error  shadow-md transition">
                    <i class="las la-trash-alt"></i>
                </button>
            </form>
        </div>

        <!-- Passbook Information -->
        <div class="divide-y divide-gray-200">
            <table class="w-full text-sm text-gray-700 rounded-md">
                <tbody>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold uppercase  px-3 py-2 w-1/3">Account</td>
                        <td class="px-3 py-2">{{ $passbook->account_no }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold uppercase  px-3 py-2">Passbook No.</td>
                        <td class="px-3 py-2">{{ $passbook->passbook_no }}</td>
                    </tr>
                    <tr class="border-b border-gray-200">
                        <td class="font-semibold uppercase  px-3 py-2">Issue Date</td>
                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($passbook->issue_date)->format('d/m/Y') }}</td>
                    </tr>

                </tbody>
            </table>

        </div>
</div>


    </div>
    @endsection