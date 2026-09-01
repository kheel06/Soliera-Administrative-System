<!DOCTYPE html>
<html>

<head>
    <title>Vault Documents Report</title>
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
        <h1>Document Vault - Policy Approvals Report</h1>
        <p>Generated on {{ now()->format('F d, Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Document Title</th>
                <th>Type</th>
                <th>Status</th>
                <th>File Size</th>
                <th>Uploaded Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $doc)
                <tr>
                    <td>{{ $doc->title ?? $doc->document_name ?? 'Untitled' }}</td>
                    <td>{{ $doc->document_type ?? $doc->type ?? 'General' }}</td>
                    <td>{{ ucfirst($doc->status ?? 'Active') }}</td>
                    <td>{{ $doc->file_size ?? 'Unknown' }}</td>
                    <td>{{ $doc->created_at->format('M d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>