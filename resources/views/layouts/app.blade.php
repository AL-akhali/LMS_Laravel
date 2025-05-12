<!-- resources/views/components/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>لوحة الموظف</title>
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4">
        {{ $slot }} <!-- المحتوى الديناميكي سيظهر هنا -->
    </div>
    @livewireScripts
</body>
</html>
