<?php

namespace App\Http\Controllers\Cashier;

use App\Menu;
use App\Table;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                        $' . number_format($menu->price) . 
                    '</a></div>';
        }

        return $html;
    }

    public function orderFood(Request $request) {

        $menuId = $request->menu_id;
        return $menuId;
    }
}
