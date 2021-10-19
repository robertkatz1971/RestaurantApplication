<?php

namespace App\Http\Controllers\Cashier;

use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CashierController extends Controller
{
    public function index () {
        return view('cashier.index');
    }

    public function getTables () {
        $tables = Table::all()->sortBy('name');

        $html = '';
        foreach($tables as $table) {
            $html .= '<div class="col-md-2 mb-4 "> ';
            $html .= '<button class="btn btn-primary">
            <img class="img-fluid" src="' . url('/images/table.svg') . '"/>
            <br>
            <span class="badge badge-success">' . $table->name . '</span>
            </button>';

            $html .= '</div>';
        }

        return $html;
    }
}
