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
<style>
    #total_weight{
        height:20px;
        background: #444;
        color:#fff;
        padding:1px 5px;
        border-radius:5px;
        margin-left:5px;
    }
</style>


   <!--  <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
    <section class="content">
      <div id="app">
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
             <form action="{{URL::to('/store_formula')}}" method="POST" id="formula_store_form">
                {{ csrf_field()}}
                <!-- Code Here.... -->

                    <div class="row">
                        @isset($f_type)
                        <div class="col-md-4">
                            <div class="change_passport_body" style="width: 100% !important;">

                                <p class="form_title_center">
                                </p>

                                <div class="form-group">
                                        <label for="form_date"><i> Formula Name </i></label>
                                        <input type="text" class="form-control" id="formula_name" name="formula_name"  autocomplete="off" required >

                                </div>

                            </div>
                        </div>
                        @endisset
                        <div class="col-md-8">
                            <div class="table_view" style="padding: 10px">
                                    <div class="row">
                                        <!--START Multiple form used here /// -->
                                        <div class="col-md-9">
                                            {{Form::select('filter_formula_type',$product_types,@$f_type,['class'=>'form-control','placeholder'=>'Select Formula Type','form'=>'filter_product_type'])}}
                                        </div>

                                        <div class="col-md-3">
                                            <input type="submit" value="Filter" class="form-control btn btn-success btn-sm" form="filter_product_type">
                                        </div>
                                        <!--END Multiple form used here /// -->
                                    </div>
                                    <br>
                                @isset($f_type)
                                    <div class="table-repsonsive">
                                    <span id="error"></span>
                                        <table class="table table-bordered" id="item_table">
                                        <tr>
                                        <th>Product Name</th>
                                            <th>Product Weight <span id="total_weight"></span></th>
                                        <th>Unit</th>
                                        <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="glyphicon glyphicon-plus"></span></button></th>
                                        </tr>
                                        </table>
                                        <input name="formula_type" type="hidden" value="{{$f_type}}" required>
                                        <input id="total_weight_hidden" type="hidden" value="0" >
                                        <input type="hidden" name="dsd" required>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                    @isset($f_type)
                    <div class="row">
                      <div class="col-md-12  text-center">
                            <div class="form-group">
                                <button id="formula_submit" class="btn btn-success btn-submit">Submit</button>
                            </div>
                      </div>
                   </div>
                   @endisset
            </form>

                    <br>
                </div>
            </div>
        </div>
      </div>
    </section>

    <script type="text/javascript" src="{{asset('public/assets/js/vue.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/assets/js/axios.js')}}"></script>
    <script type="text/javascript">
      var app = new Vue({
          el:'#app',
          data:{
              vlaue:0,
          },
          methods:{
            totalWeightFunc:function(){
              console.log('ff');
            }
          },
          watch:{

          }
      });
    </script>

<script>

$(document).ready(function(){

 $(document).on('click', '.add', function(){
  var html = '';
  html += '<tr>';
  html += '<td><select  name="product_name[]" class="form-control product_name"><option value="">Select Product Name</option><?php echo $output; ?></select></td>';
  html += '<td><input  type="number" id="product_weight" name="product_weight[]" class="form-control product_weight" /></td>';
  html += '<td><select required name="unit_name[]" class="form-control unit_name"><option selected>gm</option><option>ltr</option></select></td>';
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


<script>

    $('#formula_submit').hide();
    $('#total_weight').hide();
    $(document).on("change",".product_weight",function(){
        var sum = 0;
        $("input[class *= 'product_weight']").each(function(){
           sum += +$(this).val();
        });
        document.getElementById('total_weight').innerText = sum;
        document.getElementById('total_weight_hidden').value = sum;
        if(sum == 1000){
            $('#formula_submit').show();
        }
        else{
            $('#formula_submit').hide();
        }

        if(sum > 0){
            $('#total_weight').show();
        }

    });


</script>



@endsection
