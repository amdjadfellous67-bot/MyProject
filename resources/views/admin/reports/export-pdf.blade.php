<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>HR Report - {{ $month }}/{{ $year }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1E3A5F; padding-bottom: 20px; }
        .header h1 { color: #1E3A5F; font-size: 24px; margin-bottom: 8px; }
        .header p { color: #666; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #1E3A5F; color: white; font-weight: bold; }
        tr:nth-child(even) { background: #f9f9f9; }
        .totals { margin-top: 20px; padding: 20px; background: #f5f5f5; border-radius: 8px; }
        .totals h3 { color: #1E3A5F; margin-bottom: 10px; }
        .totals p { font-size: 18px; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HR Management Report</h1>
        <p>Period: {{ Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</p>
        <p>Generated: {{ Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    </div>

    <h3 style="margin-bottom: 15px; color: #1E3A5F;">Employee Salary Report</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Position</th>
                <th>Base Salary</th>
                <th>Gross</th>
                <th>Net</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
            @php $salary = $salaries->firstWhere('employee_id', $emp->id); @endphp
            <tr>
                <td>{{ $emp->matricule }}</td>
                <td>{{ $emp->first_name }} {{ $emp->last_name }}</td>
                <td>{{ $emp->department->name ?? '-' }}</td>
                <td>{{ $emp->position->title ?? '-' }}</td>
                <td>{{ number_format($emp->base_salary, 2) }}</td>
                <td>{{ $salary ? number_format($salary->gross_salary, 2) : '0.00' }}</td>
                <td>{{ $salary ? number_format($salary->net_salary, 2) : '0.00' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <h3>Summary</h3>
        <p>Total Employees: {{ $employees->count() }}</p>
        <p>Total Gross Salary: {{ number_format($totalGross, 2) }} DA</p>
        <p>Total Net Salary: {{ number_format($totalNet, 2) }} DA</p>
    </div>

    <div class="footer">
        <p>HRFlow - HR Management System</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>