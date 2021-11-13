@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block mt-2" id="btn-show-tables">View All Tables</button>
        
            <div id="selected-table">
            </div>
            <div id="order-detail">
            </div>
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
                    .addClass('btn-primary');
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

        var selectedTableId = "";
        var selectedTableName = "";

        //detect button table click event to show table details
        $("#table-detail").on("click", ".btn-table", function () {
            selectedTableId = $(this).data('id');
            selectedTableName = $(this).data('name');
            $("#selected-table").html('<br /><h3>Table: ' + selectedTableName + '</h3><hr>');
            $.get("/cashier/getSaleDetailsByTable/" + selectedTableId, function(data) {
                $("#order-detail").html(data);
            })
        });

        //detect clicking on menu item and associate with table 
        $("#list-menu").on("click", ".btn-menu", function () {
            if (selectedTableId == "") {
                alert("You must select a table prior to choosing a menu item!");
            } else {
                var selectedMenuId = $(this).data('id');    
                
                $.ajax({
                    type: "POST",
                    data: {
                        "_token" : $('meta[name="csrf-token"]').attr('content'),
                        "menu_id" : selectedMenuId,
                        "table_id" : selectedTableId,
                        "table_name" : selectedTableName,
                        "quantity" : 1
                    },
                    url: "cashier/orderFood",
                    success: function (data) {
                        $("#order-detail").html(data);
                    }
                });
            }
        });

        $("#order-detail").on('click', ".btn-confirm-order", function () {
            var saleId = $(this).data("id");
            $.ajax({
                type: "POST",
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "sale_id" : saleId,
                },
                url: "/cashier/confirmOrderStatus",
                success: function(data) {
                    $("#order-detail").html(data);
                }
            });

        });

    });
</script>
@endsection
