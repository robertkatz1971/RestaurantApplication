
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
           @include('management.include.sidebar')
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

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Category</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->id  }}</th>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('category.edit', ['category' => $category]) }}" 
                                class="btn btn-warning">Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('category.destroy', ['category' => $category]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>   
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $categories->links() }}
        </div>      
    </div>

    @endsection