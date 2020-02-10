@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Add Supplier
@endsection

<!--Page Header-->
@section('page-header')
    Add Machine (<a href="{{URL::to('/viewmachine')}}">View Machine</a>)
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
                             $formurl='<form action="'.URL::to('/updatemachine').'" method="POST">';
                             $submitlink='<button type="submit" id="update" class="btn btn-info">UPDATE</button>';
                             $headersubmittext='Edit Machine';
                             @$headersubmitlink=' (<a href="'.URL::to('/addmachine').'">Add Machine</a>)';
                             $hiddenid='<input type="hidden" class="form-control" name="hiddenproductid" value="'.$edit_product->id.'" autocomplete="off" required >';
                            }else{
                            // echo "add page";
                             $formurl='<form action="'.URL::to('/storemachine').'" method="POST">';
                             $submitlink='<button type="submit" id="submit" class="btn btn-info">Submit</button>';
                             $headersubmittext='Add Machine';
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
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="form_date"><i>Machine Name:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->machine_name}}" name="machine_name"  autocomplete="off" required >
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="form_date"><i>Remarks:</i></label>
                                                <input type="text" class="form-control" value="{{@$edit_product->remarks}}" name="remarks"  autocomplete="off" required >
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