@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Raw Material
@endsection

<!--Page Header-->
@section('page-header')
    Add Raw Material
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
                        <?php
                          $getid=collect(request()->segments())->last();
                          $id=@$edit_product->id;
                          if($getid=$id){
                             //echo "edit page";
                             $submitlink='<button type="submit" id="update" class="btn btn-info pull-right">UPDATE</button>';
                             $headersubmittext='Edit Raw Material';
                             @$headersubmitlink=' (<a href="'.URL::to('/addproduct').'">Add Product</a>)';
                             $formurl='<form action="'.URL::to('/updateaddproduct').'" method="POST">';
                             $hiddenid='<input type="hidden" class="form-control" name="hiddenproductid" value="'.$edit_product->id.'" autocomplete="off" required >';

                            }else{
                            // echo "add page";
                             $submitlink='<button type="submit" id="submit" class="btn btn-info pull-right">STORE</button>';
                             $headersubmittext='Add Raw Material';
                             $formurl='<form action="'.URL::to('/storeaddproduct').'" method="POST">';
                          }
                        ?>

                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i>- <?=$headersubmittext;?> - <?= @$headersubmitlink; ?> </i>
                                </p>

                                  <?= $formurl;?>  <!-- form action -->
                                    {{ csrf_field()}}

                                    <?= @$hiddenid; ?>

                                    <div class="form-group">
                                        <label for="form_date"><i>Product Name:</i></label>
                                        <input type="text" class="form-control" name="product_name" value="{{@$edit_product->product_name}}" autocomplete="off" required >
                                    </div>
                                    <div class="form-group">
                                        <select required name="product_type" id="" class="form-control">
                                            <option value="">Select Type</option>
                                            @isset($product_types)
                                                @foreach($product_types as $product_type)
                                                    <option value="{{$product_type->id}}">{{$product_type->product_type}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>

                                    <input type="hidden" class="form-control" name="product_code" value="{{@$edit_product->product_code}}" autocomplete="off" required>
                                    <hr>
                                    <div class="footer-box">
                                        <button type="reset" class="btn btn-danger">RESET</button>
                                        <!--<button type="submit" id="submit" class="btn btn-info pull-right">STORE</button> -->
                                        <?=$submitlink;?>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table_view" style="padding: 10px">
                                <div class="row">
                                    <form action="{{url::to('addproduct')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="col-md-9">
                                            <select name="filter_product_type" id="filter_product_type" class="form-control">
                                                <option value="">Select Type</option>
                                                @isset($product_types)
                                                    @foreach($product_types as $product_type)
                                                        <option value="{{$product_type->id}}">{{$product_type->product_type}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="submit" value="Search" class="form-control btn btn-info btn-sm">
                                        </div>
                                    </form>
                                </div>

                                <div class="panel-body">
                                    <table width="100%" id="addproductpage" class="table-bordered table" style="font-size:14px;">
                                        <thead style="background:#ddd">
                                        <tr>
                                            <th scope="col">SL</th>
                                            <th scope="col">Raw Material Name</th>
                                            <th scope="col">Raw Material Type</th>
                                            <th scope="col">Product Code</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php $n=0; @endphp
                                            @foreach($show_product as $get_product)
                                            @php $n++; @endphp
                                            <tr>
                                            <td scope="col">{{$n}}</td>
                                            <td scope="col">{{$get_product->product_name}}</td>
                                            <td scope="col">{{@$get_product->getProducyType->product_type}}</td>
                                            <td scope="col">{{$get_product->product_code}}</td>
                                            <td scope="col">
                                                <a onclick="return confirm('Are you sure want to Reprint this?');" href="{{URL::to('reprint_product_code/'.$get_product->product_code)}}"><button class="btn btn-warning">Reprint </button></a>
                                                <a onclick="return confirm('Are you sure want to update this?');" href="{{route('editproduct',$get_product->id)}}"><button class="btn btn-warning">Edit </button></a>
                                                <a onclick="return confirm('Are you sure want to delete this?');" href="{{route('productdelete',$get_product->id)}}"><button class="btn btn-danger">Delete</button></a>
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
