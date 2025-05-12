<div class="space-y-4">

    {{-- إشعار النجاح --}}
    @if (session()->has('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- نموذج إدخال نوع الإجازة --}}
    <form wire:submit.prevent="submit">
        <x-filament::card>
            <x-slot name="header">
                <span class="text-blue-800 font-bold">إضافة نوع إجازة جديد</span>
            </x-slot>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-800 mb-1">اسم نوع الإجازة</label>
                    <input
                        type="text"
                        wire:model.defer="leave_type_name"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                >
                    حفظ
                </button>
            </div>
        </x-filament::card>
    </form>

    {{-- عرض الأنواع الموجودة --}}
    <x-filament::card>
        <x-slot name="header">
            <span class="text-gray-800 font-semibold">أنواع الإجازات</span>
        </x-slot>

        <ul class="space-y-2">
            @forelse ($leaveTypes as $type)
                <li class="flex items-center justify-between bg-gray-50 p-2 rounded-md">
                    <span class="text-gray-900 font-medium">{{ $type->leave_type_name }}</span>
                    <x-filament::button
                        color="danger"
                        size="sm"
                        wire:click="delete({{ $type->id }})"
                    >
                        حذف
                    </x-filament::button>
                </li>
            @empty
                <li class="text-gray-500">لا توجد أنواع إجازات بعد.</li>
            @endforelse
        </ul>
    </x-filament::card>

</div>
