@extends('layouts.app')
@section('title','HISTORY PENJUALAN')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="min-height: 80vh">
                <div class="card-header">
                    <h5 class="float-left"><b>HISTORY PENJUALAN</b></h5>
                    <a href="{{route('sale.create')}}" class="btn btn-primary btn-sm float-right">TRANSAKSI</a>
                </div>

                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{$message}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('update'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Updated!</strong> {{$message}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($message = Session::get('delete'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Deleted!</strong> {{$message}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <table id="myTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INVOICE</th>
                                <th>USER</th>
                                <th>CUSTOMER</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{ route('sale.show',$sale->id) }}">{{$sale->invoices_number}}</a></td>
                                <td>{{$sale->user->name}}</td>
                                <td>{{$sale->customer->name}}</td>
                                @if ($sale->total <= $sale->pay)
                                    <td><span class="badge badge-success">LUNAS</span></td>
                                @else
                                    <td><span class="badge badge-danger">BELUM LUNAS</span></td>
                                @endif
                                <td>
                                    <a href="{{route('sale.edit',$sale->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{route('sale.destroy',$sale->id)}}" class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
