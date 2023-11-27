<!DOCTYPE html>
<html>
<head>
    <title>Report Daily PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif; /* Ganti dengan font yang sesuai */
            font-size: 14px; /* Ukuran font */
        }
        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        #adek{
            border: 0px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .total {
            font-weight: bold;
            text-align: right;
        }
        .content-table th, .content-table td {
            padding: 8px;
            text-align: left;
        }

        .content-table th {
            background-color: #f2f2f2;
        }

        .signature-table {
            width: 100%;
        }

        .signature-table td {
            vertical-align: top;
            width: 50%;
            padding: 10px;
            text-align: center;
            border: 0px;
        }

        .left-column {
            border-right: 0px solid #000;
            border: 0px;
        }
    </style>
</head>
<body>
<center>
    <h1 id="adekjudul">DRW Skincare</h1>
    <hr>
    <p id="adek">Jl. Raya Pekan Kamis, Balai Panjang Jorong III Kampung Gadut </p>
    <p id="adek">Kec. Tilatang Kamang, Kab. Agam, Sumatera Barat</p>
    <p id="adek">Laporan Harian</p>
    <hr>
    <h4 id="adekjudul">Tanggal : {{\Carbon\Carbon::parse($tanggal)->isoFormat('D MMMM Y')}}</h4>
</center>
<table class="table table-striped">
    <thead>
    <tr>
        <th>No.</th>
        <th>Nama</th>
        <th>Tanggal</th>
        <th>Alamat</th>
        <th>No.Telpon</th>
        <th>Jumlah Bayar</th>
        <th>Kembalian</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @forelse($services as $service)
        <tr>
            <td scope="row">{{$loop->iteration +$startIndex}}.</td>
            <td>{{$service->name_customer}}</td>
            <td>{{\Carbon\Carbon::parse($service->order_date)->isoFormat('D MMM Y')}}</td>
            <td>{{$service->address}}</td>
            <td>{{$service->phone}}</td>
            <td>Rp.{{number_format($service->pay, 0,',',',')}}</td>
            <td>Rp.{{number_format($service->returned, 0,',',',')}}</td>
            <td>Rp.{{number_format($service->total_amount, 0,',',',')}}</td>
        </tr>
    @empty
        <h3>Data Tidak Ada!</h3>
    @endforelse
    </tbody>
    <tr></tr>
    <tr>
        <td id="adek"></td>
        <td id="adek"></td>
        <td id="adek"></td>
        <td id="adek"></td>
        <td id="adek"></td>
        <td id="adek"></td>
        <td id="adek" class="total">Total :</td>
        <td id="adek" class="total">Rp.{{number_format($total, 0,',',',')}}</td>
    </tr>
</table>
<table class="signature-table" border="0">
    <tr>
        <td class="left-column">
            <p>Kepala DRW SKINCARE,</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p style="font-weight: bold">Apt. TItin Dahri, S.Farm</p>
        </td>
        <td class="right-column">
            <p>Anggota DRW SKINCARE,</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p style="font-weight: bold">(______________________)</p>
        </td>
    </tr>
</table>
<center>
    <div class="container">
    </div>
</center>
</body>
</html>
