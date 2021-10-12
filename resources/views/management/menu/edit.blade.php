@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('management.include.sidebar')
        <div class="col-md-8">
            <i class="fas fa-bars"></i> Edit Menu
            <hr>
            <form action="{{ route('menu.update', ['menu' => $menu]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Menu Name </label>
                    <input type="text" name="name" class="form-control" value={{ $menu->name }} >
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </div>
            </form>
        </div>      
    </div>
</div>

@endsection