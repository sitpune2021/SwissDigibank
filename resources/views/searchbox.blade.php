 <div class="flex flex-wrap gap-4 justify-between items-center bb-dashed mb-4 pb-4 lg:mb-6 lg:pb-6">
     <!-- <h4 class="h4">Manage Promotors</h4> -->
     <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-4">
         <label for="perPage" class="text-sm">Show</label>
         <select name="perPage" id="perPage" onchange="this.form.submit()"
             class="border rounded px-2 py-1 text-sm">
             <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
             <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
             <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
             <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
         </select>
         <span class="text-sm">entries</span>
     </form>
     <div class="flex items-center gap-4 flex-wrap grow sm:justify-end">
         <form
             class="bg-primary/5 dark:bg-bg3 border border-n30 dark:border-n500 flex gap-3 rounded-[30px] focus-within:border-primary p-1 items-center justify-between min-w-[200px] xxl:max-w-[319px] w-full">
             <input type="text" id="transaction-search" placeholder="Search"
                 class="bg-transparent border-none text-sm ltr:pl-4 rtl:pr-4 py-1 w-full" />
             <button
                 class="bg-primary shrink-0 rounded-full w-7 h-7 lg:w-8 lg:h-8 flex justify-center items-center text-n0">
                 <i class="las la-search text-lg"></i>
             </button>
         </form>
     </div>
 </div>