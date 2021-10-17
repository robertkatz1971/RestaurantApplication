<?php

namespace App\Http\Controllers\Management;

use App\Menu;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::paginate(5);

        return view('management.menu.index')
            ->with('menus', $menus);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.menu.create')
            ->with('categories', Category::all()->sortBy('name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:menus,name|max:255',
            'price' => 'required|numeric|gt:0',
            'category_id' => 'required|numeric',
        ]);

        $imageName = "noImage.png"; //default image if none provided by user
        if ($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5000'
            ]);
            $imageName = date('mdYHis').uniqid(). '.' .$request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        }

        Menu::create([
            'name' => $request->name, 
            'price' => $request->price,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        $request->session()->flash('status', $request->name . " saved successfully.");
        return redirect()->route('menu.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {   
        return view('management.menu.edit')
            ->with('menu', $menu)
            ->with('categories', Category::all()->sortBy('name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'category_id' => 'required|numeric',
        ]);

        if ($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5000'
            ]);
            if ($menu->image != "noImage.png") {
                unlink(public_path('menu_images') . '/' . $menu->image);
            }
            $imageName = date('mdYHis').uniqid(). '.' .$request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
            $menu->image = $imageName;
        }

        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->category_id = $request->category_id;
        $menu->description = $request->description;
        
        $menu->update();

        $request->session()->flash('status', $request->name . " updated successfully.");
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Menu $menu)
    {
        $name = $menu->name;
        if ($menu->image != 'noImage.png') {
            unlink(public_path('menu_images') . '/' . $menu->image);
        }
        $menu->delete();
        
        $request->session()->flash('status',$name . " deleted successfully.");
        return redirect()->route('menu.index');

    }
}
