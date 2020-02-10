@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Supplier
@endsection

<!--Page Header-->
@section('page-header')
    Add Product Type (<a href="{{URL::to('/viewmachine')}}">View Machine</a>)
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
                                        <i> View Product Type </i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <table class="table table-responsive table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>SL</th>
                                                            <th>Product Type</th>
                                                            <th>Weight Machine</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @isset($all_product_type)
                                                        @foreach($all_product_type as $product_type)
                                                            <tr>
                                                                <td>{{$loop->iteration }}</td>
                                                                <td>{{$product_type->product_type}}</td>
                                                                <td>{{@$product_type->getMachineName->machine_name }}</td>
                                                                <td><a href="{{ URL::to('producttype/edit/'.$product_type->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> <a href="{{ URL::to('producttype/delete/'.$product_type->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                            @endforeach
                                                        @endisset
                                                    </tbody>
                                                </table>
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