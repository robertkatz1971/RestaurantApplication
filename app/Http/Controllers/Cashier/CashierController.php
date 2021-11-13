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
            <br>';
            if ($table->status == 'available') {
                $html .= '<span class="badge badge-success">' . $table->name . '</span>';
            } else {
                $html .= ' <span class="badge badge-danger">' . $table->name . '</span>';
            }
            $html .= '</button>';

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
            $this->saveSale($table_id, $table_name);
        }
      
        $this->saveSaleDetails($sale, $menu, $request->quantity);

        return $this->getSaleDetails($sale_id);
   
    }

    private function saveSale($table_id, $table_name) {
         //sale doesn't exist so create
         $user = Auth::user();

         $sale = new Sale();
         $sale->table_id = $table_id;
         $sale->table_name = $table_name;
         $sale->user_id = $user->id;
         $sale->user_name = $user->name;
         $sale->save();
         
         $table = Table::findOrFail($table_id);
         $table->status = "unavailable";
         $table->save();
    }

    private function saveSaleDetails($sale, $menu, $quantity) {

        // add ordered menu to the sales-details table
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale->id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->menu_name = $menu->name; 
        $saleDetail->quantity = $quantity;
        $saleDetail->save();
        
        //update total price in sales table
        $sale->total_price = $sale->total_price + ($quantity * $menu->price);
        $sale->save();
    }

    public function getSaleDetailsByTable($table_id) {
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();

        $html = '';

        if($sale) {
            $sale_id = $sale->id;
            $html .= $this->getSaleDetails($sale_id);
        } else {
            $html .= "No sale details for the selected table";
        }

        return $html;
    }

    public function confirmOrderStatus (Request $request) {
        $saleId = $request->sale_id;

        $saleDetails = SaleDetail::where('sale_id', $saleId)->update([
            'status' => 'confirm'
        ]);

        $html = $this->getSaleDetails($saleId);

        return $html;
    }

    private function getSaleDetails($sale_id) {

        //list all sale details
        $html = '<p>Sale ID: ' . $sale_id . '</p>';
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
        $html .= 
        '<div class="table-responsive-md" style="overflow-y:scroll; width: 350px; height: 400px; ">
          <table class="table table-stripped table-dark">
            <thead>
                <tr>
                    <th scope="col">Menu</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                </tr>
            </thead> 
            <tbody>';
        
        $showBtnConfirm = $saleDetails->contains('status', 'noConfirm');

        foreach($saleDetails as $saleDetail) {
            $html .= '
             <tr>
                <td>' . $saleDetail->menu->name . '</td>
                <td>' . $saleDetail->quantity . '</td>
                <td>' . $saleDetail->menu_price . '</td>
                <td>' . ($saleDetail->menu_price * $saleDetail->quantity) . '</td>
                <td>' . $saleDetail->status . '</td>
             </tr>
             ';
        }
            
        $html .=  '</tbody></table></div>';

        $sale = Sale::find($sale_id);

        $html .= '<h3>Total: $' . number_format($sale->total_price, 2) . '</h3>';

        if ($showBtnConfirm) {
            $html .= '<button data-id="' . $sale_id . '" class="btn btn-warning btn-confirm-order">Confirm Order</button>';
        } else {
            $html .= '<button data-id="' . $sale_id . '" class="btn btn-success btn-pay-order">Pay Order</button>';
        }

        
        return $html;

    }
}
