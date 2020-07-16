@extends('layouts.app')
@section('title','EDIT PRODUK')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-left">EDIT PRODUK</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product">Nama Produk</label>
                                    <input type="text" class="form-control" name="name" value="{{ $product->name }}" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="product">Kategori</label>
                                    <select name="categories_id" class="form-control" value="{{ old('name')}}" required>
                                        <option value="{{$product->categories_id}}">Jangan Diubah</option>
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
                                    <input type="number" class="form-control" name="purchase_price" value="{{ $product->purchase_price }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="price">Harga Jual</label>
                                    <input type="number" class="form-control" name="selling_price" value="{{ $product->selling_price }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="stock">Stok</label>
                                    <input type="number" class="form-control" name="stock" value="{{ $product->stock }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" id="image" class="form-control p-1 @error('image') is-invalid @enderror" name="image" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0]); document.getElementById('preview').style.display = 'none'" value="{{ $product->image }}">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-10"><img id="output" src="" class="img-fluid"></div>
                                @if($product->image)
                                <img src="{{Storage::url($product->image)}}" class="img-fluid" id="preview">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea name="desc" cols="30" rows="10" class="form-control">{{ $product->desc }}</textarea>
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