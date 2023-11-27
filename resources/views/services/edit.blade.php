    @extends('layouts.main')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('service.update',$service)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Update Service</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-4">
                                <label for="name_customer">Nama</label>
                                <input type="text" id="name_customer" class="form-control" name="name_customer" value="{{$service->name_customer}}" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="phone">No.Hp</label>
                                <input type="text" id="phone" class="form-control" name="phone" value="{{$service->phone}}" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="order_date">Tanggal</label>
                                <input type="date" id="order_date" class="form-control" name="order_date" value="{{$service->order_date}}" required>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="address">Alamat</label>
                                <textarea type="text" id="address" class="form-control" name="address">{{value($service->address)}}</textarea>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="exampleInputEmail1">Produk</label>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Nama Barang</td>
                                        <td>Jumlah</td>
                                    </tr>
                                    @foreach($service->serviceNames as $serviceNameOrdered)
                                        <tr>
                                            <td>
                                                <select class="form-control" name="service_name_id[]" id="exampleFormControlSelect1">
                                                    <option value=""></option>
                                                    @foreach($service_names as $service_name)
                                                        <option value="{{$service_name->id}}" @if($serviceNameOrdered->id == $service_name->id) selected @endif>{{$service_name->name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="total_amount[]" class="form-control" value="{{$serviceNameOrdered->pivot->quantity}}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="pay">Jumlah Bayar</label>
                                <input type="text" id="pay" class="form-control" name="pay" value="{{$service->pay}}" required>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="exampleInputEmail1">Status</label>
                                <select class="form-control" name="status" id="exampleFormControlSelect1" >
                                    <option>{{value($service->status)}}</option>
                                    <option>Belum Dibayar</option>
                                    <option>Sudah Dibayar</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="notes">Catatan</label>
                                <textarea type="text" id="notes" class="form-control" name="notes" >{{value($service->notes)}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-download" viewBox="0 0 16 16">
                                <path d="M4.406 1.342A5.53 5.53 0 0 1 8 0c2.69 0 4.923 2 5.166 4.579C14.758 4.804 16 6.137 16 7.773 16 9.569 14.502 11 12.687 11H10a.5.5 0 0 1 0-1h2.688C13.979 10 15 8.988 15 7.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 2.825 10.328 1 8 1a4.53 4.53 0 0 0-2.941 1.1c-.757.652-1.153 1.438-1.153 2.055v.448l-.445.049C2.064 4.805 1 5.952 1 7.318 1 8.785 2.23 10 3.781 10H6a.5.5 0 0 1 0 1H3.781C1.708 11 0 9.366 0 7.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383z"/>
                                <path d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
                            </svg>
                        </button>
                        <a href="{{\Illuminate\Support\Facades\URL::previous()}}" class="btn btn-primary">Back</a>
                    </div>
                </form>
            </div>
        </div>
@endsection
