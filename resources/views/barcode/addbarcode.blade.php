@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Create Barcode
@endsection

<!--Page Header-->
@section('page-header')
    Create Barcode
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                       <br/>
                       @if(Session::has('message'))
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2  alert {{ Session::get('alert-class', 'alert-info') }}">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                            </div>
                        </div>
                        @endif


                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i>- Create Bar Code -  </i>
                                </p>
                                 
                                <form action="{{URL::to('/storebarcode')}}" method="POST">

                                    {{ csrf_field()}}

                                    <div class="form-group">
                                        <label for="form_date"><i>Supplier Name:</i></label>
                                        {{Form::select('supplier_name',$suppliers,null,['id'=>'supplier','class'=>'form-control','placeholder'=>'Select Supplier','required'=>'required'])}}
                                    </div>

                                    <div class="form-group">
                                        <label for="form_date"><i>Product Type:</i></label>
                                        {{Form::select('product_type',$product_types,null,['id'=>'product_type','class'=>'form-control','placeholder'=>'Product Type'])}}
                                    </div>
                                    <div class="form-group">
                                        <label for="form_date"><i>Product Name:</i></label>
                                        {{Form::select('product_id',$show_product,null,['id'=>'products_dropdwn','class'=>'form-control','placeholder'=>'Product Name','data-show-subtext'=>'true','data-live-search'=>'true'])}}

                                    </div>

                                    <div class="form-group">
                                        <label for="form_date"><i>Product Qty:</i></label>
                                        <input type="number" class="form-control" name="product_qty" value="" autocomplete="off" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="form_date"><i>Product Weight:</i></label>
                                        <input type="text" class="form-control" name="product_weight" value="25" autocomplete="off" required>
                                    </div>



                                    <div class="form-group">
                                        <label for="form_date"><i>Manufacture Date:</i></label>
                                        <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="manufacture_date" id="selected_date" autocomplete="off">      
                                    </div>

                                    <div class="form-group">
                                        <label for="form_date"><i>Expiry Date:</i></label>
                                        <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="expiry_date" id="selected_date" autocomplete="off" required> 
                                    </div>                           



                        
                                    <hr>
                                    <div class="footer-box">
                                        <button type="reset" class="btn btn-danger">RESET</button>
                                        <button type="submit" id="submit" class="btn btn-info pull-right">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-8">
  

                            <div class="table_view" style="padding: 0px">
                              <h3> Total Bar Code Print :<b> {{ $barcodeinsertcount }} </b> </h3>
                                <div class="panel-body">

                                    <table width="100%" id="showproduct_print_old" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Product Name</th>
                                            <th scope="col">Generate BarCode</th>
                                            <th scope="col">Generate Date</th>
                                            {{-- <th scope="col">Total Print</th> --}}
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                           <?php 
                                              // var_dump($showprintdata);
                                            ?>

                                            @php $n=0; @endphp
                                            @foreach($showprintdata as $get_product)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_product->product_name}}</td>
                                            <td scope="col">{{$get_product->product_qty}}</td>                                         
                                            <td scope="col">{{$get_product->created_at}}</td>                                         
                                            {{-- <td scope="col">{{$get_product->status}}</td>                                          --}}
                                            <td scope="col">
                                            <a onclick="return confirm('Are you sure want to Re-Print this?');" href="{{URL::to("/barcodereprint/$get_product->print_lock")}}"><button class="btn btn-warning">Re-Print </button></a>
                                            </td>                                         
                                            </tr>
                                            @endforeach



                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">


        /// filter dropdown by product type..//
        $(document).ready(function(){
            $('#product_type').change(function(){
                var p_type_id = $(this).val();
                var _token = $("input[name='_token']").val();
               $.ajax({
                   type:"post",
                   url:"{{url::to('ajax_product_type')}}",
                   data:{product_type:p_type_id,_token:_token},
                   success:function(res){
                       //console.log(res.data);
                       $('#products_dropdwn').html(res.data);
                   }
               });
            });
        });
    </script>
@endsection