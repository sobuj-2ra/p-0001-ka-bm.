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


<div class="container_custom">


<br/>
@if(Session::has('message'))
<div class="row">
      <div class="col-md-8 col-md-offset-2  alert {{ Session::get('alert-class', 'alert-info') }}">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      {{ Session::get('message') }}
      </div>
</div>
@endif

<form class="well form-horizontal" action="{{URL::to('/storecustomer')}}" method="POST">
      {{ csrf_field()}}
       <table class="table table-striped">
          <tbody>
             <tr>
                <td colspan="1">

                      <fieldset>

                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">Full Name</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="fullName" required name="fullName" placeholder="Full Name" class="form-control" required="true" autocomplete="off" value="" type="text"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                                <label class="control-label">Compnay Name</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input id="compnayName" required name="compnayName" placeholder="Compnay Name" class="form-control" required="true" autocomplete="off" value="" type="text"></div>
                            </div>
                         </div>


                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">Email</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input id="email" required name="email" placeholder="Email" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>


                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">Phone Number</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span><input id="phoneNumber"  required name="phoneNumber" placeholder="Phone Number" class="form-control" required="true" autocomplete="off" value="" type="text"></div>
                            </div>
                         </div>

                      </fieldset>

                </td>
                <td colspan="1">

                      <fieldset>


                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                            <label class="control-label">Address Line</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="addressLine" required name="addressLine" placeholder="Address Line 1" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">City</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="city" name="city" required placeholder="City" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">State/Province/Region</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="state" name="state" required placeholder="State/Province/Region" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">Postal Code/ZIP</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="postcode" name="postcode" required placeholder="Postal Code/ZIP" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <div class="col-md-12 inputGroupContainer">
                               <label class="control-label">Country</label> <br/>
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="country" name="country" required placeholder="Country" class="form-control" required="true" value="" autocomplete="off" type="text"></div>
                            </div>
                         </div>

                      </fieldset>
                </td>
             </tr>
          </tbody>
       </table>

        <div class="form-group">
            <div class="col-md-2 col-md-offset-5">
                <input  name="submit"  class="form-control btn-info" required="true" value="Submit" type="submit">
            </div>
        </div>   

    </form>


    </div>




@endsection