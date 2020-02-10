@extends('admin.master')
<!--Page Title-->
@section('page-title')
Formula
@endsection

<!--Page Header-->
@section('page-header')
    Add Formula (<a href="{{URL::to('/viewformula')}}">View Formula</a>)
@endsection

<!--Page Content Start Here-->
@section('page-content')


<?php
//print_r($show_product);


 $output = '';
 foreach($show_product as $row)
 {
  $output .= '<option value="'.$row["id"].'">'.$row["product_name"].'</option>';
 }

 //print_r($output);





?>


   <!--  <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
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

                    <form action="{{url::to('addformula')}}" id="filter_product_type" method="post"> {{csrf_field()}}</form>
             <form action="{{URL::to('/store_formula')}}" method="POST">
                {{ csrf_field()}}
                <!-- Code Here.... -->

                    <div class="row">

                        <div class="col-md-8 col-md-offset-2">
                            <div class="table_view" style="padding: 10px">

                                    <br>
                                    <div class="table-repsonsive">
                                    <span id="error"></span>
                                    <h2 class="text-center">{{$formulas[0]->formula_name}}</h2>
                                        <table class="table table-bordered" id="item_table">
                                        <tr>
                                        <th>Product Name</th>
                                        <th>Product Weight</th>
                                        <th>Unit</th>
                                        </tr>
                                            @foreach($formulas as $formula)
                                                <tr>
                                                    <td>
                                                        <select required name="product_name[]" class="form-control product_name">
                                                            <option value="">{{@$formula->getProductName->product_name}}</option>
                                                        </select>
                                                    </td>
                                                    <td><input disabled required type="text" id="product_weight" name="product_weight[]" value="{{$formula->product_weight}}" class="form-control product_weight" /></td>
                                                    <td><select required name="unit_name[]" value="{{$formula->unit_name}}" class="form-control unit_name"><option>{{$formula->unit_name}}</option></select></td>
                                                </tr>
                                            @endforeach
                                            <input name="formula_type" type="hidden" value="{{@$f_type}}" required>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12  text-center">
                            <div class="form-group">
                            </div>
                      </div>
                   </div>
            </form>

                    <br>
                </div>
            </div>
        </div>
    </section>



<script>
$(document).ready(function(){

 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  html += '<td><select required name="product_name[]" class="form-control product_name"><option value="">Select Product Name</option><?php echo $output; ?></select></td>';
  html += '<td><input required type="text" id="product_weight" name="product_weight[]" class="form-control product_weight" /></td>';
  html += '<td><select required name="unit_name[]" class="form-control unit_name"><option>gm</option></select></td>';
  html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
  $('#item_table').append(html);
 });
 0.

 $(document).on('click', '.remove', function(){
  $(this).closest('tr').remove();
 });



 $('#product_weight').change(function () {
    var product_weight = $(this).val();
    alert(product_weight);
    //var moduleID = $('#moduleIdList').val();
});






 $('#insert_form').on('submit', function(event){
  event.preventDefault();
  var error = '';
  $('.item_name').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Item Name at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });

  $('.product_weight').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Enter Item Quantity at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });

  $('.product_name').each(function(){
   var count = 1;
   if($(this).val() == '')
   {
    error += "<p>Select Unit at "+count+" Row</p>";
    return false;
   }
   count = count + 1;
  });
  var form_data = $(this).serialize();
  if(error == '')
  {
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    success:function(data)
    {
     if(data == 'ok')
     {
      $('#item_table').find("tr:gt(0)").remove();
      $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
     }
    }
   });
  }
  else
  {
   $('#error').html('<div class="alert alert-danger">'+error+'</div>');
  }
 });

});
</script>


@endsection
