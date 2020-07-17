@extends('layouts.app')
@section('title','EDIT CUSTOMER')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="float-left">EDIT CUSTOMER</h5>
                </div>

                <div class="card-body">
                    <form action="{{route('customer.update',$customer->id)}}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>NAMA</label>
                                    <input type="text" class="form-control" name="name" value="{{ $customer->name}}" required autofocus>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>TELEPON</label>
                                    <input type="number" class="form-control" name="phone" value="{{ $customer->phone}}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>ALAMAT</label>
                            <textarea name="address" class="form-control" cols="30" rows="4" required>{{ $customer->address}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm float-right">SIMPAN</button>
                        <a href="{{route('customer.index')}}" class="btn btn-secondary btn-sm float-right mr-1">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection