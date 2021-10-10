
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
            <i class="fas fa-bars"></i> Category List..
            <a class="btn btn-success btn-sm float-right" href={{ route('category.create') }}>
                <i class="fa fa-plus"></i> Create Category
            </a>
            <hr>
            @if(Session()->has('status'))
                <div class="alert alert-success">
                    {{ Session()->get('status') }}
                    <button type="button" class="close" data-dismiss="alert">X</button>
                </div>
            @endif
        </div>      
    </div>

    @endsection