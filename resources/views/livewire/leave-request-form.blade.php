<div class="space-y-6">
    {{-- إشعار النجاح --}}
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- نموذج إدخال طلب الإجازة --}}
    <form wire:submit.prevent="submit">
        <x-filament::card>
            <x-slot name="header">
                <span class="text-blue-800 font-bold text-lg">إضافة طلب إجازة جديد</span>
            </x-slot>

            <div class="space-y-4">
                <!-- اختيار الموظف -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">اسم الموظف</label>
                    <select wire:model.defer="employee_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                        <option value="">-- اختر الموظف --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->employee_name }}</option>
                        @endforeach
                    </select>
                    @error('employee_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- اختيار نوع الإجازة -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">نوع الإجازة</label>
                    <select wire:model.defer="leave_type_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                        <option value="">-- اختر نوع الإجازة --</option>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->leave_type_name }}</option>
                        @endforeach
                    </select>
                    @error('leave_type_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- حقل السبب -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">السبب</label>
                    <textarea wire:model.defer="reason" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required></textarea>
                    @error('reason') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- من تاريخ -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">من تاريخ</label>
                    <input type="date" wire:model.defer="from_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                    @error('from_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- إلى تاريخ -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">إلى تاريخ</label>
                    <input type="date" wire:model.defer="to_date" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50" required>
                    @error('to_date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- ملاحظات -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">الملاحظات</label>
                    <textarea wire:model.defer="notes" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"></textarea>
                    @error('notes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- زر إرسال الطلب -->
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">إرسال الطلب</button>
            </div>
        </x-filament::card>
    </form>

    <a href="{{ route('leave.report.pdf') }}"
   target="_blank"
   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
    </svg>
    تحميل تقرير الإجازات PDF
</a>

    {{-- عرض الطلبات السابقة --}}
    <hr class="my-8">
    <h3 class="text-lg font-semibold mb-4 text-blue-700">طلباتي السابقة</h3>

    @foreach($leaveRequests as $req)
        <div class="p-4 mb-3 rounded-lg border border-gray-200 shadow-sm flex justify-between items-center">
            <div>
                <p><strong class="font-medium">نوع الإجازة:</strong> {{ $req->leaveType->leave_type_name }}</p>
                <p><strong class="font-medium">الفترة:</strong> {{ $req->from_date }} إلى {{ $req->to_date }}</p>
                <p><strong class="font-medium">السبب:</strong> {{ $req->reason }}</p>
            </div>
            <div class="flex gap-2">
                <!-- زر تعديل -->
                <button wire:click="edit({{ $req->id }})" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all duration-200">تعديل</button>

                <!-- زر حذف -->
                <button wire:click="delete({{ $req->id }})" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200">حذف</button>
            </div>
        </div>
    @endforeach
</div>
