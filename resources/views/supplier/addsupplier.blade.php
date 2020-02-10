@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Supplier
@endsection

<!--Page Header-->
@section('page-header')
    Add Supplier (<a href="{{URL::to('/viewsupplier')}}">View Supplier</a>)
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
                             $formurl='<form action="'.URL::to('/updatesupplier').'" method="POST">';
                             $submitlink='<button type="submit" id="update" class="btn btn-info">UPDATE</button>';
                             $headersubmittext='Edit Supplier';
                             @$headersubmitlink=' (<a href="'.URL::to('/supplier').'">Add Supplier</a>)';
                             $hiddenid='<input type="hidden" class="form-control" name="hiddenproductid" value="'.$edit_product->id.'" autocomplete="off" required >';
                            }else{
                            // echo "add page";
                             $formurl='<form action="'.URL::to('/storesupplier').'" method="POST">';
                             $submitlink='<button type="submit" id="submit" class="btn btn-info">Submit</button>';
                             $headersubmittext='Add Supplier';
                          }
                        ?>


                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                    <i> <?=$headersubmittext;?> <?= @$headersubmitlink; ?> </i>
                                </p>


                                    <?= $formurl;?>  <!-- form action -->
                                    <?= @$hiddenid; ?>
                                    <!-- $2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm -->
                                    {{ csrf_field()}}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Supplier Name:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->supplier_name}}" name="supplier_name"  autocomplete="off" required >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Phone Number:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->phone_number}}" name="phone_number"  autocomplete="off" required >
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Email:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" >
                                            </div>
                                        </div>



                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="form_date"><i>Country of Origin:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->country_of_origin}}" name="country_of_origin"  autocomplete="off"  >
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Address Line:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->address_line}}" name="address_line"  autocomplete="off" >
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="form_date"><i>City:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->city}}" name="city"  autocomplete="off" >
                                            </div>
                                        </div>



                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="form_date"><i>Post Code:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->postcode}}" name="postcode"  autocomplete="off" >
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="form_date"><i>country:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->country}}"name="country"  autocomplete="off" >
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                            <!-- <button type="submit" id="submit" class="btn btn-info">Submit</button>  -->
                                                <?=$submitlink;?>
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
@endsection
