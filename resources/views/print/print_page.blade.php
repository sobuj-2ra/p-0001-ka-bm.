@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Print
@endsection

<!--Page Header-->
@section('page-header')
    Slip Print
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
                        <div class="col-md-6 col-md-offset-3">
                            <div class="change_passport_body"
                                 style="width: 80% !important;background-color: #18352600;">
                                <form action="{{URL::to('/store-slip-print')}}" method="POST">
                                {{ csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{Form::select('ref_type',$product_types,@$f_type,['class'=>'form-control','id'=>'ref_type','placeholder'=>'Select Ref Type','form'=>'filter_product_type','required'=>'required'])}}
                                            </div>
                                            <div class="form-group">
                                                <label for="form_date"><i>Order Ref. No:</i></label>
                                                <select required class="form-control " name="order_id" id="ref_no_field" style="width: 100%;" data-show-subtext="true" data-live-search="true" required placeholder="Select Ref. No">
                                                    <option value="">Select Ref. No</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="form_date"><i>Number of copy</i></label>
                                                <input type="number" class="form-control" min="1" step="1" id="" name="count"  autocomplete="off" required >
                                            </div>
                                            <div class="form-group">
                                                <label for="form_date"><i>Expiry Date</i></label>
                                                <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy" name="expiry_date" id="selected_date" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn  btn-success btn-submit">Print</button>
                                            </div>
                                        </div>
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
                        $('#ref_no_field').html(res.data);
                        //console.log(res);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });
        })
    </script>
@endsection