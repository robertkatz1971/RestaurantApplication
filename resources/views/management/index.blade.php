
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
            <div class="col-md-8"></div>      
        </div>
    </div>

    @endsection