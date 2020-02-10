@extends('admin.master')
<!--Page Title-->
@section('page-title')
    View Formula
@endsection

<!--Page Header-->
@section('page-header')
    View Formula  (<a href="{{URL::to('/addformula')}}">Add Formula</a>)
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

                        <div class="col-md-6 col-md-offset-6">
                            <form action="{{url::to('viewformula')}}" method="post">
                                {{csrf_field()}}
                                <div class="col-md-9">
                                    {{Form::select('filter_formula_type',@$filter_formulas,null,['class'=>'form-control','id'=>'filter_formula_type','placeholder'=>'Select Formula Type'])}}
                                </div>
                                <div class="col-md-3">
                                    <input type="submit" value="Search Filter" class="form-control btn btn-info btn-sm">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="table_view" style="padding: 10px">
                                <div class="panel-body">
                                    <table width="100%" id="addproductpage" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Formula Name</th>
                                            <th scope="col">Formula Type</th>
                                            <th scope="col">Total Product</th>
                                            <th scope="col">Total Weight</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; @endphp
                                            @foreach($show_formula as $get_formula)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_formula->formula_name}}</td>
                                            <td scope="col">{{@$get_formula->getFormulaType->product_type}}</td>
                                            <td scope="col">{{$get_formula->total_product}}</td>
                                            <td scope="col">{{$get_formula->total_weight}} KG</td>
                                            <td scope="col">
                                                <a href="{{url::to('/editformula/'.$get_formula->formula_name)}}"><button class="btn btn-warning">View </button></a>
                                                <a onclick="return confirm('Are you sure want to delete this?');" href="{{url::to('/deleteformula/'.$get_formula->formula_name)}}"><button class="btn btn-danger">Delete</button></a>
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
@endsection
