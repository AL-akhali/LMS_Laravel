<div class="max-w-6xl mx-auto my-10 p-10 bg-white/60 backdrop-blur-lg rounded-3xl shadow-2xl space-y-10">

    <!-- رسالة النجاح -->
    @if (session()->has('success'))
        <div class="bg-green-200 text-green-800 border border-green-400 px-6 py-3 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <!-- العنوان -->
    <h2 class="text-4xl font-extrabold text-red-600 text-center shadow-sm">
        {{ $employee_id ? 'تعديل الموظف' : 'إضافة موظف جديد' }}
    </h2>

    <!-- نموذج الموظف -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <label class="block text-lg font-semibold text-gray-700">اسم الموظف</label>
            <input type="text" wire:model="employee_name" class="mt-2 w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-pink-400 transition" placeholder="اسم الموظف">
            @error('employee_name') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold text-gray-700">الرقم الوظيفي</label>
            <input type="text" wire:model="employee_number" class="mt-2 w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-yellow-400 transition" placeholder="الرقم الوظيفي">
            @error('employee_number') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-lg font-semibold text-gray-700">رقم الجوال</label>
            <input type="text" wire:model="mobile" class="mt-2 w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-blue-400 transition" placeholder="رقم الجوال">
        </div>

        <div>
            <label class="block text-lg font-semibold text-gray-700">العنوان</label>
            <input type="text" wire:model="address" class="mt-2 w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-green-400 transition" placeholder="العنوان">
        </div>

        <div class="md:col-span-2">
            <label class="block text-lg font-semibold text-gray-700">الملاحظات</label>
            <textarea wire:model="notes" rows="4" class="mt-2 w-full px-5 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-purple-400 transition" placeholder="الملاحظات"></textarea>
        </div>
    </div>

    <!-- الأزرار -->
    <div class="flex flex-wrap justify-center gap-6 mt-6">
        <button wire:click="save"
            class="bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 hover:from-red-500 hover:to-yellow-400 text-white font-bold px-10 py-3 rounded-full shadow-lg transition transform hover:scale-105 duration-300">
            {{ $employee_id ? 'تحديث' : 'حفظ' }}
        </button>

        @if($employee_id)
        <button wire:click="resetForm"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-10 py-3 rounded-full transition duration-200 shadow">
            إلغاء
        </button>
        @endif
    </div>

    <!-- الجدول -->
    <div class="bg-white/70 rounded-xl shadow-lg overflow-x-auto mt-10">
        <table class="w-full text-sm text-center">
            <thead class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
                <tr>
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">الاسم</th>
                    <th class="py-3 px-4">الرقم الوظيفي</th>
                    <th class="py-3 px-4">الجوال</th>
                    <th class="py-3 px-4">العنوان</th>
                    <th class="py-3 px-4">الملاحظات</th>
                    <th class="py-3 px-4">الخيارات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $index => $emp)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="py-2">{{ $index + 1 }}</td>
                        <td>{{ $emp->employee_name }}</td>
                        <td>{{ $emp->employee_number }}</td>
                        <td>{{ $emp->mobile }}</td>
                        <td>{{ $emp->address }}</td>
                        <td>{{ $emp->notes }}</td>
                        <td class="flex justify-center gap-2 py-2">
                            <button wire:click="edit({{ $emp->id }})" class="text-indigo-600 hover:text-indigo-800 font-semibold">تعديل</button>
                            <button wire:click="delete({{ $emp->id }})" onclick="return confirm('هل أنت متأكد من الحذف؟')" class="text-red-600 hover:text-red-800 font-semibold">حذف</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 text-gray-500">لا توجد بيانات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
