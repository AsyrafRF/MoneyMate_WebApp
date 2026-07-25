<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>

    <link href="{{ public_path('css/app/laporan/pdf-style.css') }}" rel="stylesheet">
</head>
<body>

    <!-- ================================ -->
    <!-- HEADER -->
    <!-- ================================ -->
    <div style="text-align: center; width: 100%;">
        <table class="table-no-border" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 10px;">
            <tr>
                <td style="vertical-align: right;">
                    <h2 style="
                        margin: 0;
                        font-size: 25px;
                        font-weight: 700;
                        color: #0b2b48;
                    ">
                        <img src="{{ public_path('images/file-invoice-dollar-solid.png') }}"
                             width="30"
                             style="vertical-align: middle; margin-right: 2px;">
                        Laporan Keuangan
                    </h2>

                    <p style="margin: 2px 0 0 0; font-size: 13px; color: #2c3e50;">
                        Ringkasan transaksi keuangan berdasarkan periode laporan
                    </p>
                </td>

                <td width="90" style="vertical-align: left;">
                    <img src="{{ public_path('images/moneymate-original.png') }}"
                        style="width: 70px;">
                </td>
            </tr>
        </table>
    </div>

    <!-- GARIS HITAM TEBAL -->
    <hr style="border: 0; border-top: 2.5px solid #000; margin-top: 5px;">

    <!-- ========================================= -->
    <!-- INFORMASI PRIBADI -->
    <!-- ========================================= -->
    <h3>Informasi Pribadi</h3>

    <table class="table-no-border">
        <tr>
            <td>Nama</td>
            <td>: {{ Auth::user()->name }}</td>
            <td>Data Rekapan</td>
            <td>: {{ $periode_label }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>: {{ Auth::user()->email }}</td>
            <td>Diunduh pada</td>
            <td>: {{ now()->format('d M Y, H:i:s') }}</td>
        </tr>
    </table>

    <!-- ========================================= -->
    <!-- RIWAYAT TRANSAKSI -->
    <!-- ========================================= -->
    <h3>Riwayat Transaksi</h3>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%" class="text-center">Tanggal</th>
                <th width="15%" class="text-center">Jenis</th>
                <th width="20%" class="text-right">Nominal</th> <th width="20%" class="text-left">Kategori</th> <th width="25%" class="text-left">Keterangan</th> </tr>
        </thead>

        <tbody>
            @foreach($transaksi as $i => $t)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td class="text-center">{{ date('d/M/Y', strtotime($t->tanggal)) }}</td>
                <td class="text-center">
                    @if($t->jenis == 'Pemasukan')
                        <span class="badge-green">Pemasukan</span>
                    @else
                        <span class="badge-red">Pengeluaran</span>
                    @endif
                </td>

                <td class="nominal-col">
                    @if($t->jenis == 'Pemasukan')
                        <span class="incomes">+ Rp {{ number_format($t->jumlah,0,',','.') }}</span>
                    @else
                        <span class="expenses">- Rp {{ number_format($t->jumlah,0,',','.') }}</span>
                    @endif
                </td>

                <td class="text-left">{{ $t->nama_kategori }}</td>
                <td class="text-left">{{ $t->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 🔥 TAMBAHKAN INI UNTUK MENORMALKAN FLOAT SEBELUM SUMMARY BOX -->
    <div class="clearfix"></div>

    <!-- ========================================= -->
    <!-- SUMMARY TOTAL -->
    <!-- ========================================= -->
    <div class="summary-box">
        <p>
            <strong>Total Pemasukan</strong>
            <span class="right" style="float: right; color: green; font-weight: bold;">
                Rp {{ number_format($total_pemasukan, 0, ',', '.') }}
            </span>
        </p>

        <p>
            <strong>Total Pengeluaran</strong>
            <span class="right" style="float: right; color: red; font-weight: bold;">
                Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}
            </span>
        </p>
    </div>

    <!-- Letakkan kode ini tepat di atas tag tutup </body> -->
    <script type="text/php">
        if (isset($pdf)) {
            // 1. Pengaturan Font & Warna Teks
            $font = $fontMetrics->get_font("Arial", "normal");
            $size = 10;
            $color = array(0.49, 0.54, 0.55); // Warna abu-abu (#7f8c8d)

            // 2. Tentukan Posisi Vertikal (Y) untuk Elemen Footer
            // Di kertas A4 vertikal, posisi 800-810 adalah area ideal untuk footer
            $y_line = 800; // Posisi tinggi garis
            $y_text = 810; // Posisi tinggi teks (di bawah garis)

            // 3. Gambar Garis Pembatas Atas (Border Top)
            // Parameter: line(x1, y1, x2, y2, warna, ketebalan)
            // x1: 30 (mulai dari margin kiri), x2: 565 (berakhir di margin kanan A4)
            $pdf->line(30, $y_line, 565, $y_line, $color, 0.5);

            // 4. Cetak Teks Hak Cipta di Sebelah Kiri
            $pdf->page_text(30, $y_text, "© " . date('Y') . " MoneyMate ID. All rights reserved.", $font, $size, $color);
            
            // 5. Cetak Nomor Halaman di Sebelah Kanan
            $text_page = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $pdf->page_text(450, $y_text, $text_page, $font, $size, $color);
        }
    </script>
</body>
</html>