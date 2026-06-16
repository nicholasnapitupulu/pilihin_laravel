<h2 style="font-family: sans-serif;">Riwayat Tes PILIH.in</h2>
<table width="100%" border="1" style="border-collapse: collapse; font-family: sans-serif;">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jurusan</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riwayat_result as $riwayat)
        <tr>
            <td>{{ $riwayat->tanggal_tes }}</td>
            <td>{{ $riwayat->jurusan->nama_jurusan ?? '-' }}</td>
            <td>{{ $riwayat->skor_kecocokan }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>