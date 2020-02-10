@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Customer
@endsection

<!--Page Header-->
@section('page-header')
    Add Customer (<a href="{{URL::to('/viewcustomer')}}">View Customer</a>)
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
                             $headersubmittext='Edit Customer';
                             @$headersubmitlink=' (<a href="'.URL::to('/supplier').'">Add Customer</a>)';
                             $hiddenid='<input type="hidden" class="form-control" name="hiddenproductid" value="'.$edit_product->id.'" autocomplete="off" required >';
                            }else{
                            // echo "add page";
                             $formurl='<form action="'.URL::to('/storesupplier').'" method="POST">';
                             $submitlink='<button type="submit" id="submit" class="btn btn-info">Submit</button>';
                             $headersubmittext='Add Customer';
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

                                    {{ csrf_field()}}
                                    <div class="row">
                                        


										
									    <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="form_date"><i>Company ID:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->compnay_id}}" name="compnay_id"  autocomplete="off" required >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="form_date"><i>Company Name:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->supplier_name}}" name="supplier_name"  autocomplete="off" required >
                                            </div>
                                        </div>
										
										
										<div class="row" style="margin-left: 0px;">
										
										    <div class="col-md-6">
											      <div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Head Office Information</i></label>
																<hr/>
															</div>
														</div>	

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Contact Person Name:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Land Phone Number:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														
																												
														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Phone Number:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														
																														
														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Email:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>	

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Adrress:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>	

														
														
												  </div>
											</div>
											
										    <div class="col-md-6">
                                       
													<div class="col-md-12">
														<div class="form-group">
															<label for="form_date"><i>Factory Information</i></label>
															<hr/>
														</div>
													</div>	

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Contact Person Name:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Land Phone Number:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														
																												
														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Phone Number:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>
														
																														
														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Email:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>	

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Adrress:</i></label>
																<input type="text" class="form-control" value="{{@$edit_product->email}}" name="email"  autocomplete="off" required >
															</div>
														</div>	
													  
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