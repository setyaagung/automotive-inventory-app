@extends('layouts.app')
@section('title','TAMBAH KATEGORI')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="float-left">TAMBAH KATEGORI</h5>
                </div>

                <div class="card-body">
                    <form action="{{route('category.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>NAMA</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm float-right">SIMPAN</button>
                        <a href="{{route('category.index')}}" class="btn btn-secondary btn-sm float-right mr-1">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection