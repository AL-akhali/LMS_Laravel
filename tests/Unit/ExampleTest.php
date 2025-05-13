<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use App\Livewire\LeaveRequestForm;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_prevent_overlapping_leave_requests()
    {
        // 1. إنشاء موظف ومستخدم
        $employee = Employee::create([
    'employee_name' => 'موظف رقم 1',
    'employee_number' => 'EMP001', // أو أي رقم مناسب
    // أضف أي أعمدة إلزامية أخرى حسب الحاجة
]);



        $user = User::create([
            'name' => 'مستخدم',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'employee_id' => $employee->id,
        ]);

$leaveType = LeaveType::create([
    'leave_type_name' => 'إجازة سنوية', // أي اسم مناسب
    // أضف أي أعمدة إلزامية أخرى حسب الحاجة
]);
        // 2. طلب إجازة سابق
        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'reason' => 'إجازة سابقة',
            'from_date' => '2025-05-10',
            'to_date' => '2025-05-15',
        ]);

        // 3. تسجيل الدخول
        $this->actingAs($user);

        // 4. توقع استثناء عند محاولة طلب جديد متداخل
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('لا يمكن تقديم طلب إجازة في نفس الفترة الزمنية.');

        Livewire::test(LeaveRequestForm::class)
            ->set('employee_id', $employee->id)
            ->set('leave_type_id', $leaveType->id)
            ->set('reason', 'إجازة متداخلة')
            ->set('from_date', '2025-05-14')
            ->set('to_date', '2025-05-20')
            ->call('submit');
    }
}
