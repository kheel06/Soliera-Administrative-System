<!DOCTYPE html>
<html>

<head>
    <title>Permits Report</title>
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
        <h1>Compliance Permits Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Permit Name</th>
                <th>Issuing Authority</th>
                <th>Status</th>
                <th>Expiration Date</th>
                <th>Days Left</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permits as $permit)
                @php
                    $daysLeft = $permit->expiration_date ? now()->diffInDays($permit->expiration_date, false) : null;
                @endphp
                <tr>
                    <td>{{ $permit->name }}</td>
                    <td>{{ $permit->issuing_authority }}</td>
                    <td>{{ $permit->status }}</td>
                    <td>{{ $permit->expiration_date ? $permit->expiration_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $daysLeft !== null ? $daysLeft . ' days' : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>