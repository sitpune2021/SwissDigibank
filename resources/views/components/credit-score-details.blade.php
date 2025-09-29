<div>
    <!-- Table -->
    <div class="w-full overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg whitespace-nowrap" id="cibilTable">
            <thead class="bg-secondary/5">
                <tr class="bg-gray-100">
                    <th class="text-center px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-sm md:text-base">
                        Cibil Type
                    </th>
                    <th class="text-center px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-sm md:text-base">
                        Cibil Score
                    </th>
                    <th class="text-center px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-sm md:text-base">
                        Report Date
                    </th>
                    <th class="text-center px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-sm md:text-base">
                        Upload File
                    </th>
                    <th class="border border-gray-300 px-2 py-2 md:px-4 md:py-2"></th>
                </tr>
            </thead>
            <tbody id="cibilBody" class="bg-gray-100"></tbody>
        </table>
    </div>

    <!-- Add Row Button -->
    <div class="mt-3">
        <button type="button" id="addRow" class="btn-primary rounded-10 px-4 py-2">
            + Add New Score
        </button>
    </div>
</div>
<script>
    // =====logic for dynamic cibil rows=====

    const cibilBody = document.getElementById("cibilBody");
    const addRowBtn = document.getElementById("addRow");

    // Template for new row
    function newRow() {
        return `
                          <tr class="nested-fields">
                            <!-- Cibil Type -->
                            <td class="px-2 py-2 border border-gray-300"    ">
                              <select name="cibil_type[]" required 
                                class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5">
                                <option value="">Select</option>
                                <option value="transunion">TransUnion</option>
                                <option value="equifax">Equifax</option>
                                <option value="experian">Experian</option>
                                <option value="crif_highmark">Crif Highmark</option>
                              </select>
                            </td>

                            <!-- Cibil Score -->
                            <td class="px-2 py-2 border border-gray-300">
                              <input type="number" name="cibil_score[]" placeholder="Enter CIBIL Score"
                                class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5" required/>
                            </td>

                            <!-- Report Date -->
                            <td class="px-2 py-2 border border-gray-300 relative">
                              <input type="text" id="date2" name="report_date[]"  placeholder="DD/MM/YYYY"
                                class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5" required/>
                            </td>

                            <!-- Upload File -->
                            <td class="px-2 py-2 border border-gray-300">
                              <input type="file" name="report_file[]"
                                class="w-full text-center dark:bg-bg3 border border-gray-300 rounded-10 px-2 py-2 text-sm md:text-base bg-secondary/5"/>
                            </td>

                            <!-- Remove button -->
                            <td class="px-2 py-2 md:px-4 md:py-2 border border-gray-300 text-center">
                              <button type="button" class="removeRow text-red-500 hover:text-red-700">
                                <i class="las la-times" aria-hidden="true"></i>
                              </button>
                            </td>
                          </tr>
                        `;
    }


    // Add row
    addRowBtn.addEventListener("click", () => {


        cibilBody.insertAdjacentHTML("beforeend", newRow());
    });

    // Remove row (event delegation)
    cibilBody.addEventListener("click", function(e) {
        if (e.target.closest(".removeRow")) {
            e.target.closest("tr").remove();
        }
    });
</script>