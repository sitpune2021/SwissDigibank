@extends('layout.main')

@section('content')

<style>
  .calendar {
    max-width: 1000px;
    margin: auto;
    border: 1px solid #ddd;
    font-family: Arial, sans-serif;
  }

  .calendar-header {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }

  .calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: #f5f5f5;
    position: sticky;
    top: 0;
  }

  .calendar-days div {
    text-align: center;
    padding: 8px;
    font-weight: bold;
    border-right: 1px solid #ddd;
  }

  .calendar-scroll {
    height: 500px;
    overflow-y: auto;
  }

  .calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
  }

  .day {
    min-height: 130px;
    border: 1px solid #eee;
    padding: 6px;
    cursor: pointer;
  }

  .day.other-month {
    background: #fafafa;
    color: #aaa;
  }

  .date {
    font-weight: bold;
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

  <!-- HEADER -->
  <div class="flex justify-between items-center mb-4">
    <h3 class="text-lg font-semibold uppercase">Attendance Calendar</h3>
    <div class="inline-flex box border rounded-10 px-2 py-1 overflow-hidden">
      <button id="btnMonth" class="px-4 py-2 bg-primary  rounded-10">Month</button>
      <button id="btnWeek" class="px-4 py-2 rounded-10 border-l">Week</button>
      <button id="btnDay" class=""></button>
    </div>

  </div>
  {{-- do not rermove --}}

  <!-- MONTH VIEW -->
  <div id="monthView">
    <div class="calendar box rounded-lg overflow-hidden border">
      <!-- Month Header -->
      <div class="calendar-header flex justify-center items-center gap-4 p-2 border-b">
        <button id="prevMonth">❮</button>
        <h2 id="monthYear" class="font-semibold"></h2>
        <button id="nextMonth">❯</button>
      </div>

      <!-- Days Names -->
      <div class="calendar-days grid grid-cols-7 bg-gray-100 font-bold text-center border-b">
        <div>Sun</div>
        <div>Mon</div>
        <div>Tue</div>
        <div>Wed</div>
        <div>Thu</div>
        <div>Fri</div>
        <div>Sat</div>
      </div>

      <!-- Dates Grid -->
      <div class="calendar-scroll h-[500px] overflow-y-auto">
        <div id="calendarGrid" class="calendar-grid grid grid-cols-7"></div>
      </div>
    </div>
  </div>

  <!-- WEEK VIEW -->
  <div id="weekView" class="hidden box">
    <h3 class="text-lg font-semibold mb-4">Gold Rate Week Calendar</h3>
    <div class="overflow-x-auto border rounded-lg">
      <table class="w-full border-collapse text-sm">
        <!-- Week Header -->
        <thead class="bg-gray-100 font-semibold border-b">
          <tr>
            <th class="border-r p-2">Time</th>
            <th class="border-r p-2" id="thSun"></th>
            <th class="border-r p-2" id="thMon"></th>
            <th class="border-r p-2" id="thTue"></th>
            <th class="border-r p-2" id="thWed"></th>
            <th class="border-r p-2" id="thThu"></th>
            <th class="border-r p-2" id="thFri"></th>
            <th class="p-2" id="thSat"></th>
          </tr>
        </thead>
        <tbody id="weekTbody">
          <!-- JS will generate rows -->
        </tbody>
      </table>
    </div>
  </div>



  <!-- DAY VIEW -->
  {{-- <div id="dayView" class="hidden box border rounded p-4"></div> --}}
  <div id="" class="hidden box border rounded p-4">
    <h3 class="text-lg font-semibold mb-4">Gold Rate Day Calendar</h3>
    <div class="overflow-x-auto border rounded-lg">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th class="p-2 border-r bg-gray-100 text-right">Time</th>
            <th id="dayTh" class="p-2 bg-gray-100">Date</th>
          </tr>
        </thead>
        <tbody id="dayTbody"></tbody>
      </table>
    </div>
  </div>

</div>

</div>

<!-- MODAL -->
<div id="dateModal" style="background-color: #dfdddd3a" class="fixed inset-0 hidden  items-center justify-center z-50">
  <div class="bg-white w-[520px] rounded-lg p-4">
    <h3 id="modalTitle" class="font-semibold mb-4">GOLD RATE CALENDAR</h3>
    <div id="rateContainer" class="space-y-3"></div>
    <button id="addMore" class="text-primary mt-2">+ Add more</button>
    <div class="flex justify-end gap-2 mt-5">
      <button id="closeModal" class="px-4 py-2 border uppercase btn-outline ">BACK</button>
      <button id="saveData" class="px-4 py-2 btn-primary uppercase text-white ">Update</button>
    </div>
  </div>
</div>
<!-- NEW POPUP MODAL FOR WEEK VIEW -->
<div id="weekModal" style="background-color: #dfdddd3a" class="fixed inset-0 hidden  items-center justify-center z-50">
  <div class="bg-white w-[520px] rounded-lg p-4">
    <h3 id="weekModalTitle" class="font-semibold mb-4">GOLD RATE CALENDAR</h3>
    <div id="weekRateContainer" class="space-y-3"></div>
    <button id="weekAddMore" class="text-primary mt-2">+ Add more</button>
    <div class="flex justify-end gap-2 mt-5">
      <button id="weekClose" class="px-4 py-2 border uppercase btn-outline">BACK</button>
      <button id="weekSave" class="px-4 py-2 btn-primary uppercase text-white">Update</button>
    </div>
  </div>
</div>

<!-- DAY MODAL -->
{{-- <div id="dayModal" class="fixed inset-0 hidden bg-black/40 items-center justify-center z-50">
  <div class="bg-white w-[520px] rounded-lg p-4">
    <h3 id="dayModalTitle" class="font-semibold mb-4">GOLD RATE CALENDAR</h3>
    <div id="dayRateContainer" class="space-y-3"></div>
    <button id="dayAddMore" class="text-blue-600 mt-2">+ Add more</button>
    <div class="flex justify-end gap-2 mt-5">
      <button id="dayClose" class="px-4 py-2 border rounded">Cancel</button>
      <button id="daySave" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </div>
  </div>
</div> --}}

<!-- STYLES -->
<style>
  .calendar-grid div.day {
    min-height: 130px;
    border: 1px solid #eee;
    padding: 6px;
    cursor: pointer;
  }

  .calendar-grid div.day.other-month {
    background: #fafafa;
    color: #aaa;
  }

  .calendar-grid div.date {
    font-weight: bold;
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

<!-- SCRIPTS -->
<script>
  // ------------------ VIEW TOGGLE ------------------
  const btnMonth = document.getElementById('btnMonth');
  const btnWeek = document.getElementById('btnWeek');
  const btnDay = document.getElementById('btnDay');
  const monthView = document.getElementById('monthView');
  const weekView = document.getElementById('weekView');
  const dayView = document.getElementById('dayView');

  function activate(btn) {
    [btnMonth, btnWeek, btnDay].forEach(b=>{
     b.classList.remove('bg-primary', 'text-black');
      //  btn.classList.add('bg-error', 'text-black');
    });
      btn.classList.add('bg-primary', 'text-black');
  }

  btnMonth.onclick = () => { activate(btnMonth); monthView.classList.remove('hidden'); weekView.classList.add('hidden'); dayView.classList.add('hidden'); };
  btnWeek.onclick = () => { activate(btnWeek); monthView.classList.add('hidden'); weekView.classList.remove('hidden'); dayView.classList.add('hidden'); renderWeek(); };
  btnDay.onclick = () => { activate(btnDay); monthView.classList.add('hidden'); weekView.classList.add('hidden'); dayView.classList.remove('hidden'); };

  // ------------------ MODAL & DATA ------------------
  const calendarGrid = document.getElementById('calendarGrid');
  const monthYear = document.getElementById('monthYear');
  const prevMonth = document.getElementById('prevMonth');
  const nextMonth = document.getElementById('nextMonth');
  const modal = document.getElementById('dateModal');
  const modalTitle = document.getElementById('modalTitle');
  const rateContainer = document.getElementById('rateContainer');
  const addMoreBtn = document.getElementById('addMore');
  const saveBtn = document.getElementById('saveData');
  const closeBtn = document.getElementById('closeModal');

  let currentDate = new Date();
  let selectedKey = null;
  let rateData = {};

  // ------------------ CREATE ROW ------------------
  function createRow(data={}) {
    const div = document.createElement('div');
    div.className='flex gap-2 items-center';
    div.innerHTML=`
      <label>Type <span class="text-error">*</span></label>
      <select class="border px-2 py-1 type">
        <option value="">Type</option>
        <option value="Gold" ${data.type==='Gold'?'selected':''}>Gold</option>
        <option value="Silver" ${data.type==='Silver'?'selected':''}>Silver</option>
      </select>
      <label>Purity <span class="text-error">*</span></label>
      <input class="border px-2 py-1 purity" placeholder="Purity" value="${data.purity||''}">
       <label>Rate per Gram (₹) <span class="text-error">*</span></label>
      <input class="border px-2 py-1 rate flex-1" placeholder="Rate per Gram (₹)" value="${data.rate||''}">
      <button class="text-red-600 remove">✕</button>
    `;
    div.querySelector('.remove').onclick=()=>div.remove();
    return div;
  }

  addMoreBtn.onclick = ()=>rateContainer.appendChild(createRow());
  closeBtn.onclick = ()=>modal.classList.add('hidden');
  saveBtn.onclick = () => {
    rateData[selectedKey] = [...rateContainer.children].map(r=>({
      type:r.querySelector('.type').value,
      purity:r.querySelector('.purity').value,
      rate:r.querySelector('.rate').value
    }));
    modal.classList.add('hidden');
    renderCalendar();
    renderWeek();
  };

  // ------------------ MONTH CALENDAR ------------------
  function formatDate(d){ return d.toLocaleDateString('en-GB'); }

  function renderCalendar() {
    calendarGrid.innerHTML='';
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const today = new Date();
    monthYear.textContent = currentDate.toLocaleString('default',{month:'long',year:'numeric'});

    const firstDay = new Date(year, month,1).getDay();
    const daysInMonth = new Date(year, month+1,0).getDate();

    for(let i=0;i<firstDay;i++) calendarGrid.appendChild(document.createElement('div'));
    for(let day=1;day<=daysInMonth;day++){
      const div = document.createElement('div'); div.className='day';
      const key = `${year}-${month+1}-${day}`;

      if(day===today.getDate() && month===today.getMonth() && year===today.getFullYear()) div.style.background='yellow';

      div.innerHTML=`<div class="date">${day}</div>`;
      if(rateData[key]) rateData[key].forEach(r=>div.innerHTML+=`<div class="event">${r.type}: ₹${r.rate}</div>`);
function formatDate(d) {
  const dd = String(d.getDate()).padStart(2, '0');
  const mm = String(d.getMonth() + 1).padStart(2, '0');
  const yyyy = d.getFullYear();
  return `${dd}-${mm}-${yyyy}`;
}
      div.onclick = () => {
        selectedKey = key;
        modalTitle.textContent=`GOLD RATE CALENDAR (${formatDate(new Date(year,month,day))})`;
        rateContainer.innerHTML='';
        (rateData[key]||[{}]).forEach(r=>rateContainer.appendChild(createRow(r)));
        modal.classList.remove('hidden'); modal.classList.add('flex');
      };

      calendarGrid.appendChild(div);
    }
  }

  prevMonth.onclick=()=>{currentDate.setMonth(currentDate.getMonth()-1); renderCalendar();}
  nextMonth.onclick=()=>{currentDate.setMonth(currentDate.getMonth()+1); renderCalendar();}
  renderCalendar();

  

</script>
<style>
  .week-cell {
    min-height: 40px;
    border: 1px solid #eee;
    cursor: pointer;
    padding: 2px;
  }

  .week-cell:hover {
    background: #e0f2fe;
  }

  .week-event {
    background: #ffffff;
    color: rgb(0, 0, 0);
    text-xs rounded px-1 py-0.5 mb-0.5 block;
    display: block;
  }

  .today-col {
    background: #fef3c7;
  }

  /* yellow for today */
</style>

<script>
  const weekTbody = document.getElementById('weekTbody');
  const thSun = document.getElementById('thSun');
  const thMon = document.getElementById('thMon');
  const thTue = document.getElementById('thTue');
  const thWed = document.getElementById('thWed');
  const thThu = document.getElementById('thThu');
  const thFri = document.getElementById('thFri');
  const thSat = document.getElementById('thSat');

  const weekModal = document.getElementById('weekModal');
  const weekModalTitle = document.getElementById('weekModalTitle');
  const weekRateContainer = document.getElementById('weekRateContainer');
  const weekAddMore = document.getElementById('weekAddMore');
  const weekClose = document.getElementById('weekClose');
  const weekSave = document.getElementById('weekSave');

  let weekRateData = {}; // store per date
  let weekSelectedKey = null;

  function getWeekDates(baseDate=new Date()) {
    const start = new Date(baseDate);
    start.setDate(start.getDate() - start.getDay());
    return Array.from({length:7}, (_,i)=>{ const d=new Date(start); d.setDate(start.getDate()+i); return d; });
  }

  function formatISO(date) { return date.toISOString().split('T')[0]; }
  function formatHeader(date) { return date.toLocaleDateString('en-GB',{weekday:'short',day:'2-digit',month:'2-digit'}); }
  function formatHour(h) { const ampm=h>=12?'pm':'am'; return `${h%12||12}${ampm}`; }

  function createWeekRowInput(data={}) {
    const div = document.createElement('div');
    div.className='flex gap-2 items-center';
    div.innerHTML=`
     <label>Type <span class="text-error">*</span></label>
      <select class="border px-2 py-1 type">
        <option value="">Type </option>
        <option value="Gold" ${data.type==='Gold'?'selected':''}>Gold</option>
        <option value="Silver" ${data.type==='Silver'?'selected':''}>Silver</option>
      </select>
      <label>Purity <span class="text-error">*</span></label>
      <input class="border px-2 py-1 purity" placeholder="Purity " value="${data.purity||''}">
       <label>Rate per Gram (₹) <span class="text-error">*</span></label>
      <input class="border px-2 py-1 rate flex-1" placeholder="Rate per Gram (₹)" value="${data.rate||''}">
      <button class="text-red-600 remove">✕</button>
    `;
    div.querySelector('.remove').onclick=()=>div.remove();
    return div;
  }

  weekAddMore.onclick = ()=> weekRateContainer.appendChild(createWeekRowInput());
  weekClose.onclick = ()=> weekModal.classList.add('hidden');
  weekSave.onclick = ()=>{
    weekRateData[weekSelectedKey] = [...weekRateContainer.children].map(r=>({
      type: r.querySelector('.type').value,
      purity: r.querySelector('.purity').value,
      rate: r.querySelector('.rate').value
    }));
    weekModal.classList.add('hidden');
    renderWeekTable();
  };

  function renderWeekTable(baseDate=new Date()){
    weekTbody.innerHTML='';
    const weekDates = getWeekDates(baseDate);
    const todayISO = formatISO(new Date());

    // set header
    [thSun,thMon,thTue,thWed,thThu,thFri,thSat].forEach((th,i)=>{
      const date = weekDates[i];
      th.textContent = formatHeader(date);
      if(formatISO(date)===todayISO) th.classList.add('today-col');
      else th.classList.remove('today-col');
    });

    // create 24 rows (hours)
    for(let hour=0;hour<24;hour++){
      const tr = document.createElement('tr');
      const timeTd = document.createElement('td');
      timeTd.className='border p-1 text-right text-gray-500 bg-gray-50';
      timeTd.textContent = formatHour(hour);
      tr.appendChild(timeTd);

      weekDates.forEach(date=>{
        const iso = formatISO(date);
        const td = document.createElement('td');
        td.className='week-cell '+(iso===todayISO?'today-col':'');
        td.dataset.date=iso;
        td.dataset.hour=hour;

        // show saved events
        if(weekRateData[iso]){
          weekRateData[iso].forEach(r=>{
            const span = document.createElement('span');
            span.className='week-event';
            span.textContent=`${r.type}: ₹${r.rate}`;
            td.appendChild(span);
          });
        }

        // click modal
        td.onclick = ()=>{
          weekSelectedKey = iso;
          weekModalTitle.textContent = `GOLD RATE CALENDAR (${iso.split('-').reverse().join('-')})`;
          weekRateContainer.innerHTML='';
          (weekRateData[iso]||[{}]).forEach(r=>weekRateContainer.appendChild(createWeekRowInput(r)));
          weekModal.classList.remove('hidden');
          weekModal.classList.add('flex');
        };

        tr.appendChild(td);
      });

      weekTbody.appendChild(tr);
    }
  }

  renderWeekTable();
</script>

@endsection