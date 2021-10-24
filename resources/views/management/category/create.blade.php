@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('management.include.sidebar')
        <div class="col-md-8">
            <i class="fas fa-bars"></i> Create a New Category
            <hr>   
            <form action="{{ route('category.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ old('name') ?? 'Category Name...' }}">
                    @error('name')
                        <div class="alert alert-danger mt-2">{{ $message }}</div> 
                    @enderror

                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </div>
            </form>
        </div>      
    </div>
</div>

@endsection