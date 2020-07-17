<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];
    protected $hidden = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'categories_id', 'id');
    }
}
