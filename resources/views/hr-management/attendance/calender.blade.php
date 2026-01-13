@extends('layout.main')

@section('content')
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */

    .calendar-header {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 20px;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.calendar-header button {
  background: none;
  border: none;
  font-size: 22px;
  cursor: pointer;
}

.calendar-scroll {
  height: 520px;
  overflow-y: auto;
}
.calendar {
  width: 100%;
  max-width: 1000px;
  margin: auto;
  font-family: Arial, sans-serif;
  border: 1px solid #ddd;
}

/* header */
.calendar-header {
  text-align: center;
  padding: 10px;
  font-size: 18px;
  border-bottom: 1px solid #ddd;
}

/* day names fixed */
.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  background: #f5f5f5;
  position: sticky;
  top: 0;
  z-index: 2;
}

.calendar-days div {
  text-align: center;
  padding: 8px 0;
  font-weight: bold;
  border-right: 1px solid #ddd;
}

/* scroll container */
.calendar-scroll {
  height: 500px;              /* 👈 control scroll height */
  overflow-y: auto;
}

/* calendar grid */
.calendar-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}

/* day cell */
.day {
  min-height: 140px;
  border: 1px solid #eee;
  padding: 6px;
  box-sizing: border-box;
}

.day.other-month {
  background: #fafafa;
  color: #aaa;
}

.date {
  font-weight: bold;
  margin-bottom: 5px;
}

/* events */
.event {
  font-size: 11px;
  padding: 3px 6px;
  margin-bottom: 4px;
  border-radius: 4px;
}

.in-time { background: #00ff00; }
.out-time { background: #ff1300; color: #fff; }
.status { background: #0000ff; color: #fff; }
.working { background: #ffff00; }

</style>
<div class="main-inner p-4">

   <div class="flex items-center justify-between">
     <h3 class="text-lg uppercase font-semibold mb-4">
        ATTENDANCE CALENDAR - {{ $employee->name }}
    </h3>
    <a href="{{ route('hr-management.attendance.index') }}"
       class="btn-primary uppercase">
        Back
    </a>
   </div>

    <div class="box mt-5 calenders">
        <div class="calendar border rounded-lg overflow-hidden">

            <!-- Month Header -->
            <div class="calendar-header flex justify-center items-center gap-4 p-2 border-b">
                <button id="prevMonth" class="text-xl">❮</button>
                <h2 id="monthYear" class="text-lg font-semibold"></h2>
                <button id="nextMonth" class="text-xl">❯</button>
            </div>

            <!-- Days of Week -->
            <div class="calendar-days grid grid-cols-7 bg-gray-100 font-bold text-center border-b">
                <div>Sun</div><div>Mon</div><div>Tue</div>
                <div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-scroll h-[500px] overflow-y-auto">
                <div class="calendar-grid grid grid-cols-7" id="calendarGrid"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Attendance data from Laravel
const attendance = @json($attendanceData);

const grid = document.getElementById("calendarGrid");
const monthYear = document.getElementById("monthYear");
const prevBtn = document.getElementById("prevMonth");
const nextBtn = document.getElementById("nextMonth");

let current = new Date(); // Start with current month

function renderCalendar() {
    grid.innerHTML = "";

    const y = current.getFullYear();
    const m = current.getMonth();

    monthYear.textContent = current.toLocaleDateString("en-US", { month: "long", year: "numeric" });

    const firstDay = new Date(y, m, 1).getDay();
    const daysInMonth = new Date(y, m + 1, 0).getDate();
    const prevMonthDays = new Date(y, m, 0).getDate();

    // Previous month fillers
    for (let i = firstDay - 1; i >= 0; i--) {
        grid.appendChild(createDay(prevMonthDays - i, true));
    }

    // Current month days
    for (let d = 1; d <= daysInMonth; d++) {
        const key = `${y}-${String(m + 1).padStart(2,"0")}-${String(d).padStart(2,"0")}`;
        grid.appendChild(createDay(d, false, key));
    }

    document.querySelector(".calendar-scroll").scrollTop = 0;
}

function createDay(day, otherMonth = false, key = null) {
    const el = document.createElement("div");
    el.className = "day border p-2 min-h-[120px]" + (otherMonth ? " bg-gray-50 text-gray-400" : "");
    el.innerHTML = `<div class="date font-bold mb-1">${day}</div>`;

    if (key && attendance[key]) {
        attendance[key].forEach(e => {
            const ev = document.createElement("div");
            ev.className = `event text-xs rounded px-1 py-0.5 my-0.5 ${e.cls}`;
            ev.textContent = e.text;
            el.appendChild(ev);
        });
    }

    return el;
}

prevBtn.onclick = () => { current.setMonth(current.getMonth() - 1); renderCalendar(); };
nextBtn.onclick = () => { current.setMonth(current.getMonth() + 1); renderCalendar(); };

renderCalendar();
</script>

<style>
.day.other-month { background: #fafafa; color: #aaa; }
.event.in-time { background: #10b981; color: #fff; }
.event.out-time { background: #ef4444; color: #fff; }
.event.status { background: #3b82f6; color: #fff; }
.event.working { background: #facc15; color: #000; }
</style>
@endsection
