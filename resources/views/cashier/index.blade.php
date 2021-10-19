@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block mt-2" id="btn-show-tables">View All Tables</button>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach ($categories as $category)
                        <a class="nav-items nav-link" data-toggle="tab" data-id="{{ $category->id }}" href="">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </nav>
            <div id="list-menu" class="row mt-2"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //make table hidden
        $("#table-detail").hide();

        //show all tables when click button
        $("#btn-show-tables").click(function(){
            if($("#table-detail").is(":hidden")) {
                $.get("/cashier/getTable", function(data) {
                    $("#table-detail").html(data);
                    $("#table-detail").slideDown('fast');
                    $("#btn-show-tables").html('Hide Tables')
                        .removeClass('btn-primary')
                        .addClass('btn-danger');
                })
            } else {
                $("#table-detail").slideUp('fast');
                $("#btn-show-tables").html('View All Tables')
                    .removeClass('btn-danger')
                    .addClass('btn-primary');;
            }
            
        })

        //load menu items by category
        $(".nav-link").click(function () {
            $.get("/cashier/getMenuByCategory/" + $(this).data("id"), function (data) {
                $("#list-menu").hide();
                $("#list-menu").html(data);
                $("#list-menu").fadeIn('fast');
            });
        });
    });
</script>
@endsection
