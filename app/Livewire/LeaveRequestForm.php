<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\Employee;
use App\Models\LeaveType;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestForm extends Component
{
    public $employee_id, $leave_type_id, $reason, $from_date, $to_date, $notes;
    public $leaveRequests = [];
    public $editingId = null;

    public function mount()
    {
        $this->loadRequests();
    }

    public function loadRequests()
    {
        // تحميل الطلبات الخاصة بالموظف
        $this->leaveRequests = LeaveRequest::where('employee_id', Auth::user()->employee_id)->latest()->get();
    }

    public function submit()
    {
        // قواعد التحقق
        $this->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'reason' => 'required|string',
            'from_date' => 'required|date|before:to_date', // التحقق من تاريخ البداية قبل تاريخ النهاية
            'to_date' => 'required|date|after:from_date', // التحقق من تاريخ النهاية بعد تاريخ البداية
            'notes' => 'nullable|string',
        ]);

        // التحقق من تداخل الإجازات
        $this->checkForConflictingLeaves();

        if ($this->editingId) {
            // إذا كان التعديل
            $request = LeaveRequest::findOrFail($this->editingId);
            $this->authorizeEdit($request);

            $request->update([
                'employee_id' => $this->employee_id,
                'leave_type_id' => $this->leave_type_id,
                'reason' => $this->reason,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'تم تحديث الطلب بنجاح.');
        } else {
            // إذا كان الطلب جديد
            LeaveRequest::create([
                'employee_id' => $this->employee_id,
                'leave_type_id' => $this->leave_type_id,
                'reason' => $this->reason,
                'from_date' => $this->from_date,
                'to_date' => $this->to_date,
                'notes' => $this->notes,
            ]);
            session()->flash('success', 'تم إرسال الطلب بنجاح.');
        }

        $this->reset(['leave_type_id', 'reason', 'from_date', 'to_date', 'notes', 'editingId']);
        $this->loadRequests();
    }

    // التحقق من تداخل الإجازات
    public function checkForConflictingLeaves()
    {
        $existingLeaves = LeaveRequest::where('employee_id', $this->employee_id)
            ->where(function ($query) {
                $query->whereBetween('from_date', [$this->from_date, $this->to_date])
                    ->orWhereBetween('to_date', [$this->from_date, $this->to_date])
                    ->orWhere(function ($query) {
                        $query->where('from_date', '<=', $this->from_date)
                            ->where('to_date', '>=', $this->to_date);
                    });
            })
            ->exists();

        if ($existingLeaves) {
            throw new \Exception('لا يمكن تقديم طلب إجازة في نفس الفترة الزمنية.');
        }
    }

    public function edit($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $this->authorizeEdit($request);

        $this->editingId = $request->id;
        $this->leave_type_id = $request->leave_type_id;
        $this->reason = $request->reason;
        $this->from_date = $request->from_date;
        $this->to_date = $request->to_date;
        $this->notes = $request->notes;
    }

    public function delete($id)
    {
        $request = LeaveRequest::findOrFail($id);
        $this->authorizeEdit($request);
        $request->delete();

        session()->flash('success', 'تم حذف الطلب.');
        $this->loadRequests();
    }

    private function authorizeEdit($request)
    {
        if ($request->employee_id != Auth::user()->employee_id) {
            abort(403);
        }
    }

    public function render()
    {
        return view('livewire.leave-request-form', [
            'leaveTypes' => LeaveType::all(),
            'employees' => Employee::all(), // إذا كنت بحاجة لقائمة الموظفين في الواجهة الإدارية
        ])->layout('layouts.app');
    }
}
    
