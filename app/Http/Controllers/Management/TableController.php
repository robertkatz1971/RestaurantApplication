<?php

namespace App\Http\Controllers\Management;

use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Table::paginate(5);

        return view('management.table.index')
            ->with('tables', $tables);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('management.table.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tables|max:255'
        ]);

        Table::create(['name' => $request->name]);

        $request->session()->flash('status', $request->name . " saved successfully.");
        return redirect()->route('table.index');

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
    public function edit(Table $table)
    {
        return view('management.table.edit')->with('table', $table);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'name' => 'required|unique:tables|max:255'
        ]);

        $table->name = $request->name;
        $table->save();

        $request->session()->flash('status', $request->name . " updated successfully.");
        return redirect()->route('table.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Table $table)
    {
        $name = $table->name;
        $table->delete();
        
        $request->session()->flash('status', $name . " deleted successfully.");
        return redirect()->route('table.index');
    }
}
