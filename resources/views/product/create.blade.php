@extends('layouts.app')
@section('title','PRODUK')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-left">TAMBAH PRODUK</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product">Nama Produk</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product">Kategori</label>
                                    <select name="categories_id" class="form-control" value="{{ old('name')}}" required>
                                        <option value="">-- PIlih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Harga Beli</label>
                                    <input type="number" class="form-control" name="purchase_price" value="{{ old('purchase_price') }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Harga Jual</label>
                                    <input type="number" class="form-control" name="selling_price" value="{{ old('selling_price') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stock">Stok</label>
                                    <input type="number" class="form-control" name="stock" value="{{ old('stock') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <div class="form-group">
                                        <input name="image" id="image" type="file" class="form-control p-1 @error('image') is-invalid @enderror"
                                                accept="image/*"
                                                onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-10"><img id="output" src="" class="img-fluid"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea name="desc" cols="30" rows="10" class="form-control">{{ old('desc') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
