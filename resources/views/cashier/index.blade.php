@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row" id="table-detail"></div>
    <div class="row justify-content-center">
        <div class="col-md-5">
            <button class="btn btn-primary btn-block mt-2" id="btn-show-tables">View All Tables</button>
        </div>
        <div class="col-md-7"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#btn-show-tables").click(function(){
            $.get("/cashier/getTable", function(data) {
                $("#table-detail").html(data);
            })
        })
    });
</script>
@endsection
