<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Billing Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #2f855a;
            padding-bottom: 10px;
        }

        .report-title {
            font-size: 22px;
            font-weight: bold;
            color: #22543d;
            margin: 0;
        }

        .report-date {
            font-size: 13px;
            color: #718096;
        }

        /* Stats Table for Financials */
        .summary-table {
            width: 100%;
            margin-bottom: 20px;
            border-spacing: 10px;
            border-collapse: separate;
        }

        .summary-card {
            background: #f0fff4;
            border: 1px solid #c6f6d5;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            width: 33%;
        }

        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            color: #2f855a;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #22543d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #2f855a;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .status-paid {
            color: #2f855a;
            font-weight: bold;
        }

        .status-pending {
            color: #c05621;
            font-weight: bold;
        }

        .amount {
            font-family: 'Courier', monospace;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
            padding-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="report-title">Financial Billing Report</h1>
        <p class="report-date">Period: {{ \Carbon\Carbon::parse($start)->format('M d, Y') }} -
            {{ \Carbon\Carbon::parse($end)->format('M d, Y') }}</p>
    </div>

    <table class="summary-table">
        <tr>
            <td class="summary-card">
                <div class="summary-label">Total Billed</div>
                <div class="summary-value">${{ number_format($data->sum('total_amount'), 2) }}</div>
            </td>
            <td class="summary-card" style="background: #ebf8ff; border-color: #bee3f8;">
                <div class="summary-label" style="color: #2b6cb0;">Total Paid</div>
                <div class="summary-value" style="color: #2b6cb0;">
                    ${{ number_format($data->where('payment_status', 'paid')->sum('total_amount'), 2) }}</div>
            </td>
            <td class="summary-card" style="background: #fffaf0; border-color: #feebc8;">
                <div class="summary-label" style="color: #c05621;">Outstanding</div>
                <div class="summary-value" style="color: #c05621;">
                    ${{ number_format($data->where('payment_status', 'pending')->sum('total_amount'), 2) }}</div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Patient Name</th>
                <th>Status</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $invoice)
                <tr>
                    <td>INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td>{{ $invoice->consultation?->appointment?->patient?->name ?? 'N/A' }}</td>
                    <td class="status-{{ $invoice->payment_status }}">{{ ucfirst($invoice->payment_status) }}</td>
                    <td class="amount">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #edf2f7;">
                <td colspan="4" style="text-align: right; font-weight: bold; padding: 10px;">GRAND TOTAL:</td>
                <td class="amount" style="font-size: 12px; border-bottom: 3px double #333;">
                    ${{ number_format($data->sum('total_amount'), 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Confidential Financial Record - Printed on {{ now()->format('F j, Y, g:i a') }}
    </div>
</body>

</html>
