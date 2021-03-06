<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Sale;
use App\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::with(['details', 'user', 'customer'])->get();
        return view('sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //product
        if ($request->has('search')) {
            $products = Product::with(['category'])->where('name', 'LIKE', '%' . $request->search . '%')->paginate(8);
        } else {
            $products = Product::with(['category'])->orderBy('created_at', 'asc')->paginate(8);
        }
        //customer
        $customers = Customer::all();

        //cart item
        if (request()->tax) {
            $tax = "+10%";
        } else {
            $tax = "0%";
        }
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'tax',
            'type' => 'tax', //tipenya apa
            'target' => 'total', //target kondisi ini apply ke mana (total, subtotal)
            'value' => $tax, //contoh -12% or -10 or +10 etc
            'order' => 1
        ));

        \Cart::session(Auth()->id())->condition($condition);
        $items = \Cart::session(Auth()->id())->getContent();
        if (\Cart::isEmpty()) {
            $cart_data = [];
        } else {
            foreach ($items as $row) {
                $cart[] = [
                    'rowId' => $row->id,
                    'name' => $row->name,
                    'qty' => $row->quantity,
                    'pricesingle' => $row->price,
                    'price' => $row->getPriceSum(),
                    'created_at' => $row->attributes['created_at'],
                ];
            }

            $cart_data = collect($cart)->sortBy('created_at');
        }
        //total
        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();
        //tax
        $new_condition = \Cart::session(Auth()->id())->getCondition('tax');
        $tax = $new_condition->getCalculatedValue($sub_total);

        $data_total = [
            'sub_total' => $sub_total,
            'total' => $total,
            'tax' => $tax
        ];
        return view('sale.create', compact('products', 'customers', 'cart_data', 'data_total'));
    }

    public function addProductCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $id);

        if ($checkItemId->isNotEmpty()) {
            if ($product->stock == $checkItemId[$id]->quantity) {
                return \redirect()->back()->with('error', 'Telah mencapai jumlah maximum Product | Silahkan tambah stock Product terlebih dahulu untuk menambahkan');
            } else {
                \Cart::session(Auth()->id())->update($id, array(
                    'quantity' => 1
                ));
            }
        } else {
            \Cart::session(Auth()->id())->add(array(
                'id' => $id,
                'name' => $product->name,
                'price' => $product->selling_price,
                'quantity' => 1,
                'attributes' => array(
                    'created_at' => date('Y-m-d H:i:s')
                )
            ));
        }
        return redirect()->back();
    }
    public function removeProductCart($id)
    {
        \Cart::session(Auth()->id())->remove($id);

        return redirect()->back();
    }

    public function decreasecart($id)
    {
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $id);

        if ($checkItemId[$id]->quantity == 1) {
            \Cart::session(Auth()->id())->remove($id);
        } else {
            \Cart::session(Auth()->id())->update($id, array(
                'quantity' => array(
                    'relative' => true,
                    'value' => -1
                )
            ));
        }
        return redirect()->back();
    }


    public function increasecart($id)
    {
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $id);

        if ($product->stock == $checkItemId[$id]->quantity) {
            return redirect()->back()->with('error', 'Stok produk mencapai jumlah maximum | Silahkan tambah stok terlebih dahulu.');
        } else {
            \Cart::session(Auth()->id())->update($id, array(
                'quantity' => array(
                    'relative' => true,
                    'value' => 1
                )
            ));

            return redirect()->back();
        }
    }

    public function pay(Request $request)
    {
        $cart_total = \Cart::session(Auth()->id())->getTotal();
        $pay = request()->pay;
        $change = (int)$pay - (int)$cart_total;

        if ($change >= 0) {
            DB::beginTransaction();

            try {

                $all_cart = \Cart::session(Auth()->id())->getContent();


                $filterCart = $all_cart->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = Product::findOrFail($cart['id']);

                    if ($product->stock == 0) {
                        return redirect()->back()->with('errorSale', 'jumlah pembayaran gak valid');
                    }

                    $product->decrement('stock', $cart['quantity']);
                }

                $sale = Sale::create([
                    'users_id' => Auth::id(),
                    'customers_id' => $request->customers_id,
                    'pay' => request()->pay,
                    'total' => $cart_total
                ]);

                foreach ($filterCart as $cart) {

                    SaleDetail::create([
                        'sales_id' => $sale->id,
                        'products_id' => $cart['id'],
                        'qty' => $cart['quantity'],
                    ]);
                }

                \Cart::session(Auth()->id())->clear();

                DB::commit();
                return redirect()->back()->with('success', 'Transaksi Berhasil dilakukan | Klik History untuk print');
            } catch (\Exeception $e) {
                DB::rollback();
                return redirect()->back()->with('errorSale', 'jumlah pembayaran tidak valid');
            }
        }
        return redirect()->back()->with('errorSale', 'jumlah pembayaran tidak valid');
    }
    public function clear()
    {
        \Cart::session(Auth()->id())->clear();
        return redirect()->back();
    }
}
