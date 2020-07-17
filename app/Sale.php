<?php

namespace App;

use GuzzleHttp\Psr7\FnStream;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoices_number', 'users_id', 'customers_id',
        'total', 'pay'
    ];
    protected $hidden = [];

    public function details()
    {
        return $this->hasMany(SaleDetail::class, 'sales_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id', 'id');
    }
}
