<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Kampus - PILIH.in</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #1e293b;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #64748b;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f8fafc;
            color: #4f46e5;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #fdfdfd;
        }
        .badge {
            background-color: #dcfce7;
            color: #15803d;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 11px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>PILIH.in — LAPORAN MASTER DATA KAMPUS</h2>
        <p>Dicetak otomatis oleh Sistem Administrasi PILIH.in pada: {{ date('d-m-Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%; text-align: center;">ID</th>
                <th style="width: 37%;">Nama Kampus</th>
                <th style="width: 25%;">Lokasi</th>
                <th style="width: 12%; text-align: center;">Akreditasi</th>
                <th style="width: 18%;">Estimasi UKT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($campuses as $campus)
            <tr>
                <td style="text-align: center; color: #64748b;">#{{ $campus->id_kampus }}</td>
                <td style="font-weight: bold; color: #1e293b;">{{ $campus->nama_kampus }}</td>
                <td>{{ $campus->lokasi }}</td>
                <td style="text-align: center;">
                    <span class="badge">{{ $campus->akreditasi }}</span>
                </td>
                <td>{{ $campus->estimasi_biaya }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini sah dikeluarkan oleh sistem database PILIH.in.
    </div>

</body>
</html>