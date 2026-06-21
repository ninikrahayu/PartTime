<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Export Data Lamaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Data Lamaran Masuk</h2>
    <p>Tanggal Export: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelamar</th>
                <th>Lowongan</th>
                <th>Penyedia</th>
                <th>Tanggal Melamar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lamarans as $index => $lamaran)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $lamaran->pelamar->name ?? '-' }}</td>
                <td>{{ $lamaran->lowongan->judul ?? '-' }}</td>
                <td>{{ $lamaran->lowongan->penyedia->name ?? '-' }}</td>
                <td>{{ $lamaran->created_at->format('d/m/Y') }}</td>
                <td>{{ ucfirst($lamaran->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
