@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="list-group">
                <a class="list-group-item list-group-item-action" href={{ route('category.index') }}>
                    <i class="fas fa-bars"></i> Category
                </a>
                <a class="list-group-item list-group-item-action" href="">
                    <i class="fas fa-utensils"></i> Menu
                </a>
                <a class="list-group-item list-group-item-action" href="">
                    <i class="fas fa-receipt"></i> Table
                </a>
                <a class="list-group-item list-group-item-action" href="">
                    <i class="far fa-user"></i> User
                </a>
            </div>
        </div>
        <div class="col-md-8">
            <i class="fas fa-bars"></i> Edit Category
            <hr>
            <form action="{{ route('category.update', ['category' => $category]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Category Name </label>
                    <input type="text" name="name" class="form-control" value={{ $category->name }} >
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