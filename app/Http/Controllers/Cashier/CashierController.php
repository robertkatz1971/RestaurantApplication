<?php

namespace App\Http\Controllers\Cashier;

use App\Menu;
use App\Sale;
use App\Table;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SaleDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index () {

        $categories = Category::all()->sortBy('name');
        return view('cashier.index')->with('categories', $categories);
    }

    public function getTables () {
        $tables = Table::all()->sortBy('name');

        $html = '';
        foreach($tables as $table) {
            $html .= '<div class="col-md-2 mb-4 "> ';
            $html .= '<button class="btn btn-primary btn-table" data-id="' . $table->id . '"
             data-name="' . $table->name . '">
            <img class="img-fluid" src="' . url('/images/table.svg') . '"/>
            <br>
            <span class="badge badge-success">' . $table->name . '</span>
            </button>';

            $html .= '</div>';
        }

        return $html;
    }

    public function getMenuByCategory($category_Id) {
        $menus = Menu::where('category_id', $category_Id)->get();

        $html = '';
        foreach($menus as $menu) {
            $html .= '
                <div class="col-md-3 text-center"> 
                    <a class="btn btn-outline-secondary btn-menu" data-id="' . $menu->id . '">
                        <img class="img-fluid" src="' . url('/menu_images/' . 
                        $menu->image) . '">
                        <br>
                        ' . $menu->name . '
                        <br>
                        $' . number_format($menu->price, 2) . 
                    '</a></div>';
        }

        return $html;
    }

    public function orderFood(Request $request) {

        $menu = Menu::findOrFail($request->menu_id);

        $table_id = $request->table_id;
        $table_name = $request->table_name;

        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
    

        if ($sale) {
            //sale already exists for this table which has not been paid
            $sale_id = $sale->id;

        } else {
            //sale doesn't exist so create
            $user = Auth::user();

            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();

            $sale_id = $sale->id;
            
            $table = Table::findOrFail($table_id);
            $table->status = "unavailable";
            $table->save();

        }
      
        // add ordered menu to the sales-details table
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->menu_name = $menu->name; 
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();
        
        //update total price in sales table
        $sale->total_price = $sale->total_price + ($request->quantity * $menu->price);
        $sale->save();

        return $sale->total_price;
    }
}
