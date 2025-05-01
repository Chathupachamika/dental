<!DOCTYPE html>
<html>
<head>
    <title>Dental Analytics Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dental Analytics Report</h1>
        <p>Generated on: {{ now()->format('d M, Y') }}</p>
    </div>

    <!-- Add your report sections here based on the data passed from the controller -->
</body>
</html>
