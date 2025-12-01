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
            <h3 class=" flex text-xl block uppercase font-semibold">
                Attendance Records - (11-11-2025)
            </h3>
        </div>

        <div class="col-span-12 box lg:col-span-12">
            <div class=" flex  justify-center  items-center flex-col md:flex-row lg:flex-row   gap-4 mb-6">
                <label for="" class="md:text-lg font-medium uppercase">
                    Attendance Date
                </label>
                <div>
                    <input type="text" name="" id="date"
                        class="datepicker-field w-full text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize"
                        placeholder="DD/MM/YYYY">

                </div>

            </div>
            <div class="pb-4 overflow-x-auto lg:pb-6">
                <table class="w-full whitespace-nowrap select-all-table" id="transactionTable1">
                    <thead>
                        <tr class="bg-secondary/5 dark:bg-bg3">
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer ">
                                <div class="flex items-center gap-1 uppercase">
                                    EMPLOYEE NAME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    DESIGNATION
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    IN TIME
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[130px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    OUT TIME
                                </div>
                            </th>

                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    WORKING TIME
                                </div>
                            </th>
                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    STATUS
                                </div>
                            </th>


                            <th class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    CALENDAR
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

                        <tr class="border-b dark:border-bg3">
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1  uppercase">
                                    ROMITA MUKHERJEE
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 uppercase">
                                    BRANCH MANAGER
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">
                                    <a href="javascript:void(0)" data-modal="attendanceModal1"
                                        class="btn-primary p-2 rounded-10">
                                        <i class="las la-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center uppercase gap-1">

                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 lowercase">
                                    0 h 0 min
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1 ">
                                    <div class="px-6  flex  flex-row gap-3">
                                        <select name="" id=""
                                            class="w-64 text-sm bg-secondary/5 dark:bg-bg3 border rounded-10 px-3 md:px-6 py-2 md:py-3 capitalize">
                                            <option value="">Select Status</option>
                                            <option value="">Absent</option>
                                            <option value="">Full Day</option>
                                            <option value="">Half Day</option>
                                            <option value="">Leave</option>
                                            <option value="">Holiday</option>
                                        </select>
                                        <a href="" class="btn-primary rounded-10 py-2 px-1 uppercase">
                                            Update
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">
                                    <a href="" id="" class="btn-primary rounded-10 p-2 justify-center">
                                        <i class="las la-calendar-alt "></i>
                                    </a>
                                </div>
                            </td>
                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex items-center gap-1">

                                </div>
                            </td>

                            <td class="text-start !py-5 px-6 min-w-[100px] cursor-pointer">
                                <div class="flex justify-center">
                                    <div class="relative">
                                        <i class="las la-ellipsis-v horiz-option-btn cursor-pointer popover-button"></i>
                                        <ul class="horiz-option popover-content">
                                            <li>
                                                <a href="javascript:void(0)" data-modal="attendanceModal2" class="single-option uppercase">Edit Time</a>
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

                    </tbody>

                </table>

            </div>
            {{-- IN TIME --}}
            <div id="attendanceModal1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop"
                style="margin-top:100px;">

                <div class="bg-white rounded-2xl shadow-2xl mt-6 max-w-sm mx-auto " style="width: 350px;">

                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b px-4 py-3">
                        <h2 class="text-lg font-semibold text-center w-full">
                            ATTENDANCE RECORD
                            <p>(11-11-2025)</p>
                        </h2>
                        <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                            <i class="las la-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4 text-center">
                        <form class="space-y-4">
                            <table class="w-full border border-gray-200 rounded-lg">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center p-2 bg-gray-100">
                                            USER NAME: <span class="font-semibold">ROMITA MUKHERJEE</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="text-center text-primary p-2">IN TIME</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center p-2">
                                            <div class="flex justify-center gap-2">
                                                <select class="border rounded-lg px-2 py-1">
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11" selected="selected">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                                :
                                                <select class="border rounded-lg px-2 py-1">
                                                    <option value="00">00</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21" selected="selected">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                    <option value="51">51</option>
                                                    <option value="52">52</option>
                                                    <option value="53">53</option>
                                                    <option value="54">54</option>
                                                    <option value="55">55</option>
                                                    <option value="56">56</option>
                                                    <option value="57">57</option>
                                                    <option value="58">58</option>
                                                    <option value="59">59</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="w-full btn-primary justify-center">
                                SUBMIT
                            </button>
                        </form>
                    </div>
                </div>
            </div>
             <div id="attendanceModal2" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop"
                style="margin-top:100px;">

                <div class="bg-white rounded-2xl shadow-2xl mt-6 max-w-sm mx-auto " style="width: 350px;">

                    <!-- Modal Header -->
                    <div class="flex justify-between items-center border-b px-4 py-3">
                        <h2 class="text-lg font-semibold text-center w-full">
                            ATTENDANCE RECORD
                            <p>(11-11-2025)</p>
                        </h2>
                        <button id="closeModalBtn" class="text-gray-500 hover:text-gray-700">
                            <i class="las la-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-4 text-center">
                        <form class="space-y-4">
                            <table class="w-full border border-gray-200 rounded-lg">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center p-2 bg-gray-100">
                                            USER NAME: <span class="font-semibold">ROMITA MUKHERJEE</span>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="text-center text-primary p-2">IN TIME</th>
                                    </tr>
                                    <tr>
                                        <td class="text-center p-2">
                                            <div class="flex justify-center gap-2">
                                                <select class="border rounded-lg px-2 py-1">
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11" selected="selected">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                </select>
                                                :
                                                <select class="border rounded-lg px-2 py-1">
                                                    <option value="00">00</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21" selected="selected">21</option>
                                                    <option value="22">22</option>
                                                    <option value="23">23</option>
                                                    <option value="24">24</option>
                                                    <option value="25">25</option>
                                                    <option value="26">26</option>
                                                    <option value="27">27</option>
                                                    <option value="28">28</option>
                                                    <option value="29">29</option>
                                                    <option value="30">30</option>
                                                    <option value="31">31</option>
                                                    <option value="32">32</option>
                                                    <option value="33">33</option>
                                                    <option value="34">34</option>
                                                    <option value="35">35</option>
                                                    <option value="36">36</option>
                                                    <option value="37">37</option>
                                                    <option value="38">38</option>
                                                    <option value="39">39</option>
                                                    <option value="40">40</option>
                                                    <option value="41">41</option>
                                                    <option value="42">42</option>
                                                    <option value="43">43</option>
                                                    <option value="44">44</option>
                                                    <option value="45">45</option>
                                                    <option value="46">46</option>
                                                    <option value="47">47</option>
                                                    <option value="48">48</option>
                                                    <option value="49">49</option>
                                                    <option value="50">50</option>
                                                    <option value="51">51</option>
                                                    <option value="52">52</option>
                                                    <option value="53">53</option>
                                                    <option value="54">54</option>
                                                    <option value="55">55</option>
                                                    <option value="56">56</option>
                                                    <option value="57">57</option>
                                                    <option value="58">58</option>
                                                    <option value="59">59</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" class="w-full btn-primary justify-center">
                                SUBMIT
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>


    {{-- IN TIME --}}
    <script>
  document.addEventListener("DOMContentLoaded", () => {
    // Open modal
    document.querySelectorAll("[data-modal]").forEach(btn => {
      btn.addEventListener("click", () => {
        const modalId = btn.getAttribute("data-modal");
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove("hidden");
      });
    });

    // Close modal on close button
    document.querySelectorAll(".closeModalBtn").forEach(btn => {
      btn.addEventListener("click", (e) => {
        const modal = e.target.closest(".fixed");
        if (modal) modal.classList.add("hidden");
      });
    });

    // Close modal when clicking outside
    document.querySelectorAll(".fixed.inset-0").forEach(modal => {
      modal.addEventListener("click", (e) => {
        if (e.target === modal) modal.classList.add("hidden");
      });
    });
  });
</script>


    <!-- JS for Modal + Calendar -->


@endsection