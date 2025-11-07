@extends('layout.main')

@section('content')
{{-- Do Not Remove <Style>  --}}
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
    
    .calendar {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      width: 700px;
      overflow: hidden;
    }

    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 24px;
      border-bottom: 1px solid #ddd;
    }

    .calendar-header button {
      background: none;
      border: none;
      font-size: 20px;
      padding: 8px 12px;
      border-radius: 50%;
      cursor: pointer;
      transition: background 0.2s;
    }

    .calendar-header button:hover {
      background: #f1f1f1;
    }

    .calendar-header h2 {
      font-size: 18px;
      font-weight: 600;
      margin: 0;
      color: #333;
    }

    .calendar-header .subtext {
      font-size: 12px;
      color: #777;
    }

    .today-btn {
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 4px 10px;
      font-size: 13px;
      cursor: pointer;
      background: #fff;
      transition: background 0.2s;
    }

    .today-btn:hover {
      background: #f5f5f5;
    }

    .calendar-weekdays {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
      font-size: 12px;
      font-weight: bold;
      color: #555;
      padding: 10px 16px 0;
    }

    .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 8px;
      padding: 16px;
    }

    .day-cell {
      min-height: 70px;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      position: relative;
    }

    .day-number {
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      font-size: 14px;
      cursor: pointer;
      color: #333;
      transition: background 0.2s;
    }

    .day-number:hover {
      background: #e0f0ff;
    }

    .day-number.today {
      background: #3dba03;
      color: white;
      font-weight: bold;
    }

    .day-number.other {
      color: #bbb;
    }

    /* === Popup Styles === */
    .popup-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup {
      background: #fff;
      padding: 24px 32px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
      text-align: center;
      width: 300px;
      position: relative;
      animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 12px;
      font-size: 20px;
      color: #555;
      cursor: pointer;
    }

    .close-btn:hover {
      color: #000;
    }

    #popupDate {
      margin-top: 12px;
      font-size: 15px;
      color: #333;
    }
</style>

<div class="main-inner">

    <div class="mb-4 flex flex-wrap items-center justify-between gap-4 lg:mb-4">
        <div class="flex items-start flex-col gap-2">
            <h3 class="uppercase font-semibold text-xl">ATTENDANCE CALENDAR (Manoj)</h3>   
        </div>
    </div>
 
  <div class="calendar">
    <div class="calendar-header">
      <div>
        <button id="prevBtn" aria-label="Prev month">‹</button>
        <button id="nextBtn" aria-label="Next month">›</button>
      </div>

      <div style="text-align:center;">
        <h2 id="monthYear"></h2>
        <div class="subtext">Click a day to see date details</div>
      </div>

      <div>
        <button id="todayBtn" class="today-btn">Today</button>
      </div>
    </div>

    <div class="calendar-weekdays">
      <div>Sun</div>
      <div>Mon</div>
      <div>Tue</div>
      <div>Wed</div>
      <div>Thu</div>
      <div>Fri</div>
      <div>Sat</div>
    </div>

    <div id="calendarGrid" class="calendar-grid"></div>
  </div>

  <!-- Popup -->
  <div id="popupOverlay" class="popup-overlay">
    <div class="popup">
      <span id="closePopup" class="close-btn">&times;</span>
      <h3>Date Details</h3>
      <p id="popupDate"></p>
    </div>
  </div>

  <script>
    const monthYearEl = document.getElementById('monthYear');
    const calendarGrid = document.getElementById('calendarGrid');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const todayBtn = document.getElementById('todayBtn');

    // Popup elements
    const popupOverlay = document.getElementById("popupOverlay");
    const popupDate = document.getElementById("popupDate");
    const closePopup = document.getElementById("closePopup");

    let current = new Date();
    current = new Date(current.getFullYear(), current.getMonth(), 1);

    function renderCalendar(date) {
      const year = date.getFullYear();
      const month = date.getMonth();

      const firstDay = new Date(year, month, 1);
      const startDay = firstDay.getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const daysInPrevMonth = new Date(year, month, 0).getDate();

      monthYearEl.textContent = date.toLocaleString('default', { month: 'long', year: 'numeric' });
      calendarGrid.innerHTML = '';

      for (let i = 0; i < 42; i++) {
        const dayNumber = i - startDay + 1;
        const cell = document.createElement('div');
        cell.className = 'day-cell';
        const inner = document.createElement('div');
        inner.className = 'day-number';

        if (dayNumber <= 0) {
          // previous month
          inner.textContent = daysInPrevMonth + dayNumber;
          inner.classList.add('other');
          const d = new Date(year, month - 1, daysInPrevMonth + dayNumber);
          cell.dataset.date = d.toISOString().slice(0,10);
        } else if (dayNumber > daysInMonth) {
          // next month
          inner.textContent = dayNumber - daysInMonth;
          inner.classList.add('other');
          const d = new Date(year, month + 1, dayNumber - daysInMonth);
          cell.dataset.date = d.toISOString().slice(0,10);
        } else {
          inner.textContent = dayNumber;
          const d = new Date(year, month, dayNumber);
          cell.dataset.date = d.toISOString().slice(0,10);

          const today = new Date();
          if (today.getFullYear() === year && today.getMonth() === month && today.getDate() === dayNumber) {
            inner.classList.add('today');
          }
        }

        inner.addEventListener('click', () => {
          showPopup(cell.dataset.date);
        });

        cell.appendChild(inner);
        calendarGrid.appendChild(cell);
      }
    }

    // Popup show/hide functions
    function showPopup(dateText) {
      popupDate.textContent = "Selected Date: " + dateText;
      popupOverlay.style.display = "flex";
    }

    closePopup.addEventListener("click", () => {
      popupOverlay.style.display = "none";
    });

    popupOverlay.addEventListener("click", (e) => {
      if (e.target === popupOverlay) popupOverlay.style.display = "none";
    });

    // Calendar navigation
    prevBtn.addEventListener('click', () => {
      current = new Date(current.getFullYear(), current.getMonth() - 1, 1);
      renderCalendar(current);
    });

    nextBtn.addEventListener('click', () => {
      current = new Date(current.getFullYear(), current.getMonth() + 1, 1);
      renderCalendar(current);
    });

    todayBtn.addEventListener('click', () => {
      const now = new Date();
      current = new Date(now.getFullYear(), now.getMonth(), 1);
      renderCalendar(current);
    });

    renderCalendar(current);
  </script>
@endsection