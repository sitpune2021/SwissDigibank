@extends('layout.main')

@section('content')
<div class="main-inner">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase font-semibold text-xl">Upload Employee Documents</h3>
            
        </div>
    </div>
<div class="box">

    <div id="upload_doc" class="space-y-3 ">
        <!-- Dynamic rows will be added here -->
    </div>

    <!-- Add Row Button -->
    <div class="mt-3 mb-5">
        <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
            + Add New Document
        </button>
    </div>

     <!-- Buttons -->
        <div class="flex justify-center gap-4 pt-6">
          <button type="submit" class="btn-primary">
            UPLOAD
          </button>
          <a href="" class="btn-outline">
            BACK
          </a>
        </div>

</div>

<script>
    const uploadDoc = document.getElementById("upload_doc");
    const addRowBtn = document.getElementById("addRow");

    function newRow() {
        return `
        <div class="flex gap-6 px-3 py-3 border rounded-lg dark:bg-bg3">
            <input type="text"   name="document_name[]" 
                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3"
                    placeholder="Enter Document Name ">

            <input type="file" name="document_file[]"
                class="w-full text-sm bg-secondary/5 dark:bg-bg3 border border-n30 dark:border-n500 rounded-10 px-3 md:px-6 py-2 md:py-3">

          

            <button type="button" class="removeRow text-red-500 hover:text-red-700">
                <i class="las la-times" aria-hidden="true"></i>
            </button>
        </div>
        `;
    }

    addRowBtn.addEventListener("click", () => {
        uploadDoc.insertAdjacentHTML("beforeend", newRow());
    });

    uploadDoc.addEventListener("click", function(e) {
        if (e.target.closest(".removeRow")) {
            e.target.closest("div").remove();
        }
    });
</script>
@endsection