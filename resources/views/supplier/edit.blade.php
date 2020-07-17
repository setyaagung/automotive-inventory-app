@extends('layouts.app')
@section('title','EDIT SUPPLIER')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="float-left">EDIT SUPPLIER</h5>
                </div>

                <div class="card-body">
                    <form action="{{route('supplier.update',$supplier->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>NAMA</label>
                                    <input type="text" class="form-control" name="name" value="{{ $supplier->name}}" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>TELEPON</label>
                                    <input type="number" class="form-control" name="phone" value="{{ $supplier->phone}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ALAMAT</label>
                            <textarea name="address" class="form-control" cols="30" rows="4" required>{{ $supplier->address}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm float-right">SIMPAN</button>
                        <a href="{{route('supplier.index')}}" class="btn btn-secondary btn-sm float-right mr-1">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection