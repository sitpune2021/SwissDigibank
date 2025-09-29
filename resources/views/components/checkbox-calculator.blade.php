<div class="mt-4">
    <label for="{{ $id }}" class="flex items-center space-x-2 cursor-pointer">
        <input
            type="checkbox"
            id="{{ $id }}"
            name="{{ $name }}"
            class="rounded-10  border-gray-300 text-primary text-sm focus:ring-blue-500"
        >
   
        <span class="p-2">{{ $label }}</span>
         </label>
        <div class="">
        @if($sublabel)
            <span class="p-2 text-gray-500 text-sm block">{{ $sublabel }}</span>
        @endif
        </div>
 
</div>
