<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perkembangan Anak</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 14px;
        }

        /* Header */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        /* Content Info */
        .info-container {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 10px;
            vertical-align: top;
        }
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #444;
        }
        .info-separator {
            width: 10px;
        }

        /* Title */
        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 25px;
            text-decoration: underline;
            text-underline-offset: 5px;
            color: #333;
        }

        /* Main Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            text-align: center;
            border: 1px solid #ccc;
            padding: 12px;
            text-transform: uppercase;
            font-size: 12px;
        }
        .table td {
            border: 1px solid #ccc;
            padding: 10px 15px;
            text-align: left;
            vertical-align: middle;
        }
        .table-row-even {
            background-color: #fcfcfc;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-bold { font-weight: bold; }

        /* Summary Section */
        .summary-row {
            background-color: #f1f5f9;
            font-weight: bold;
        }

        /* Notes Section */
        .notes-section {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            background-color: #fff;
            position: relative;
        }
        .notes-label {
            position: absolute;
            top: -12px;
            left: 15px;
            background-color: #fff;
            padding: 0 10px;
            font-weight: bold;
            color: #333;
        }
        .notes-content {
            margin: 0;
            line-height: 1.6;
            min-height: 60px;
            white-space: pre-wrap;
        }

        /* Signature */
        .signature-section {
            margin-top: 60px;
            display: table;
            width: 100%;
        }
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-space {
            height: 80px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>TK Bina Pertiwi</h1>
        <p>Jl. Contoh Alamat No. 123, Kota Contoh, Provinsi Contoh</p>
        <p>Telp: (021) 12345678 | Email: tkbinapertiwi@example.com</p>
    </div>

    <div class="report-title">LAPORAN PERKEMBANGAN ANAK</div>

    <div class="info-container">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Anak</td>
                <td class="info-separator">:</td>
                <td>{{ $record->student->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Kelas</td>
                <td class="info-separator">:</td>
                <td>{{ $record->student->class->student_class ?? '-' }}</td>
            </tr>
            <tr>
                <td class="info-label">Periode</td>
                <td class="info-separator">:</td>
                <td>{{ \Carbon\Carbon::parse($record->period)->isoFormat('MMMM Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="8%">No</th>
                <th width="62%">Aspek Perkembangan</th>
                <th width="30%">Nilai (0-100)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Motorik</td>
                <td class="text-center">{{ $record->motorik }}</td>
            </tr>
            <tr class="table-row-even">
                <td class="text-center">2</td>
                <td>Kognitif</td>
                <td class="text-center">{{ $record->kognitif }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Bahasa</td>
                <td class="text-center">{{ $record->bahasa }}</td>
            </tr>
            <tr class="table-row-even">
                <td class="text-center">4</td>
                <td>Sosial Emosional</td>
                <td class="text-center">{{ $record->sosial_emosional }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="summary-row">
                <td colspan="2" class="text-right">Rata-Rata</td>
                <td class="text-center">{{ $record->score }}</td>
            </tr>
            <tr class="summary-row">
                <td colspan="2" class="text-right">Status Perkembangan</td>
                <td class="text-center">{{ $record->status }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="notes-section">
        <span class="notes-label">Catatan</span>
        <p class="notes-content">{{ $record->notes ?? '-' }}</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="signature-space"></div>
            <p class="signature-name">( ................................................. )</p>
        </div>
        <div class="signature-box">
            <p>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
            <p>Guru Kelas</p>
            <div class="signature-space"></div>
            <p class="signature-name">( ................................................. )</p>
        </div>
    </div>
</body>
</html>
