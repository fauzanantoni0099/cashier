@extends('layouts.main')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <form action="{{route('service_name.update',$serviceName)}}" method="post">
                    @csrf
                    @method('PUT')
                <div class="card-header">
                    <h4 class="card-title">Edit Name Service</h4>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Service</label>
                            <input type="text" class="form-control" name="name" value="{{$serviceName->name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi Service</label>
                            <input type="text" class="form-control" name="description" value="{{$serviceName->description}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" class="form-control" name="price" value="{{$serviceName->price}}" required>
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