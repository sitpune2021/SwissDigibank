<?php

namespace App\Http\Controllers;

use App\Models\EmployeeAttendence;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class EmployeeAttendenceController extends Controller
{

public function index(Request $request)
{
    // Get selected date from GET, default to today
    $selectedDate = $request->query('date', now()->format('d-m-Y'));

    // Convert to Y-m-d for DB
    try {
        $dbDate = Carbon::createFromFormat('d-m-Y', $selectedDate)->format('Y-m-d');
    } catch (\Exception $e) {
        $dbDate = now()->format('Y-m-d');
        $selectedDate = now()->format('d-m-Y');
    }

    // Fetch all employees
    $employees = Employee::all();

    // Fetch attendance for the selected date
    $attendances = EmployeeAttendence::where('attendance_date', $dbDate)
                        ->get()
                        ->keyBy('employee_id');

    return view('hr-management.attendance.index', compact('employees', 'attendances', 'selectedDate'));
}
    public function store(Request $request)
    {
        // 🔍 Log full incoming request
        Log::info('Attendance Store Request', $request->all());

     

            $request->validate([
                'employee_id' => 'required|integer',
                'attendance_date' => 'required',
                'status' => 'required',
                'in_hour' => 'required',
                'in_minute' => 'required',
                'out_hour' => 'required',
                'out_minute' => 'required',
            ]);

            Log::info('Attendance validation passed', [
                'employee_id' => $request->employee_id
            ]);

            $attendance_date = Carbon::parse(
                str_replace('-', '-', $request->attendance_date)
            )->format('Y-m-d');

            Log::info('Parsed attendance date', [
                'attendance_date' => $attendance_date
            ]);

            $in_time = $request->in_hour . ':' . $request->in_minute . ':00';
            $out_time = $request->out_hour . ':' . $request->out_minute . ':00';

            Log::info('Attendance times', [
                'in_time' => $in_time,
                'out_time' => $out_time
            ]);

            $working_minutes = max(
                0,
                (strtotime($out_time) - strtotime($in_time)) / 60
            );

            Log::info('Working minutes calculated', [
                'working_minutes' => $working_minutes
            ]);

            $attendance = EmployeeAttendence::updateOrCreate(
                [
                    'employee_id' => $request->employee_id,
                    'attendance_date' => $attendance_date
                ],
                [
                    'in_time' => $in_time,
                    'out_time' => $out_time,
                    'working_minutes' => $working_minutes,
                    'status' => $request->status,
                    'created_by' => auth()->id()
                ]
            );

            Log::info('Attendance saved successfully', [
                'attendance_id' => $attendance->id
            ]);

            return back()->with('success', 'Attendance updated successfully');

        // } catch (\Exception $e) {

        //     // ❌ Log exact error
        //     Log::error('Attendance save failed', [
        //         'message' => $e->getMessage(),
        //         'file' => $e->getFile(),
        //         'line' => $e->getLine(),
        //     ]);

        //     return back()->with('error', 'Attendance save failed');
        // }
    }

    public function calendar($encodedId){
         $employeeId = base64_decode($encodedId);
           $employee = Employee::findOrFail($employeeId);
        $attendances = EmployeeAttendence::where('employee_id', $employee->id)
        ->orderBy('attendance_date')
        ->get();

    $attendanceData = [];
    foreach ($attendances as $att) {
        $dateKey = Carbon::parse($att->attendance_date)->format('Y-m-d');
        $attendanceData[$dateKey] = [
            ['text' => 'In Time - ' . ($att->in_time ?? '-'), 'cls' => 'in-time'],
            ['text' => 'Out Time - ' . ($att->out_time ?? '-'), 'cls' => 'out-time'],
            ['text' => 'Status - ' . ($att->status ?? 'Absent'), 'cls' => 'status'],
            ['text' => 'Working - ' . ($att->working_minutes
                        ? floor($att->working_minutes / 60) . ' h ' . ($att->working_minutes % 60) . ' min'
                        : '0 h 0 min'), 'cls' => 'working'],
        ];
    }

    return view('hr-management.attendance.calender', compact('employee', 'attendanceData'));

    }

}
