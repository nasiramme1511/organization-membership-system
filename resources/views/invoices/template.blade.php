<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        .header { text-align: center; margin-bottom: 40px; }
        .header h1 { color: #2563eb; margin: 0; }
        .info { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .info div { width: 45%; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f3f4f6; }
        .total { font-size: 18px; font-weight: bold; text-align: right; padding: 20px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>#{{ $payment->id }}</p>
    </div>
    
    <div class="info">
        <div>
            <strong>From:</strong><br>
            {{ $organization?->name ?? 'Organization Name' }}<br>
            {{ $organization?->email ?? 'email@example.com' }}<br>
            {{ $organization?->phone ?? '+251-000-000000' }}
        </div>
        <div style="text-align: right;">
            <strong>Bill To:</strong><br>
            {{ $user->name }}<br>
            {{ $user->email }}<br>
            {{ $user->phone ?? 'N/A' }}
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Membership Payment</td>
                <td>ETB {{ number_format($payment->amount, 2) }}</td>
            </tr>
            <tr>
                <td>Method</td>
                <td>{{ ucfirst($payment->method) }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>{{ ucfirst($payment->status) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="total">
        Total: ETB {{ number_format($payment->amount, 2) }}
    </div>
    
    <div class="footer">
        <p>Payment Date: {{ $payment->paid_at?->format('Y-m-d') ?? 'Pending' }}</p>
        <p>Generated: {{ $generated_at }}</p>
    </div>
</body>
</html>