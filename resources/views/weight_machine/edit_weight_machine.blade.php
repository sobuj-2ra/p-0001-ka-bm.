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
                            <!-- Code Here.... -->
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="change_passport_body" style="width: 100% !important;">
                                        {{ csrf_field()}}
                                        <p class="form_title_center">
                                        <i> Add Weigh Machine </i>
                                        </p>

                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3" >
                                                @isset($edit_machines)
                                                <form action="{{URL::to('weightmachine/update')}}" method="POST">
                                                    {{csrf_field()}}
                                                    <div class="form-group">
                                                        <label for="add_weight_machine_name">Add Weight Machine Name</label>
                                                        <input name="weight_machine_name" type="text" id="weight_machine_name" class="form-control" value="{{$edit_machines->machine_name}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="add_weight_machine_host">Add Weight Machine Host</label>
                                                        <input name="weight_machine_host" type="text" id="weight_machine_name" class="form-control" value="{{$edit_machines->machine_host}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="add_weight_machine_port">Add Weight Machine Port</label>
                                                        <input name="weight_machine_port" type="number" id="weight_machine_name" class="form-control" value="{{$edit_machines->machine_port}}">
                                                    </div>
                                                        <input name="weight_machine_id" type="hidden" id="weight_machine_id"  value="{{$edit_machines->id}}">

                                                    <div class="form-group">
                                                        <input type="submit" id="add_weight_machine_name" class="form-control btn btn-info">
                                                    </div>

                                                </form>
                                                    @endisset
                                            </div>
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