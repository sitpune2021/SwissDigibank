@extends('layout.main')

@section('content')

<!-- ================= STYLES ================= -->
<style>
  .calendar {
    max-width: 1000px;
    margin: auto;
    border: 1px solid #ddd;
  }

  .calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: #f3f4f6;
  }

  .calendar-days div {
    text-align: center;
    padding: 8px;
    font-weight: 600;
    border-right: 1px solid #ddd;
  }

  .calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
  }

  .day {
    min-height: 120px;
    border: 1px solid #eee;
    padding: 6px;
    cursor: pointer;
  }

  .date {
    font-weight: 600;
  }

  .event {
    font-size: 11px;
    margin-top: 4px;
    padding: 2px 4px;
    border-radius: 4px;
    background: #3b82f6;
    color: white;
  }
</style>

<div class="p-4">
  <div class="flex items-center justify-between mb-5 px-6">
    <h3 class="text-lg font-semibold uppercase ">Event Calendar</h3>
    <a href="{{ route('software-settings.event-calender.all-event-list') }}" class="uppercase btn-primary px-3">Show All Event List</a>
  </div>

  <!-- ================= MONTH CALENDAR ================= -->
  <div class="calendar box rounded-lg overflow-hidden">
    <!-- Header -->
    <div class="flex justify-center items-center gap-4 p-3 border-b">
      <button id="prevMonth">❮</button>
      <h2 id="monthYear" class="font-semibold"></h2>
      <button id="nextMonth">❯</button>
    </div>

    <!-- Days -->
    <div class="calendar-days">
      <div>Sun</div><div>Mon</div><div>Tue</div>
      <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
    </div>

    <!-- Grid -->
    <div class="calendar-grid" id="calendarGrid"></div>
  </div>
</div>

<!-- ================= MODAL ================= -->
<div id="eventModal"
  class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

  <div style="width: 500px" class="bg-white w-[600px] rounded-lg shadow-lg">

    <!-- Header -->
    <div class="flex justify-between items-center px-5 py-3 border-b">
      <h4 class="text-lg font-semibold">
        ADD / UPDATE EVENT – <span class="text-lg" id="eventDate"></span>
      </h4>
      <button onclick="closeModal()" class="text-xl   text-error p-2">X</button>
    </div>

    <!-- Body -->
    <form id="eventForm" class="p-5 space-y-6">

  <input type="hidden" id="event_date">

  <!-- EVENT ROWS -->
  <div id="eventInputs" class="space-y-4">

    <!-- ROW -->
    <div class="border rounded-lg p-4 flex flex-col gap-4">

      <!-- TOP ROW : LABEL + INPUT + REMOVE -->
      <div class=" w-full flex items-center justify-between flex-col gap-4">

        <label class="w-full font-medium">
          Event Name <span class="text-red-500">*</span>
        </label>
 </div>
        <input
          type="text"
          class="flex-1 border rounded px-3 py-2 event-name"
          placeholder="Enter Event Name"
          required>

        <!-- REMOVE -->
        
     
      <button type="button"
          onclick="this.closest('.event-row').remove()"
          class="text-red-600 text-xl font-semibold">
          ×
        </button>

      <!-- HOLIDAY -->
      <div class="flex items-center gap-4 pl-[33%]">
        <label class="flex items-center gap-2">
          <input type="checkbox" class="accent-blue-600  is-holiday">
          Mark as Holiday
        </label>
      </div>

    </div>

  </div>

  <!-- Footer -->
  <div class="flex justify-between items-center pt-4 border-t">
    <button type="button"
      onclick="addMore()"
      class="px-4 py-2 btn-secondary text-white ">
      ADD MORE +
    </button>

    <button type="button"
      onclick="saveEvent()"
      class="px-4 py-2 btn-primary ">
      UPDATE
    </button>
  </div>

</form>

{{-- <form action="" id="eventForm">
    <input type="hidden" id="event_date">
     <!-- Footer -->
   <div id="eventInputs" >

   </div>
  <div class="flex justify-between items-center p-3 border-t">
    <button type="button"
      onclick="addMore()"
      class="px-4 py-2 bg-blue-600 text-white rounded">
      ADD MORE (+)
    </button>

    <button type="button"
      onclick="saveEvent()"
      class="px-4 py-2 bg-primary text-white rounded">
      UPDATE
    </button>
  </div>
</form> --}}

  </div>
</div>


<!-- ================= SCRIPT ================= -->
<script>
  const calendarGrid = document.getElementById('calendarGrid');
  const monthYear = document.getElementById('monthYear');
  const modal = document.getElementById('eventModal');
  const eventDateEl = document.getElementById('eventDate');
  const eventDateInput = document.getElementById('event_date');
  const eventInputs = document.getElementById('eventInputs');

  let currentDate = new Date();
  let eventData = {};
  let selectedKey = null;

  function formatDate(d) {
    return String(d.getDate()).padStart(2,'0') + '-' +
           String(d.getMonth()+1).padStart(2,'0') + '-' +
           d.getFullYear();
  }

  function renderCalendar() {
    calendarGrid.innerHTML = '';
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();

    monthYear.textContent = currentDate.toLocaleString('default',{month:'long',year:'numeric'});

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month+1, 0).getDate();

    for (let i=0;i<firstDay;i++) calendarGrid.appendChild(document.createElement('div'));

    for (let day=1; day<=daysInMonth; day++) {
      const div = document.createElement('div');
      div.className = 'day';
      const key = `${year}-${month+1}-${day}`;

      if (day===today.getDate() && month===today.getMonth() && year===today.getFullYear()) {
        div.style.background = '#fef3c7';
      }

      div.innerHTML = `<div class="date">${day}</div>`;

      if (eventData[key]) {
        eventData[key].forEach(e => {
          div.innerHTML += `<div class="event">${e.name}</div>`;
        });
      }

      div.onclick = () => {
        selectedKey = key;
        openModal(formatDate(new Date(year,month,day)));
      };

      calendarGrid.appendChild(div);
    }
  }

  function openModal(date) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    eventDateEl.textContent = date;
    eventDateInput.value = date;
    eventInputs.innerHTML = '';
    addMore();
  }

  function closeModal() {
    modal.classList.add('hidden');
  }

  function addMore() {
    const div = document.createElement('div');
    div.className = 'border rounded p-4 relative mt-3';

    div.innerHTML = `
      <div class="text-end">
        <button type="button"
        onclick="this.parentElement.remove()"
        class=" top-2 right-2 text-red-600">X</button>
      </div>  

      <div class=" gap-4 items-center">
        <label class="col-span-4 font-medium">
          Event Name <span class="text-red-500">*</span>
        </label>
        <input type="text"
          class="col-span-8 border rounded px-3 py-2 event-name"
          placeholder="Enter Event Name">
      </div>

      <div class="mt-3 ml-[33%]">
        <label class="flex items-center gap-2">
          <input type="checkbox" class="accent-blue-600 is-holiday">
          Mark as Holiday
        </label>
      </div>
    `;
    eventInputs.appendChild(div);
  }

  function saveEvent() {
    eventData[selectedKey] = [...eventInputs.children].map(div => ({
      name: div.querySelector('.event-name').value,
      holiday: div.querySelector('.is-holiday').checked
    }));
    closeModal();
    renderCalendar();
  }

  document.getElementById('prevMonth').onclick = () => {
    currentDate.setMonth(currentDate.getMonth()-1);
    renderCalendar();
  };

  document.getElementById('nextMonth').onclick = () => {
    currentDate.setMonth(currentDate.getMonth()+1);
    renderCalendar();
  };

  renderCalendar();
</script>

@endsection
