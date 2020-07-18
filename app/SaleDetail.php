<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sales_id', 'products_id', 'qty'
    ];
    protected $hidden = [];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sales_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }
}
