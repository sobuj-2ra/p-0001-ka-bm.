@extends('admin.master')
<!--Page Title-->
@section('page-title')
Stock In
@endsection

<!--Page Header-->
@section('page-header')
    Stock In
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
                                        <label for="form_date"><i>Bar Code</i></label>
                                        <input type="text" class="form-control" id="bar_code" name="bar_code"  autocomplete="off" required  placeholder="Press Enter">
                                    </div>

                                    <div class="form-group">
                                    </div>

                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table_view" style="padding: 10px">
<!-- 
<div class="the-return">
  [HTML is replaced when successful.]
</div> 
-->

<!-- <div id="yourSelectBox"></div>  -->


                                   <table width="100%" id="addproductpage_old" class="table-bordered table" style="font-size:14px;">
                                       
                                       <h3>Today Stock In Details </h3>
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


$('#bar_code').on('keydown', function (e) {
    if(e.which == 13){
        var bar_code = $("input[name=bar_code]").val();
        // alert(bar_code);

        //var password = $("input[name=password]").val();

        // var email = $("input[name=email]").val();

        // alert('yes got it');

        $.ajax({

            type:'GET',

            url:'{{URL::to('/ajaxRequest_stockin')}}',

            data:{bar_code:bar_code},

            success:function(data){
                $('#bar_code').val('');
                alert(data.success);
                //alert('yes got it 2');

                //var_dump(data.show);
                //var stockin=data.show;

                //  $('#yourSelectBox').val(data.show);

                // alert(data.show);

                $("#addproductpage_old").load(" #addproductpage_old");

                $("#yourSelectBox").append(JSON.stringify(data.show));

                $(".the-return").html(
                    //"Favorite beverage: " + data.show + "<br />Favorite restaurant:"
                    //"Favorite beverage Favorite restaurant"
                );

            }

        });
    }
});


</script>


@endsection


