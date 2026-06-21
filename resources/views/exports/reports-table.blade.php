<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Partimeku</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Data Platform Partimeku</h2>
    <p>Tanggal Laporan: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Lowongan</th>
                <th>Penyedia</th>
                <th>Kategori</th>
                <th>Total Pelamar</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobs as $index => $job)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $job['title'] }}</td>
                <td>{{ $job['provider_name'] }}</td>
                <td>{{ $job['category'] }}</td>
                <td>{{ $job['applicants_count'] }}</td>
                <td>{{ ucfirst($job['status']) }}</td>
                <td>{{ $job['created_at'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
