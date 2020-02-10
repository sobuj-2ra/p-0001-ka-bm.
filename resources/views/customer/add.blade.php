@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Customer
@endsection

<!--Page Header-->
@section('page-header')
    Add Customer 
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
                          $id=@$edit_company->id;
                          if($getid=$id){
                             //echo "edit page";
                             $formurl='<form action="'.URL::to('/updatecustomer').'" method="POST">';
                             $submitlink='<button type="submit" id="update" class="btn btn-info">UPDATE</button>';
                             $headersubmittext='Edit Customer';
                             @$headersubmitlink=' (<a href="'.URL::to('/customer').'">Add Customer</a>)';
                             $hiddenid='<input type="hidden" class="form-control" name="hiddenproductid" value="'.$edit_company->id.'" autocomplete="off" required >';
							 $compnayid=$edit_company->company_id;

							}else{
                            // echo "add page";
                             $formurl='<form action="'.URL::to('/storecustomer').'" method="POST">';
                             $submitlink='<button type="submit" id="submit" class="btn btn-info">Submit</button>';
							 $headersubmittext='Add Customer';
							 $datenowyear=date("y");
							 $compnayid=$datenowyear.''.@$showcustomerlastid[0]->id;
                          }
                        ?>


                <!-- Code Here.... -->
                    <div class="row">
                        <div class="col-md-12">

                            <div class="change_passport_body" style="width: 80% !important;background-color: #18352600;">

                                <p class="form_title_center">
                                    <i> <?=$headersubmittext;?> <?= @$headersubmitlink; ?> </i>
                                </p>


                                    <?= $formurl;?>  <!-- form action -->
                                    <?= @$hiddenid; ?>

                                    {{ csrf_field()}}
                                    <div class="row">


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Company ID:</i></label>
                                                <input type="text" readonly class="form-control" value="<?= @$compnayid; ?>" name="company_id"  autocomplete="off" required >
                                            </div>
                                        </div>


										<div class="col-md-8">
                                            <div class="form-group">
                                                <label for="form_date"><i>Company Name:</i></label> <span style="color:red">*</span>
                                                <input type="text" class="form-control" value="{{@$edit_company->company_name}}" name="company_name"  autocomplete="off" required >
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
																<input type="text" class="form-control" value="{{@$edit_company->head_contact_name}}" name="head_contact_name"  autocomplete="off" >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Land Phone Number:</i></label>
																<input type="number" class="form-control" value="{{@$edit_company->head_land_phone_number}}" name="head_land_phone_number"  autocomplete="off" >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Phone Number:</i></label> <span style="color:red">*</span>
																<input type="number" class="form-control" value="{{@$edit_company->head_phone_number}}" name="head_phone_number"  autocomplete="off" required >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Email:</i></label>
																<input type="email" class="form-control" value="{{@$edit_company->head_email}}" name="head_email"  autocomplete="off"  >
															</div>
														</div>

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Address:</i></label>
																<input type="text" class="form-control" value="{{@$edit_company->head_address}}" name="head_address"  autocomplete="off"  >
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
																<input type="text" class="form-control" value="{{@$edit_company->factory_contact_person_name}}" name="factory_contact_person_name"  autocomplete="off"  >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Land Phone Number:</i></label>
																<input type="number" class="form-control" value="{{@$edit_company->factory_land_phone_number}}" name="factory_land_phone_number"  autocomplete="off"  >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Phone Number:</i></label>
																<input type="number" class="form-control" value="{{@$edit_company->factory_phone_number}}" name="factory_phone_number"  autocomplete="off"  >
															</div>
														</div>


														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Email:</i></label>
																<input type="email" class="form-control" value="{{@$edit_company->factory_email}}" name="factory_email"  autocomplete="off"  >
															</div>
														</div>

														<div class="col-md-12">
															<div class="form-group">
																<label for="form_date"><i>Address:</i></label>
																<input type="text" class="form-control" value="{{@$edit_company->factory_address}}" name="factory_address"  autocomplete="off"  >
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
