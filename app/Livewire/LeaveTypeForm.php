<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LeaveType;

class LeaveTypeForm extends Component
{
    public string $leave_type_name = '';

    public function submit()
    {
        $this->validate([
            'leave_type_name' => 'required|string|max:255',
        ]);

        LeaveType::create([
            'leave_type_name' => $this->leave_type_name,
        ]);

        $this->reset('leave_type_name');
        session()->flash('success', 'Leave type added successfully!');
    }

    public function delete($id)
    {
        LeaveType::findOrFail($id)->delete();
        session()->flash('success', 'تم حذف نوع الإجازة بنجاح!');
    }

    public function render()
    {
        return view('livewire.leave-type-form', [
            'leaveTypes' => LeaveType::latest()->get(),
        ]);
    }
}

