@extends('layouts.app')
@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Details Service</h4>
                </div>
                    <div class="card-body">
                        <a>Nama</a>
                        <h4>{{$service->name_customer}}</h4>
                        <a>Tanggal</a>
                        <h4>{{$service->order_date}}</h4>
                        <a>No.Hp</a>
                        <h4>{{$service->phone}}</h4>
                        <a>Alamat</a>
                        <h4>{{$service->address}}</h4>
                        <a>Catatan</a>
                        <h4>{{$service->notes}}</h4>
                        <a>Jumlah Bayar</a>
                        <h4>Rp.{{number_format($service->pay, 0,',','.')}}</h4>
                        <a>Kembali</a>
                        <h4>Rp.{{number_format($service->returned, 0,',','.')}}</h4>
                        <a>Status</a>
                        <h4>{{$service->status}}</h4>
                        <br>Detail Services :
                        <table class="table table-bordered">
                            <tr>
                                <td>Nama Jasa</td>
                                <td>Harga</td>
                                <td>Jumlah</td>
                                <td>Sub Total</td>
                            </tr>
                            @foreach($service->serviceDetails as $serviceDetail)
                                <tr>
                                    <td>{{$serviceDetail->serviceName->name}}</td>
                                    <td>Rp.{{number_format($serviceDetail->serviceName->price, 0,',','.')}}</td>
                                    <td>{{$serviceDetail->quantity}}</td>
                                    <td>Rp.{{number_format($serviceDetail->subtotal, 0,',','.')}}</td>
                                </tr>
                            @endforeach
                        </table>
                        <br>Tanggal Dibuat : {{\Carbon\Carbon::parse($serviceDetail->created_at)->isoFormat('D MMMM Y')}}
                    </div>
                <div class="card-footer">
                    <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
@endsection
