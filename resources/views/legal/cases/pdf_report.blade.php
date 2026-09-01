<!DOCTYPE html>
<html>

<head>
    <title>Cases Report</title>
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
        <h1>Cases & Disputes Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Case Title</th>
                <th>Case Number</th>
                <th>Type</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Filing Date</th>
                <th>Court Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cases as $case)
                <tr>
                    <td>{{ $case->case_title }}</td>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ ucfirst($case->case_type) }}</td>
                    <td>{{ ucfirst($case->status) }}</td>
                    <td>{{ ucfirst($case->priority) }}</td>
                    <td>{{ $case->filing_date ? \Carbon\Carbon::parse($case->filing_date)->format('M d, Y') : '-' }}</td>
                    <td>{{ $case->court_date ? \Carbon\Carbon::parse($case->court_date)->format('M d, Y') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>