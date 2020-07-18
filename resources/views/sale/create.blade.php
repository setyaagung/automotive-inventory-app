@extends('layouts.app')
@section('title','TRANSAKSI PENJUALAN')
    
@section('content')
    <div class="row justify-content-center mr-1 ml-1">
        <div class="col-md-7">
            <div class="card" style="min-height: 80vh">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="float-left"><b>PRODUK</b></h5>
                        </div>
                        <div class="col-sm-6">
                            <form action="{{ route('sale.create') }}" method="GET">
                                <div>
                                    <input type="text" name="search" class="form-control form-control-sm col-sm-12" style="float: right !important" placeholder="Cari Produk ..." onblur="this.form.submit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-sm-3">
                            <div class="card mb-3 shadow">
                                <div class="view overlay">
                                    <form action="{{route('sale.addproduct',$product->id)}}" method="POST">
                                        @csrf
                                        @if ($product->stock == 0)
                                            <img class="card-img-top" src="{{ Storage::url($product->image) }}" style="width: 100%;height:175px;padding: 0.9rem 0.9rem;">
                                            <button class="btn btn-primary btn-sm cart-btn disabled"><i class="fas fa-cart-plus"></i></button>
                                        @else
                                            <img class="card-img-top" src="{{ Storage::url($product->image) }}" style="width: 100%;height:175px;padding: 0.9rem 0.9rem;">
                                            <button class="btn btn-primary btn-sm cart-btn"><i class="fas fa-cart-plus"></i></button>
                                        @endif
                                    </form>
                                </div>
                                <div class="card-body">
                                    <label class="card-title text-center font-weight-bold"
                                        style="text-transform: capitalize;">
                                        {{ Str::words($product->name,4) }} ({{$product->stock}})</label>
                                    <p class="card-text text-center">
                                        Rp. {{ number_format($product->selling_price,2,',','.') }}
                                    </p>
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
        <div class="col-md-5">
            <div class="card" style="min-height: 80vh">
                <div class="card-header bg-white">
                    <div class="col-sm-6">
                        <h5 class="float-left"><b>CART</b></h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3" style="overflow-y:auto;min-height:53vh;max-height:53vh">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>PRODUK</th>
                                    <th>QTY</th>
                                    <th class="text-right">SUB TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cart_data as $index=>$item)
                                    <tr>
                                        <td>
                                            <form action="{{ route('sale.removeproduct',$item['rowId'])}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                                {{$loop->iteration}} <br>
                                                <a onclick="this.closest('form').submit();return false;">
                                                    <i class="fas fa-trash" style="color: rgb(134, 134, 134)"></i>
                                                </a>
                                            </form>
                                        </td>
                                        <td>{{Str::words($item['name'],3)}} <br>Rp.
                                            {{ number_format($item['pricesingle'],2,',','.') }}
                                        </td>
                                        <td class="font-weight-bold">
                                            <form action="{{route('sale.decreasecart',$item['rowId'])}}" method="POST" style='display:inline;'>
                                                @csrf
                                                <button class="btn btn-sm btn-danger"
                                                    style="display: inline;padding:0.4rem 0.6rem!important"><i
                                                        class="fas fa-minus"></i>
                                                </button>
                                            </form>
                                            <a style="display: inline">{{$item['qty']}}</a>
                                            <form action="{{ route('sale.increasecart',$item['rowId'])}}"
                                                method="POST" style='display:inline;'>
                                                @csrf
                                                <button class="btn btn-sm btn-primary"
                                                    style="display: inline;padding:0.4rem 0.6rem!important"><i
                                                        class="fas fa-plus"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-right">
                                            Rp. {{ number_format($item['price'],2,',','.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Empty Cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="60%">Sub Total</th>
                            <th width="40%" class="text-right">
                                Rp. {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                        </tr>
                        <tr>
                            <th>
                                <form action="{{ route('sale.create') }}" method="get">
                                    PPN 10%
                                    <input type="checkbox" {{ $data_total['tax'] > 0 ? "checked" : ""}} name="tax"
                                        value="true" onclick="this.form.submit()">
                                </form>
                            </th>
                            <th class="text-right">Rp.
                                {{ number_format($data_total['tax'],2,',','.') }}</th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th class="text-right font-weight-bold">Rp.
                                {{ number_format($data_total['total'],2,',','.') }}</th>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-sm-4">
                            <form action="{{route('sale.clear')}}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-lg btn-block" onclick="return confirm('Apakah anda yakin ingin meng-clear cart ?');" type="submit">
                                    Clear
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-lg btn-block" href="{{ route('sale.index')}}">History</a>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#pay">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- MODAL BAYAR -->
<div class="modal fade right" id="pay" role="dialog" aria-labelledby="MyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-height modal-bottom" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #111d5e">
                <h5 class="modal-title text-white" id="myModalLabel">Billing Information</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <th width="60%">Sub Total</th>
                        <th width="40%" class="text-right">Rp.
                            {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                    </tr>
                    @if($data_total['tax'] > 0)
                    <tr>
                        <th>PPN 10%</th>
                        <th class="text-right">Rp.
                            {{ number_format($data_total['tax'],2,',','.') }}</th>
                    </tr>
                    @endif
                </table>
                <form action="{{ route('sale.pay') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="oke">Input Nominal</label>
                                <input id="oke" class="form-control" type="number" name="pay" autofocus />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Customer</label>
                                <select name="customers_id" class="form-control"  value="{{ old('name') }}" required>
                                    <option value="">-- Pilih Customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <h3 class="font-weight-bold">Total:</h3>
                    <h1 class="font-weight-bold mb-5">Rp. {{ number_format($data_total['total'],2,',','.') }}</h1>
                    <input id="totalHidden" type="hidden" name="totalHidden" value="{{$data_total['total']}}" />

                    <h3 class="font-weight-bold">Bayar:</h3>
                    <h1 class="font-weight-bold mb-5" id="pembayaran"></h1>

                    <h3 class="font-weight-bold text-primary">Kembalian:</h3>
                    <h1 class="font-weight-bold text-primary" id="kembalian"></h1>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" disabled onClick="openWindowReload(this)">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
