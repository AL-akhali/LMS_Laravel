<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            direction: rtl;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">تقرير ملخص الإجازات</h2>

    <table>
        <thead>
            <tr>
                <th>اسم الموظف</th>
                <th>رقم الموظف</th>
                <th>الجوال</th>
                <th>عدد طلبات الإجازة</th>
                <th>تاريخ آخر إجازة</th>
                <th>نوع آخر إجازة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['employee_number'] }}</td>
                    <td>{{ $item['mobile'] }}</td>
                    <td>{{ $item['total_requests'] }}</td>
                    <td>{{ $item['last_leave_date'] }}</td>
                    <td>{{ $item['last_leave_type'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
