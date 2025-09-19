<!-- Searchable Dropdown -->
<div x-data="searchableDropdown(@js($items), '{{ $displayField }}', '{{ $valueField }}', '{{ $event }}', @js($selected))"
     class="relative w-72 space-y-2" x-cloak>

    <!-- Button -->
    <button type="button" @click="toggleDropdown"
        class="w-full bg-secondary/5 border rounded-10 px-3 py-2 text-sm flex justify-between items-center capitalize">
        <span x-text="selectedText || 'Select option...'"></span>
        <i class="las la-angle-down"></i>
    </button>

    <!-- Hidden input -->
    <input type="hidden" name="{{ $name }}" id="selected_member_id" x-model="selectedValue">

    <!-- Dropdown -->
    <div x-show="open" @click.away="open = false" x-transition
        class="absolute z-50 mt-1 w-full bg-white border rounded-lg shadow-lg max-h-64 overflow-y-auto">

        <!-- Search input -->
        <div class="p-2 border-b">
            <input type="text" x-model="search" placeholder="Enter at least 3 characters..."
                   class="w-full border rounded px-2 py-1 text-sm focus:ring-1 focus:ring-blue-400">
        </div>

        <!-- Options -->
        <div>
            <!-- Show message if less than 3 characters -->
            <template x-if="search.trim().length > 0 && search.trim().length < 3">
                <div class="px-3 py-2 text-gray-500 text-sm">
                    Enter at least 3 characters to search
                </div>
            </template>

            <!-- Show filtered results if 3+ characters -->
            <template x-if="search.trim().length >= 3 && limited.length > 0">
                <template x-for="item in limited" :key="item[valueField]">
                    <div @click="select(item)"
                         class="px-3 py-2 cursor-pointer hover:bg-blue-500 hover:text-white text-sm"
                         x-text="item[displayField]">
                    </div>
                </template>
            </template>

            <!-- No results found -->
            <template x-if="search.trim().length >= 3 && limited.length === 0">
                <div class="px-3 py-2 text-gray-500 text-sm">
                    No results found
                </div>
            </template>
        </div>
    </div>
</div>

<!-- Alpine.js Script -->
<script>
function searchableDropdown(items, displayField, valueField, eventName = null, selected = null) {
    let defaultItem = selected ? items.find(i => String(i[valueField]) === String(selected)) : null;

    return {
        open: false,
        search: '',
        selectedValue: defaultItem ? String(defaultItem[valueField]) : '',
        selectedText: defaultItem ? defaultItem[displayField] : '',
        items,
        displayField,
        valueField,
        eventName,

        init() {
            if (defaultItem && this.eventName) {
                window.dispatchEvent(new CustomEvent(this.eventName, { detail: defaultItem }));
            }
        },

        toggleDropdown() {
            this.open = !this.open;
            this.search = '';
        },

        // Filter only after 3 characters typed
        get filtered() {
            if (this.search.trim().length < 3) return [];
            const searchLower = this.search.trim().toLowerCase();
            return this.items.filter(i =>
                i[this.displayField].toLowerCase().includes(searchLower)
            );
        },

        // Limit to 10 results, scroll for more
        get limited() {
            return this.filtered.slice(0, 10);
        },

        select(item) {
            this.selectedValue = String(item[this.valueField]);
            this.selectedText = item[this.displayField];
            this.open = false;
            this.search = '';
            if (this.eventName) {
                window.dispatchEvent(new CustomEvent(this.eventName, { detail: item }));
            }
        }
    }
}
</script>
