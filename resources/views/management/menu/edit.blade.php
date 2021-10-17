@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('management.include.sidebar')
        <div class="col-md-8">
            <i class="fas fa-bars"></i> Edit Menu
            <hr>
            <form action="{{ route('menu.update', ['menu' => $menu]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Menu Name </label>
                    <input type="text" name="name" class="form-control" value="{{ $menu->name }}" >
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror

                    <label for="price" class="mt-2">Price</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="text" name="price" class="form-control" value="{{ $menu->price }}">
                    </div>
                    @error('price')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror
                    <div>
                        <img src="{{asset('menu_images')}}/{{$menu->image }}" alt="{{ $menu->name }}"
                                width="120px" height="120px" class="img-thumbnail">
                    </div>
                    <label for="image">Image</label>
                    <div class="input-group mb-3">
                        
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                       
                        <div class="custom-file">
                            <input type="file" name="image" class="form-control" 
                                class="custom-file-input" id=inputGroupFile >
                            <label for="inputGroupFile" class="custom-file-label">Choose File...</label>
                        </div>    
                    </div>
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror

                    <div class="form-group">
                        <label for="name">Description </label>
                        <input type="text" name="description" class="form-control" value="{{ $menu->description }}">
                    </div>

                    <div class="form-group">
                        <label for="category_id" class="mt-2">Category</label>
                        <select name="category_id" id="" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id === $menu->category_id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger mt-2">{{ $message }}</div> 
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </div>
            </form>
        </div>      
    </div>
</div>

@endsection