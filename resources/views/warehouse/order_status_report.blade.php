@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Order Request Report
@endsection

<!--Page Header-->
@section('page-header')
    Order Status Report
@endsection

<!--Page Content Start Here-->
@section('page-content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="main_part">
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-5">
                            <div style="margin: 10px; border: 2px solid #dddddd52; border-radius: 5px">
                                <div style="border-top: 5px solid #bd4747; padding: 5px; margin: 5px;">
                                    <h4 class="" style="margin: 0px;color: #292929eb;">Date To Date Search</h4>
                                    <hr>
                                    <form action="{{ URL::to('/order-status-report-search') }}" method="post" target="_blank">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="form_date"><i>Status:</i></label>
                                            <select required class="form-control" name="status"
                                                    style="width: 100%;" >
                                                <option value="Finish">Finish</option>
                                                <option value="Running">Running</option>
                                                <option value="Ready">Ready</option>
                                                <option value="Pending">Pending</option>
                                                <option value="All">All</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="form_date"><i>FORM DATE:</i></label>
                                            <input type="text" class="form-control datepicker"
                                                   value="<?php echo date('d-m-Y'); ?>" name="from_date"
                                                   data-date-format="dd/mm/yyyy" required autocomplete="off">
                                            <span id="status_response" style="font-size: 12px;float: right;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="to_date"><i>TO DATE:</i></label>
                                            <input type="text" class="form-control datepicker"
                                                   value="<?php echo date('d-m-Y'); ?>" name="to_date"
                                                   data-date-format="dd/mm/yyyy" required autocomplete="off">
                                        </div>
                                        <hr>
                                        <div class="footer-box">
                                            <button type="reset" class="btn btn-danger">RESET</button>
                                            <button type="submit" id="submit" class="btn btn-info pull-right">SUBMIT
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>

                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
@endsection