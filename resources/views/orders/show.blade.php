@extends('layouts.app')
@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Order</h4>
                </div>
                    <div class="card-body">
                        <a>Catatan</a>
                        <h4>{{$order->notes}}</h4>
                        <a>Tanggal Order</a>
                        <h4>{{$order->order_date}}</h4>
                        <a>Jumlah Total</a>
                        <h4>Rp.{{number_format($order->total_amount, 0,',','.')}}</h4>
                        <a>Jumlah Bayar</a>
                        <h4>Rp.{{number_format($order->pay, 0,',','.')}}</h4>
                        <a>Uang Kembali</a>
                        <h4>Rp{{number_format($order->returned, 0,',','.')}}</h4>
                        <a>Status</a>
                        <h4>{{$order->status}}</h4>
                        <a>Nama Customer</a>
                        <h4>{{$order->name_customer}}</h4>
                        <h4>{!! \Milon\Barcode\DNS2D::getBarcodeHTML($order->code, 'QRCODE') !!}</h4>
                        <br>Detail Order :
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama Produk</td>
                                <td>Jumlah Produk</td>
                                <td>Harga</td>
                                <td>Sub Total</td>
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
                        <br>Tanggal Dibuat : {{\Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM Y')}}
                    </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
@endsection
