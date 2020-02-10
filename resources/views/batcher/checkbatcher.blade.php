@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add batcher
@endsection

<!--Page Header-->
@section('page-header')
    Add batcher
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
                    <div class="row" id="load_page">



                        <div class="col-md-4" style="background-color: #18352600;">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i> - Ready To Batcher - </i>

                                </p>

								<a href="{{URL::to('/batcher')}}" class="btn btn-success">Add New Batcher</a>
								<hr/>
                                <form action="{{URL::to('/showbatcher')}}" method="POST">

                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        <table  width="100%" id="" class="table-bordered table">
										<tr style="color:#000000;font-weight:bold">
										   <td>Product Name</td>
										   <td>Product Weight</td>
										   <td>Status</td>
										</tr>
										@foreach($show_all_data as $get_data)
										<tr>
										   <td>
										   <input type="hidden" readonly class="form-control" required value="{{$get_data->id}}" name="product_id[]" />
										   <a style="color:#000000"> {{$get_data->product_name}} </a>
										   </td>
										   <td><a style="color:#000000"> {{$get_data->product_weight}} gm</a></td>
										   <td><a style="color:#000000">

                                           <?php if($get_data->status == 'Active'){ ?>
                                           <img src="{{asset('public/assets/img/Pan_Green_Circle.png') }}" height="28px" width="28px">
                                           <?php }else{ ?>
                                           <img src="{{asset('public/assets/img/Circle04-DarkRed.png') }}" height="30px" width="30px">
                                           <?php } ?>

                                          <!-- {{ $get_data->status === "Active" ? "Checked! OK" : "No Set" }} -->

                                          </a></td>

                                        </tr>
										@endforeach
										</table>
                                    </div>

                                </form>
                            </div>
                        </div>


                        <div class="col-md-8">
                           <div class="row">
                              <div class="col-md-8 col-md-offset-1" style="background-color: #18352600;">


                              <?php $countdata=count($show_one_data); ?>

                              @if($countdata==0)

                              <h1 style="text-align:center"> All Checked OK !! <br/><br/> All Batcher Data Store and Checked Succesfully </h1><br>
                              <script type="text/javascript">
                                  window.open("{{URL::to("/print-barcode-unique/$order_ref_no/$unique_id")}}",'_blank')
                              </script>
                              <center><a target="_blank" href="{{URL::to("/print-barcode-unique/$order_ref_no/$unique_id")}}"><button id="bacher_barcode_print" class="btn btn-info">Print Barcode</button></a></center>

                               <?php @$show_one_data[0]->order_ref_no; ?>


                              @else

                              @foreach($show_one_data as $get_one_data)

                                <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i>- Product Check Order Wise -  </i>
                                </p>

                                <form action="{{URL::to('/showbatcher')}}" method="POST">

                                    {{ csrf_field()}}

                                    <div class="form-group">
                                        <label for="form_date"><i>Product Name</i></label>


                                            <div class="box">
                                            <div class="inner">
                                                <span> {{$get_one_data->product_name}}  [{{$get_one_data->product_weight}} gm]</span>
                                            </div>
                                            <div class="inner">
                                                <span> {{$get_one_data->product_name}}  [{{$get_one_data->product_weight}} gm]</span>
                                            </div>
                                            </div>

                                            <style>

                                            .box {
                                                display: flex;
                                            }

                                            .box .inner {
                                                width: 100%;
                                                height: 50px;
                                                line-height: 50px;
                                                font-size: 20px;
                                                font-family: sans-serif;
                                                font-weight: bold;
                                                white-space: nowrap;
                                                overflow: hidden;
                                            }

                                            .box .inner:first-child {
                                                width: 1%;
                                                background-color: #e9edef;
                                                color: #f7f3f3;
                                                transform-origin: right;
                                                transform: perspective(0px) rotateY(-5deg);
                                            }

                                            .box .inner:last-child {
                                                background-color: #ffffff73;
                                                color: black;
                                                transform-origin: left;
                                                transform: perspective(100px) rotateY(1deg);
                                            }

                                            .box .inner span {
                                                position: absolute;
                                                animation: marquee 15s linear infinite;
                                            }

                                            .box .inner:first-child span {
                                                animation-delay: 2.5s;
                                                left: -100%;
                                            }

                                            @keyframes marquee {
                                                from {
                                                    left: 100%;
                                                }

                                                to {
                                                    left: -100%;
                                                }
                                            }
                                            </style>

                                  <a  class="form-control_" style="color:blue;text-align:center; font-size:20px">{{$get_one_data->product_name}}  [{{$get_one_data->product_weight}} gm] </a>
                                        <input type="hidden" id="product_name_verify" value="{{$get_one_data->product_name}}">
                                        <input type="hidden" id="product_weight_verify" value="{{$get_one_data->product_weight}}">
                                  <br/>
                                    </div>

                                    <div class="form-group">
                                        <label for="form_date"><i>Please Input Product Code</i></label>
                                        <input required type="text" class="form-control" id="barcode" name="barcode"/>
                                    </div>

                                    <div class="form-group" id="product_weight_div">
                                        <label for="form_date"><i>Product Weight</i></label>
                                        <input required type="hidden" class="form-control" value="{{$get_one_data->product_weight}}" id="get_product_weight"/>
                                        <input required type="hidden" class="form-control" value="{{$get_one_data->id}}" id="get_id"/>
                                        <input required type="text" class="form-control" id="product_weight"  name="product_weight" placeholder="Please Wait..."/>
                                        <input type="hidden"  id="data_holder" value=""/>
                                    </div>
                                </form>
                                </div>
                              @endforeach

                              @endif
                                  {{--@isset($weight_machines)--}}
                                      {{--@foreach($weight_machines as $weight_machine)--}}
                                          {{--<input type="checkbox" name="mechine_no" id="{{$weight_machine->machine_port}}" class="mechine_no_id" data="{{$weight_machine->machine_host}}">--}}
                                          {{--<label for="{{"mechine_no".$weight_machine->id}}">{{$weight_machine->machine_name}}</label>--}}
                                      {{--@endforeach--}}
                                  {{--@endisset--}}
                              </div>

                           </div>

                        </div>

                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="machine_host" value="{{@$weight_machineData->machine_host}}">
    <input type="hidden" id="machine_port" value="{{@$weight_machineData->machine_port}}">


<!-- Data trigger when press key -->
<script type="text/javascript">
    $(document).ready(function(){
        $("#product_weight").keypress(function(){
            $('#product_weight').change();
        });
    });
</script>

<script>
    $(function () {
    $('#product_weight').change(function (e) {

        if(this.value.replace(/[_-]/g, '').length === 0) {

         }else{
                    var get_product_weight = $("#get_product_weight").val();
                    var product_weight = $("#product_weight").val();
                    var get_id = $("#get_id").val();
                    console.log(get_id);
                    //alert (barcode);
                    e.preventDefault();

                    $.ajax({
                    type: 'GET',
                    url:'{{URL::to('/ajaxRequest_productweight')}}',
                    data:{get_product_weight:get_product_weight, product_weight:product_weight, get_id:get_id},
                    success: function (data) {
                        alert(data.success);
                        if(data.check == '1'){
                            $('#product_weight').val('');
                        }else{
                           //alert("redirect page");
                           //$("#load_page").load(" #load_page");
                           //window.location.href = data.redirect;
                           //window.location.href=window.location.href;
                           //$(".content").load(window.location + " .content");
                           location.reload();
                        }

                       // alert('data check sucessfully');
                    }
                    });
            }
    });

    });
</script>







<script>


    $(function () {
    $('#product_weight_div').hide();
    $('#barcode').change(function (e) {


        if(this.value.replace(/[_-]/g, '').length === 0) {

         }else{

                    var barcode = $("#barcode").val();
                    var p_name = $("#product_name_verify").val();
                    var p_weight = $("#product_weight_verify").val();
                    //alert (barcode);
                    e.preventDefault();

                    $.ajax({
                    type: 'GET',
                    url:'{{URL::to('/ajaxRequest_checkbarcode')}}',
                    data:{barcode:barcode,p_name:p_name,p_weight:p_weight},
                    success: function (data) {
                        alert(data.success);
                        if(data.check == '1'){
                            $('#barcode').val('');
                        }else{
                           $('#product_weight_div').fadeIn(200).show();
                           document.getElementById('product_weight').focus();

                            //var ref_type_id = document.getElementById('ref_type_id').value;

                            /// get data from mechine //
                            var dataFunc = function(){
                                var host = $('#machine_host').val();
                                var port = $('#machine_port').val();
                                $.ajax({
                                    type:'get',
                                    url:'{!! URL::to('/ajaxRequest_mechine_data_read') !!}',
                                    data:{port:port,host:host},
                                    success:function(res){
                                        console.log(res);
                                        document.getElementById('product_weight').value = res;
                                    },
                                    error:function(error){
                                        console.log(error)
                                    }
                                });

                            }

                            $(document).ready(function(){
                                setInterval(dataFunc,1000);
                            });

                        }


                       // alert('data check sucessfully');
                    }
                    });
            }
    });

    });
</script>


@endsection
