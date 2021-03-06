@extends('layouts.app')
@section('title','PRODUK')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="min-height: 80vh">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-3">
                            <h5 class="float-left"><b>PRODUK</b></h5>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('product.index') }}" method="GET">
                                <div>
                                    <input type="text" name="search" class="form-control form-control-sm col-sm-12" style="float: right !important" placeholder="Cari Produk ..." onblur="this.form.submit()">
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right">TAMBAH PRODUK</a>
                        </div>
                    </div>
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
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-sm-3">
                            <div class="card mb-3 shadow">
                                <div class="view overlay">
                                    <img class="card-img-top" src="{{ $product->image }}" alt="Card image cap" style="width: 100%;height:175px;padding: 0.9rem 0.9rem;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-center font-weight-bold"
                                        style="text-transform: capitalize;">
                                        {{ Str::words($product->name,6) }}</h5>
                                    <p class="card-text text-center">Rp. {{ number_format($product->selling_price,2,',','.') }}
                                    </p>
                                    <a href="{{ route('product.edit', $product->id) }}"
                                        class="btn btn-primary btn-block btn-sm">Details</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <div class="float-left ml-3"><b>TOTAL DATA PRODUK : {{ DB::table('products')->count() }}</b></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right mr-3">{{ $products->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
