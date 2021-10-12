@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('management.include.sidebar')
        <div class="col-md-8">
            <i class="fas fa-utensils"></i> Create a New Menu
            <hr>
            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Menu Name </label>
                    <input type="text" name="name" class="form-control" placeholder="{{ old('name') ?? 'Menu Name...' }}">
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror

                    <label for="price" class="mt-2">Price</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" name="price" class="form-control" placeholder="{{ old('price') ?? 'Menu Price...' }}">
                    </div>
                    @error('price')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror

                    <label for="image">Image</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="image" class="form-control" 
                                class="custom-file-input" id=inputGroupFile>
                            <label for="inputGroupFile" class="custom-file-label">Choose File...</label>
                        </div>  
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Description </label>
                        <input type="text" name="description" class="form-control" placeholder="{{ old('description') ?? 'Description...' }}">
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="mt-2">Category</label>
                        <select name="category_id" id="" class="form-control">
                            @foreach ($categories as $category)
                                <option value={{ $category->id }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> 
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </div>
            </form>
        </div>      
    </div>
</div>

@endsection