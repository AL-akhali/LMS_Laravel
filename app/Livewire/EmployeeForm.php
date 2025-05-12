<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class EmployeeForm extends Component
{
    public $employee_id = null;
    public $employee_name, $employee_number, $mobile, $address, $notes;
    public $employees;

    public function mount()
    {
        $this->loadEmployees();
    }

    public function loadEmployees()
    {
        $this->employees = Employee::latest()->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'employee_name' => 'required|string|max:255',
            'employee_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees', 'employee_number')->ignore($this->employee_id),
            ],
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($this->employee_id) {
            Employee::findOrFail($this->employee_id)->update($validated);
            session()->flash('success', 'تم تحديث الموظف بنجاح.');
        } else {
            Employee::create($validated);
            session()->flash('success', 'تم إضافة الموظف بنجاح.');
        }

        $this->resetForm();
        $this->loadEmployees();
    }

    public function edit($id)
    {
        $emp = Employee::findOrFail($id);
        $this->employee_id = $emp->id;
        $this->employee_name = $emp->employee_name;
        $this->employee_number = $emp->employee_number;
        $this->mobile = $emp->mobile;
        $this->address = $emp->address;
        $this->notes = $emp->notes;
    }

    public function delete($id)
    {
        Employee::findOrFail($id)->delete();
        session()->flash('success', 'تم حذف الموظف بنجاح.');
        $this->loadEmployees();
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'employee_name', 'employee_number', 'mobile', 'address', 'notes']);
    }

    public function render()
    {
        return view('livewire.employee-form');
    }
}
