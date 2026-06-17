<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Lowongan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Data Lowongan Pekerjaan</h2>
    <p>Tanggal Export: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Lowongan</th>
                <th>Kategori</th>
                <th>Penyedia</th>
                <th>Gaji</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowongans as $index => $job)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $job->judul }}</td>
                <td>{{ $job->category }}</td>
                <td>{{ $job->penyedia->name ?? '-' }}</td>
                <td>Rp {{ number_format($job->gaji, 0, ',', '.') }}</td>
                <td>{{ ucfirst($job->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
