@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Details Product
@endsection

<!--Page Header-->
@section('page-header')
Show Product
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <form action="{{URL::to('productdetails')}}" method="POST">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            {{Form::select('product_type',$product_type,null,['class'=>'form-control','placeholder'=>'Select Product Type'])}}
                                        </div>
                                        <div class="form-group  pull-right">
                                            <input type="submit" class="btn btn-info">
                                        </div>
                                    </form>

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