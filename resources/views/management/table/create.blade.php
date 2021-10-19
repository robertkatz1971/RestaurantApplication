@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('management.include.sidebar')
        <div class="col-md-8">
            <i class="fas fa-receipt"></i> Create a New Table
            <hr>   
            <form action="{{ route('table.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Table Name</label>
                    <input type="text" name="name" class="form-control" placeholder="{{ old('name') ?? 'Table Name...' }}">
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