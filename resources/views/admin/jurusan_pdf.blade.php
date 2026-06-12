<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Jurusan - PILIH.in</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #1e293b; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
        table { border-collapse: collapse; margin-top: 10px; width: 100%; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f8fafc; color: #475569; font-weight: bold; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { background-color: #f3e8ff; color: #6b21a8; padding: 3px 8px; border-radius: 10px; font-weight: bold; font-size: 11px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>PILIH.in Admin - DATA MANAJEMEN JURUSAN</h2>
        <p>Laporan Resmi Master Data Jurusan & Kategori Minat Terintegrasi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th style="width: 45%;">Nama Jurusan</th>
                <th style="width: 45%;">Kategori Minat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($majors as $row)
            <tr>
                <td>#{{ $row->id_jurusan }}</td>
                <td style="font-weight: bold; color: #1e293b;">{{ $row->nama_jurusan }}</td>
                <td>
                    <span class="badge">{{ $row->kategori_relevan }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; color: #94a3b8;">Belum ada data jurusan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>