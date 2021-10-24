<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'status'];

    public function sales () {
        return $this->hasMany(Sale::class);
    }
}
