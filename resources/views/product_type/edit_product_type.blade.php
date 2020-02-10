@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Supplier
@endsection

<!--Page Header-->
@section('page-header')
    Add Product Type (<a href="{{URL::to('/viewmachine')}}">View Product Type</a>)
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
                                <div class="col-md-12">

                                    <div class="change_passport_body" style="width: 100% !important;">
                                        {{ csrf_field()}}
                                        <p class="form_title_center">
                                        <i> Add Product Type</i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3" >
                                                @isset($edit_product_types)
                                                <form action="{{URL::to('producttype/update')}}" method="POST">
                                                    {{csrf_field()}}
                                                        <div class="form-group">
                                                            <label for="add_weight_machine_name">Add Product Type Name</label>
                                                            <input name="product_type_name" type="text" id="product_type_name" class="form-control" value="{{$edit_product_types->product_type}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_weight_machine_name">Machine No.</label>
                                                            {{Form::select('weight_machine',$weight_machines,$edit_product_types->machine_id,['class'=>'form-control','placeholder'=>'Select Weight Machine'])}}
                                                        </div>
                                                        <input name="product_type_id" type="hidden" id="product_type_id"  value="{{$edit_product_types->id}}">
                                                    <div class="form-group">
                                                        <input type="submit" id="product_type_submit" class="form-control btn btn-info">
                                                    </div>

                                                </form>
                                                @endisset
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
@endsection