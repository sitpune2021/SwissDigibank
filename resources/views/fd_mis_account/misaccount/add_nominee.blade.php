@extends('layout.main')
@section('content')
<style>
    input[type="checkbox"] {
        width: 28px;
        height: 28px;
        accent-color: green;
        /* For modern browsers */
    }

    /* Fallback for browsers without accent-color support */
    input[type="checkbox"]:checked {
        background-color: green;
        border: none;
    }

    input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: green;
        /* Modern browser support */
    }

    .tableWidth {
        width: 90%;
        margin: auto;

    }

    .bg-yellow {
        background-color: #e17100;
    }
</style>

@section('content')
    <div class="main-inner">
        <div class="mb-6 flex flex-wrap items-center  justify-between gap-4 lg:mb-8">
            <div class="flex items-start flex-col  gap-2">
                <h1 class="text-xl font-semibold">FD Account - 03754 - Nominee</h1>
                <p class="text-gray-500">
                    <a href="#" class="text-gray-500 text-sm">Fd Accounts</a> >
                    <a href="#" class="text-gray-500 text-sm">03754</a> >
                    <a href="#" class="text-gray-500  text-sm"> Nominee</a>
                </p>

            </div>

        </div>



        <div class="bg-white dark:bg-bg3 rounded-xl shadow p-6">
  <h3 class="text-2xl mb-3 text-black">Add Nominee Details</h3>
  <hr class="my-3 border-gray-200" />

  <form action="{{ route('misaccount.updateNominee', $account->id) }}" method="POST" class="space-y-6">
    @csrf

    <!-- Nominee Yes/No -->
    <div>
      <label class="block text-lg mt-3 font-medium text-gray-700 uppercase">Nominee <span class="text-red-500">*</span></label>
      <div class="mt-2 flex gap-6">
        <label class="flex items-center gap-2">
          <input type="radio" name="has_nominee" value="yes" class="nominee-radio"> Yes
        </label>
        <label class="flex items-center gap-2">
          <input type="radio" name="has_nominee" value="no" class="nominee-radio" checked> No
        </label>
      </div>
    </div>

    <!-- Container for nominee fields -->
    <div id="nominee-container" class="space-y-6 hidden"></div>

    <!-- Add More Nominee -->
    <div class="text-right mt-3 hidden" id="addNomineeWrapper">
      <button type="button" id="addNomineeBtn"
              class="text-blue-600 font-semibold hover:underline uppercase">
        + ADD MORE Nominee
      </button>
    </div>

    <!-- Buttons -->
    <div class="flex flex-row mt-4 sm:flex-row gap-3 justify-center">
      <button type="submit"
              class="w-30 btn-primary items-center sm:w-auto bg-primary text-n0 px-5 py-3 rounded-3xl shadow hover:bg-n0 hover:border-primary transition">
        SAVE
      </button>
      <a href="{{ route('misaccount.changeAccountInfo', $account->id) }}"
         class="w-30 sm:w-auto bg-error text-n0 px-5 py-3 rounded-3xl shadow hover:bg-white hover:border-red-500 transition text-center">
        CANCEL
      </a>
    </div>
  </form>
</div>

<script>
  const nomineeContainer = document.getElementById("nominee-container");
  const addNomineeBtn = document.getElementById("addNomineeBtn");
  const addNomineeWrapper = document.getElementById("addNomineeWrapper");
  const radios = document.querySelectorAll(".nominee-radio");

  let nomineeCount = 0;

  function getNomineeFields(index) {
    return `
      <div class="p-4 border flex mt-4 rounded-lg space-y-4 bg-gray-50 relative">
        <button type="button" onclick="this.parentElement.remove()"
                class="absolute top-2 right-2 text-red-600 text-sm">✖</button>
        
        <div class="flex flex-col md:flex-row gap-6">
          <!-- Relation -->
          <div class="flex-1">
            <label class="block text-lg mt-3 font-medium text-gray-700 uppercase">
              Relation <span class="text-red-500">*</span>
            </label>
            <select name="nominees[${index}][relation]" 
                    class="mt-2 w-full bg-primary/5 p-3 rounded-3xl border-green-500 shadow-sm">
              <option value="">Select Relation</option>
              <option value="father">Father</option>
              <option value="mother">Mother</option>
              <option value="son">Son</option>
              <option value="daughter">Daughter</option>
              <option value="spouse">Spouse</option>
              <option value="husband">Husband</option>
              <option value="wife">Wife</option>
              <option value="brother">Brother</option>
              <option value="sister">Sister</option>
              <option value="daughter_in_law">Daughter in Law</option>
              <option value="brother_in_law">Brother in Law</option>
              <option value="grand_daughter">Grand Daughter</option>
              <option value="grand_son">Grand Son</option>
              <option value="nephew">Nephew</option>
              <option value="niece">Niece</option>
              <option value="other">Other</option>
            </select>
          </div>

          <!-- Name -->
          <div class="flex-1">
            <label class="block text-lg font-medium text-gray-700">
              Name <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nominees[${index}][name]"
                   placeholder="Enter Nominee Name"
                   class="mt-2 w-full bg-primary/5 p-3 rounded-3xl border-green-500 shadow-sm" />
          </div>
        </div>

        <!-- Address -->
        <div>
          <label class="block text-lg font-medium text-gray-700">
            Address <span class="text-red-500">*</span>
          </label>
          <textarea name="nominees[${index}][address]"
                    placeholder="Enter Nominee Address" 
                    class="mt-2 w-full bg-primary/5 p-3 rounded-xl border-green-500 shadow-sm"></textarea>
        </div>
      </div>
    `;
  }

  // Show/Hide nominee section based on Yes/No
  radios.forEach(radio => {
    radio.addEventListener("change", () => {
      if (radio.value === "yes" && radio.checked) {
        nomineeContainer.classList.remove("hidden");
        addNomineeWrapper.classList.remove("hidden");
        nomineeContainer.innerHTML = getNomineeFields(nomineeCount);
        nomineeCount = 1;
      }
      if (radio.value === "no" && radio.checked) {
        nomineeContainer.innerHTML = "";
        nomineeContainer.classList.add("hidden");
        addNomineeWrapper.classList.add("hidden");
        nomineeCount = 0;
      }
    });
  });

  // Add nominee fields dynamically
  addNomineeBtn.addEventListener("click", () => {
    nomineeContainer.insertAdjacentHTML("beforeend", getNomineeFields(nomineeCount));
    nomineeCount++;
  });
</script>

               
@endsection