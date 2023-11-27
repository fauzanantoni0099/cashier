@extends('layouts.main')

@section('content')
            <div class="col-12">
                <div class="card">
                    <div class="card-header" role="alert">
                        <h4 class="card-title">Detail Product</h4>
                    </div>
                    <div class="card-body">
                        <a>Kategri </a>
                        <h4>{{$product->category->name}}</h4>
                        <a>Satuan </a>
                        <h4>{{$product->unit->name}}</h4>
                        <div class="float-right">
                            <br>@foreach($product->images as $image)
                                <img src="/{{($image->name_path)}}" class="img img-thumbnail" width="400px">
                            @endforeach
                        </div>
                        <a>Nama</a>
                        <h4>{{$product->name}}</h4>
                        <a>Harga Beli</a>
                        <h4>{{$product->purchase_price}}</h4>
                        <a>Harga Jual</a>
                        <h4>{{$product->selling_price}}</h4>
                        <a>Keuntungan</a>
                        <h4>Rp.{{number_format($product->profit, 0,',','.')}}</h4>
                        <a>Stok</a>
                        <h4>{{$product->stock}}</h4>
                        <a>Kedaluarsa</a>
                        <h4>{{$product->expired}}</h4>
                        <br>Tanggal Dibuat : {{\Carbon\Carbon::parse($product->created_at)->isoFormat('D MMMM Y')}}
                    </div>
                    <div class="card-footer">
                        <form method="POST" action="{{route('product.destroy', $product)}}" class="fs-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Sayang')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                            </button>
                            <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-primary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
@endsection
