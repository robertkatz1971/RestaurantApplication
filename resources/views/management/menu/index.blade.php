
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('management.include.sidebar')
            <div class="col-md-8">
                <i class="fas fa-utensils"></i> Menu List..
                <a class="btn btn-success btn-sm float-right" href={{ route('menu.create') }}>
                    <i class="fa fa-plus"></i> Create Menu
                </a>
                <hr>
                @if(Session()->has('status'))
                    <div class="alert alert-success">
                        {{ Session()->get('status') }}
                        <button type="button" class="close" data-dismiss="alert">X</button>
                    </div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Image</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    @foreach ($menus as $menu)
                        <tr>
                            <th scope="row">{{ $menu->id  }}</th>
                            <td>{{ $menu->name }}</td>
                            <td>{{ $menu->price }}</td>
                            <td>
                                <img src="{{asset('menu_images')}}/{{$menu->image }}" alt="{{ $menu->name }}"
                                    width="120px" height="120px" class="img-thumbnail">
                            </td>
                            <td>{{ $menu->category->name }}</td>
                            <td>{{ $menu->description }}</td>

                            <td>
                                <a href="{{ route('menu.edit', ['menu' => $menu]) }}" 
                                    class="btn btn-warning">Edit
                                </a>
                            </td>
                            <td>
                                <form action="{{ route('menu.destroy', ['menu' => $menu]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>   
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{ $menus->links() }}
            </div>
        </div>      
    </div>

    @endsection