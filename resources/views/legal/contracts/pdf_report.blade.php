<!DOCTYPE html>
<html>

<head>
    <title>Contracts Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0 0;
            color: #666;
        }

        .status-badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Contracts Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Contract Title</th>
                <th>Details</th>
                <th>Counterparty</th>
                <th>Type</th>
                <th>Status</th>
                <th>Effective Date</th>
                <th>Expiration Date</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
                <tr>
                    <td>{{ $contract->title }}</td>
                    <td>Ref: {{ $contract->contract_number }}<br>Owner: {{ $contract->owner->name ?? 'N/A' }}</td>
                    <td>{{ $contract->counterparty_name }}</td>
                    <td>{{ $contract->type }}</td>
                    <td>
                        <span class="status-badge">{{ $contract->status }}</span>
                    </td>
                    <td>{{ $contract->effective_date ? $contract->effective_date->format('M d, Y') : '-' }}</td>
                    <td>{{ $contract->expiration_date ? $contract->expiration_date->format('M d, Y') : '-' }}</td>
                    <td>{{ $contract->contract_value ? number_format($contract->contract_value, 2) : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>