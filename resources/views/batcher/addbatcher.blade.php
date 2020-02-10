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
                    <div class="row">
                        <div class="col-md-5 col-md-offset-3">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i>- Add Batcher Product Order Request Wise -  </i>
                                </p>
                                 
                                <form action="{{URL::to('/batcher-store')}}" method="post">

                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        {{Form::select('ref_type',$product_types,@$f_type,['class'=>'form-control','id'=>'ref_type','placeholder'=>'Select Ref Type','form'=>'filter_product_type','required'=>'required'])}}
                                    </div>
                                    <div class="form-group">
                                        <label for="form_date"><i>Order Ref/No:</i></label>
                                   
                                        <select required class="form-control" id="order_ref_no" name="order_ref_no" style="width: 100%;" data-show-subtext="true" data-live-search="true" required>
                                        <option value="">Select Ref Name</option>
                                        {{--@foreach ($show_product_order as $getproductorder)--}}
                                                {{--<option value="{{ $getproductorder->order_ref_no }}"> {{ $getproductorder->order_ref_no }} </option>                        --}}
                                        {{--@endforeach--}}
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="footer-box">
                                        <button type="reset" class="btn btn-danger">RESET</button>
                                        <button type="submit" id="submit" class="btn btn-info pull-right">SUBMIT</button>
                                    </div>
                                </form>
                            </div>
                        </div>

       
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#ref_type').change(function(){
                var r_type = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:'ajax_order_request_r_type',
                    type:'post',
                    data:{_token:_token,r_type:r_type},
                    success:function(res){
                        $('#order_ref_no').html(res.data);
                        console.log(res);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });
        })
    </script>
@endsection