@extends('admin.master')
<!--Page Title-->
@section('page-title')
   Stock Out
@endsection

<!--Page Header-->
@section('page-header')
    Stock Out
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">



                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                </p>


								   <div class="form-group">
                                        <label for="form_date"><i>Order Ref/No:</i></label>
                                        <select class="form-control " id="order_ref_no" name="order_ref_no" style="width: 100%;" data-show-subtext="true" data-live-search="true">
                                        <option value="WIP">WIP</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label for="form_date"><i>Bar Code</i></label>
                                        <input type="text" class="form-control" id="bar_code" name="bar_code"  autocomplete="off" required >
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-success btn-submit">Submit</button>
                                    </div>

                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table_view" style="padding: 10px">


                                   <table width="100%" id="addproductpage_stockout" class="table-bordered table" style="font-size:14px;">

                                       <h3>Today Stock Out Details </h3>
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Total Bag</th>
                                            <th scope="col">Total Weight</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                            @php $n=0; @endphp
                                            @foreach($show_stockdata as $get_product)
                                            @php $n++; @endphp


                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_product->product_name}}</td>
                                            <td scope="col">{{$get_product->total_product_qty}}</td>
                                            <td scope="col">{{$get_product->total_product_weight}} KG</td>
                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>




                            </div>
                        </div>


                    </div>



                    <br>
                </div>
            </div>
        </div>
    </section>


<script type="text/javascript">

$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});


$(".btn-submit").click(function(e){

    e.preventDefault();

    //var order_ref_no = $("input[name=order_ref_no]").val();
   // var order_ref_no = e.options[e.selectedIndex].value;
    var order_ref_no = document.getElementById("order_ref_no").value;
    var bar_code = $("input[name=bar_code]").val();

    alert(order_ref_no);

    $.ajax({

       type:'GET',

       url:'{{URL::to('/ajaxRequest_stockout')}}',

       data:{bar_code:bar_code,order_ref_no:order_ref_no},

       success:function(data){
          $('#bar_code').val('');
          alert(data.success);
          $("#addproductpage_stockout").load(" #addproductpage_stockout");
       }

    });



});

</script>


@endsection
