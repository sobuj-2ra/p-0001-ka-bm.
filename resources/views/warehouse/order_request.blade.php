@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Order Request
@endsection

<!--Page Header-->
@section('page-header')
    Order Request
@endsection

<!--Page Content Start Here-->
@section('page-content')


    <?php
    //print_r($show_product);


    $output = '';
    foreach ($show_product as $row) {
        $output .= '<option value="' . $row["id"] . '">' . $row["product_name"] . '</option>';
    }

    //print_r($output);





    ?>

    <style>
        td {
            width: 42%;
            padding: 5px;
        }
    </style>


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


                    <form action="{{URL::to('/store_order_request')}}" method="POST">
                    {{ csrf_field()}}
                    <!-- Code Here.... -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="change_passport_body" style="width: 100% !important;">

                                    <p class="form_title_center">
                                    </p>


                                    <div class="form-group">
                                        <label for="form_date"><i>Order Ref/No</i></label>
                                        <input type="text" class="form-control" id="order_ref_no" name="order_ref_no"
                                               autocomplete="off" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="form_date"><i>Customer Name:</i></label>
                                        <select required class="form-control selectpicker" name="customer_id"
                                                style="width: 100%;" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Customer</option>
                                            @foreach ($customer as $getcustomer)
                                                <option value="{{ $getcustomer->id }}"> {{ $getcustomer->company_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label for="formula_type"><i>Formula Type:</i></label>
                                        {{Form::select('formula_type',$formula_types,null,['id'=>'formula_type','class'=>'form-control','placeholder'=>'Formula Type'])}}
                                    </div>
                                    <div class="form-group">
                                        <label for="form_date"><i>Formula Name:</i></label>
                                        <select required class="form-control formula_name" name="formula_id"
                                                id="formula_id" style="width: 100%;" data-show-subtext="true"
                                                data-live-search="true">
                                            {{--<option value="">Select Formula</option>--}}
                                            {{--@foreach ($show_formula as $get_formula)--}}
                                                {{--<option value="{{ $get_formula->formula_name }}"> {{ $get_formula->formula_name }} </option>--}}
                                            {{--@endforeach--}}
                                        </select>
                                    </div>



                                    <div class="form-group" id="formula_div">
                                        <label for="form_date"><i>Total Weight (gm)</i></label>
                                        <input type="text" class="form-control" id="total_weight_count"
                                               name="total_weight" autocomplete="off" required>
                                        <a style="float: right;background-color: #5e8080;color: white;padding: 4px;margin: 5px 0px;CURSOR: POINTER;"
                                           id="total_weight">Click Calculation</a>
                                    </div>


                                    <div class="form-group">
                                        <label for="form_date"><i>Date</i></label>
                                        <!-- <input type="text" class="form-control" id="bar_code" name="bar_code"  autocomplete="off" required >  -->

                                        <input type="text" class="datepicker form-control" data-date-format="dd/mm/yyyy"
                                               name="request_date" id="selected_date" autocomplete="off">


                                    </div>

                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="table_view" style="padding: 10px">

                                    <div class="table-repsonsive">
                                        <span id="error"></span>
                                        <table class="table table-bordered" id="item_table">
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Formula Weight</th>
                                                <th>Product Weight</th>
                                                <th>Unit Name</th>
                                                <th>
                                                   <!-- <button type="button" name="add" class="btn btn-success btn-sm add" id="add_product_field">
                                                        <span class="glyphicon glyphicon-plus"></span></button> -->
                                                </th>
                                            </tr>
                                        </table>

                                        <table class="table table-bordered" id="get_something">

                                        </table>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12  text-center">
                                <div class="form-group">
                                    <button class="btn btn-success btn-submit">Submit</button>
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
        $(document).ready(function () {

            $('#formula_type').change(function(){
                var f_type = $(this).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:'ajax_order_request_f_type',
                    type:'post',
                    data:{_token:_token,f_type:f_type},
                    success:function(res){
                        $('#formula_id').html(res.data);
                        $('#filter_product_name').html(res.products);
                        console.log(res.products);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });

            $('#add_product_field').click(function(){
                var f_type = $('#formula_type').val();
                var _token = $('input[name="_token"]').val();
                console.log(f_type);
                $.ajax({
                    url:'ajax_order_request_filter_product_type',
                    type:'post',
                    data:{_token:_token,f_type:f_type},
                    success:function(res){
                        $('#filter_product_name').html(res.products);
                        console.log(res.products);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            });

            $('#formula_div').hide();

            $('#formula_id').change(function () {
                //alert ("hi");
                $('#formula_div').show();
            });


            $('#total_weight').click(function () {
                var formula_id = $("#formula_id").val();
                var total_weight = $("#total_weight_count").val();
                // alert(formula_id);

                $.ajax({
                    type: 'GET',
                    url: '{{URL::to('/ajaxRequest_totalweight')}}',
                    data: {total_weight: total_weight, formula_id: formula_id},
                    success: function (data) {
                        // alert(data);
                        $("#get_something").html(data);
                    }
                });


            });


            $(document).on('click', '.add', function () {
                var html = '';
                html += '<tr>';
                html += '<td style="width:50%"><select required name="product_name[]" class="form-control product_name" id="filter_product_name><option value="">Select Product Name</option><?php echo $output; ?></select></td>';
                html += '<td style="width:15%"><input  type="text" readonly class="form-control" /></td>';
                html += '<td style="width:17%"><input required type="text" name="product_weight[]" class="form-control product_weight" /></td>';
                html += '<td style="width:13%"><select required name="unit_name[]" class="form-control unit_name"><option>gm</option></select></td>';
                html += '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove"><span class="glyphicon glyphicon-minus"></span></button></td></tr>';
                $('#item_table').append(html);
            });
            0.

            $(document).on('click', '.remove', function () {
                $(this).closest('tr').remove();
            });

            $('#insert_form').on('submit', function (event) {
                event.preventDefault();
                var error = '';
                $('.item_name').each(function () {
                    var count = 1;
                    if ($(this).val() == '') {
                        error += "<p>Enter Item Name at " + count + " Row</p>";
                        return false;
                    }
                    count = count + 1;
                });

                $('.product_weight').each(function () {
                    var count = 1;
                    if ($(this).val() == '') {
                        error += "<p>Enter Item Quantity at " + count + " Row</p>";
                        return false;
                    }
                    count = count + 1;
                });

                $('.product_name').each(function () {
                    var count = 1;
                    if ($(this).val() == '') {
                        error += "<p>Select Unit at " + count + " Row</p>";
                        return false;
                    }
                    count = count + 1;
                });
                var form_data = $(this).serialize();
                if (error == '') {
                    $.ajax({
                        url: "insert.php",
                        method: "POST",
                        data: form_data,
                        success: function (data) {
                            if (data == 'ok') {
                                $('#item_table').find("tr:gt(0)").remove();
                                $('#error').html('<div class="alert alert-success">Item Details Saved</div>');
                            }
                        }
                    });
                } else {
                    $('#error').html('<div class="alert alert-danger">' + error + '</div>');
                }
            });

        });
    </script>


@endsection


