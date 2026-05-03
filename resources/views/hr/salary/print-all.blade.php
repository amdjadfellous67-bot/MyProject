<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslips - {{ \Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; color: #1E293B; }
        .payslip {
            max-width: 800px;
            margin: 0 auto 40px;
            padding: 30px;
            border: 2px solid #1E3A5F;
            page-break-after: always;
        }
        .payslip:last-child { page-break-after: auto; }
        .header { text-align: center; border-bottom: 3px solid #D4AF37; padding-bottom: 20px; margin-bottom: 25px; }
        .header h1 { color: #D4AF37; font-size: 2rem; margin-bottom: 8px; }
        .header p { color: #64748B; font-size: 1rem; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 25px; }
        .info-section h4 { color: #D4AF37; margin-bottom: 12px; font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-section p { margin-bottom: 6px; font-size: 0.9rem; }
        .info-section strong { color: #1E3A5F; min-width: 100px; display: inline-block; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th { background: #1E3A5F; color: white; padding: 12px; text-align: left; font-size: 0.85rem; }
        table td { padding: 12px; border-bottom: 1px solid #E2E8F0; font-size: 0.9rem; }
        table tfoot td { font-weight: 700; border-top: 2px solid #1E3A5F; }
        .total-box {
            background: #D4AF37; color: #1E3A5F; padding: 20px; text-align: center; border-radius: 8px;
        }
        .total-box h3 { margin-bottom: 8px; font-size: 1rem; }
        .total-box h1 { font-size: 2.2rem; }
        .footer { margin-top: 20px; text-align: center; font-size: 0.75rem; color: #64748B; }
        @media print {
            body { background: white; }
            .payslip { border-color: #ccc; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; padding: 20px; background: #0F172A; color: white;">
        <button onclick="window.print()" style="padding: 12px 30px; background: #D4AF37; color: #1E3A5F; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer;">Print All Payslips</button>
        <a href="javascript:window.close()" style="padding: 12px 30px; background: transparent; color: white; border: 2px solid white; border-radius: 8px; font-size: 1rem; cursor: pointer; margin-left: 10px; display: inline-block; text-decoration: none;">Close</a>
    </div>

    @forelse($salaries as $salary)
    <div class="payslip">
        <div class="header">
            <h1>PAYSLIP</h1>
            <p>{{ \Carbon\Carbon::createFromDate($year, $month)->format('F Y') }}</p>
        </div>

        <div class="info-grid">
            <div class="info-section">
                <h4>Employee Details</h4>
                <p><strong>ID:</strong> {{ $salary->employee->matricule }}</p>
                <p><strong>Name:</strong> {{ $salary->employee->name }} {{ $salary->employee->surname }}</p>
                <p><strong>Department:</strong> {{ $salary->employee->department->name ?? 'N/A' }}</p>
                <p><strong>Position:</strong> {{ $salary->employee->position->title ?? 'N/A' }}</p>
            </div>
            <div class="info-section">
                <h4>Payment Details</h4>
                <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                <p><strong>Bank:</strong> BNA</p>
            </div>
        </div>

        <table>
            <thead>
                <tr><th>Earnings</th><th style="text-align: right;">Amount (DA)</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Base Salary</td>
                    <td style="text-align: right;">{{ number_format($salary->gross_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Seniority Bonus</td>
                    <td style="text-align: right;">{{ number_format($salary->bonus_seniority, 2) }}</td>
                </tr>
                <tr>
                    <td>Performance Bonus</td>
                    <td style="text-align: right;">{{ number_format($salary->bonus_performance, 2) }}</td>
                </tr>
                <tr>
                    <td>Attendance Bonus</td>
                    <td style="text-align: right;">{{ number_format($salary->bonus_attendance, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Gross Salary</td>
                    <td style="text-align: right;">{{ number_format($salary->gross_salary + $salary->bonus_seniority + $salary->bonus_performance + $salary->bonus_attendance, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <table>
            <thead>
                <tr><th>Deductions</th><th style="text-align: right;">Amount (DA)</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>CNSS (Social Security)</td>
                    <td style="text-align: right;">{{ number_format($salary->deduction_cnss, 2) }}</td>
                </tr>
                <tr>
                    <td>Advance Deductions</td>
                    <td style="text-align: right;">{{ number_format($salary->deduction_advances, 2) }}</td>
                </tr>
                <tr>
                    <td>Absence Deductions</td>
                    <td style="text-align: right;">{{ number_format($salary->deduction_absences, 2) }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total Deductions</td>
                    <td style="text-align: right;">{{ number_format($salary->deduction_cnss + $salary->deduction_advances + $salary->deduction_absences, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="total-box">
            <h3>NET SALARY</h3>
            <h1>{{ number_format($salary->net_salary, 2) }} DA</h1>
        </div>

        <div class="footer">
            <p>This is an automatically generated payslip. For any questions, contact HR department.</p>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 40px; color: #64748B;">
        <h2>No payslips found for this period.</h2>
        <p>Process payroll first to generate payslips.</p>
    </div>
    @endforelse
</body>
</html>
