<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveReportController extends Controller
{
    public function generatePDF()
    {
        $employees = Employee::with(['leaveRequests' => function($q) {
            $q->latest();
        }, 'leaveRequests.leaveType'])->get();

        $data = $employees->map(function ($employee) {
            $lastLeave = $employee->leaveRequests->first();
            return [
                'name' => $employee->name,
                'employee_number' => $employee->employee_number,
                'mobile' => $employee->mobile,
                'total_requests' => $employee->leaveRequests->count(),
                'last_leave_date' => $lastLeave?->from_date ?? '—',
                'last_leave_type' => $lastLeave?->leaveType?->name ?? '—',
            ];
        });

        $pdf = Pdf::loadView('reports.leave_report', ['data' => $data]);
        return $pdf->download('leave-summary.pdf');
    }
}


