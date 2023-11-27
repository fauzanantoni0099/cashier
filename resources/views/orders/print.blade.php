<!DOCTYPE html>
<html>
<head>
    <title>Contoh PDF</title>
    <style>
        .table-bordered{
            border: 1px solid black !important;
        }
        .tableadek{
            border-collapse: collapse !important;
        }
        .tableadek{
            border-collapse: collapse;
            width: 100%;
        }
        #adekjudul{
            font-size: 20px;
        }
        #adek{
            font-size: 11px;
        }
        .tableadek th, .tableadek  td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .tableadek th{
            background-color: #f2f2f2;
        }

        .table-center {
            width: 80%;
            margin: 0 auto;
        }

        .text-right {
            text-align: right;
        }
        .container {
            position: relative;
            width: 50%;
            height: 50vh;
            left: 39%;
        }

        .content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Menengahkan elemen */
        }
    </style>
</head>
<body>
<center>
    <h1 id="adekjudul">DRW Skincare</h1>
    <hr>
        <p id="adek">Jl. Raya Pekan Kamis, Balai Panjang Jorong III Kampung Gadut, Kec. Tilatang Kamang, Kab. Agam, Sumatera Barat</p>
        <p id="adek">HP/WA : +62 812-6774-9112/+62 812-6774-9112</p>
    <hr>
        <h1 id="adekjudul">{{$order->name_customer}}</h1>
    <hr>
</center>

<table border="0" class="table-center">
    <tr>
        <td class="text-right">Tanggal</td>
        <td widtd="1%">:</td>
        <td>{{\Carbon\Carbon::parse($order->order_date)->isoFormat('D MMM Y')}}</td>
    </tr>
    <tr>
        <td class="text-right">Jumlah</td>
        <td>:</td>
        <td>Rp.{{number_format($order->total_amount, 0,',','.')}}</td>
    </tr>
    <tr>
        <td class="text-right">Jumlah Bayar</td>
        <td>:</td>
        <td>Rp.{{number_format($order->pay, 0,',','.')}}</td>
    </tr>
    <tr>
        <td class="text-right">Kembalian</td>
        <td>:</td>
        <td>Rp.{{number_format($order->returned, 0,',','.')}}</td>
    </tr>
    <tr>
        <td class="text-right">Status</td>
        <td>:</td>
        <td>{{$order->status}}<</td>
    </tr>
    <tr>
        <td class="text-right">Catatan</td>
        <td>:</td>
        <td>{{$order->notes}}<</td>
    </tr>
</table>

<hr>

<table>
    <tr>
        <th>Produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Subtotal</th>
    </tr>
    @foreach($order->orderDetails as $orderDetail)
            <tr>
                <td>{{$orderDetail->product->name}}</td>
                <td>{{$orderDetail->quantity}}</td>
                <td>Rp.{{number_format($orderDetail->product->selling_price, 0,',','.')}}</td>
                <td>Rp.{{number_format($orderDetail->subtotal, 0,',','.')}}</td>
            </tr>
    @endforeach
</table>
<center>
<hr>
    <div class="container">
        {!! \Milon\Barcode\DNS2D::getBarcodeHTML($order->code, 'QRCODE',3,3) !!}
    </div>
    <h1 id="adekjudul">Terima Kasih Banyak</h1>
</center>
</body>
</html>
