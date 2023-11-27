@extends('layouts.main')

@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Kategori</h4>
                </div>
                    <div class="card-body">
                        <form action="{{route('category.update',$category)}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nama Kategori</label>
                                <input type="text" class="form-control" name="name" value="{{$category->name}}" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Deskripsi Kategori</label>
                                <input type="text" class="form-control" name="description" value="{{$category->description}}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
            </div>
        </div>
@endsection
