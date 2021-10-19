
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
           @include('management.include.sidebar')
          <div class="col-md-8">
            <i class="fas fa-receipt"></i> Table List...
            <a class="btn btn-success btn-sm float-right" href={{ route('table.create') }}>
                <i class="fa fa-plus"></i> Create Table
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
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                @foreach ($tables as $table)
                    <tr>
                        <th scope="row">{{ $table->id  }}</th>
                        <td>{{ $table->name }}</td>
                        <td>
                            <a href="{{ route('table.edit', ['table' => $table]) }}" 
                                class="btn btn-warning">Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('table.destroy', ['table' => $table]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>   
                        </td>
                    </tr>
                @endforeach
            </table>
            {{ $tables->links() }}
        </div>      
    </div>

    @endsection