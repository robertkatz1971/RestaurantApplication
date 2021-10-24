<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    public function saleDetails() {
        return $this->hasMany(SaleDetail::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function table() {
        return $this->belongsTo(Table::class);
    }
}
